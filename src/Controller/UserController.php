<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class UserController extends AbstractController
{

    /**
     * @Route("/api/user", name="api_users_get", methods={"GET"})
     */
    public function get_users(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        
        return $this->json($users, 200, [], ['groups' => 'user-get-list']);
    }

    /**
     * @Route("/api/user/login", name="api_user_login", methods={"POST"})
     */
    public function login_user(
        Request $request,
        JWTTokenManagerInterface $jwtTokenManager,
        SerializerInterface $serializer
    ) {
        $user_request = $request->getContent();
        $user_serialized = $serializer->deserialize($user_request, User::class, 'json');
        $email = $user_serialized->getEmail();
        $password = $user_serialized->getPassword();
        
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(["email" => $email, "password" => $password]);

        if (!$user instanceof User) {
            return $this->json([
                'status' => 404,
                'message' => "Le nom de compte ou le mot de passe est incorrect"
            ], 404);
        }

        $token = $jwtTokenManager->create($user);

        return new JsonResponse([ "token" => 'Bearer '.$token]);
    }

    /**
     * @Route("/api/user/create", name="api_user_create", methods={"POST"})
     */
    public function create_user(Request $request, SerializerInterface $serializer, EntityManagerInterface $emi, ValidatorInterface $validator)
    {
        $request_json = $request->getContent();

        try {
            $user = $serializer->deserialize($request_json, User::class, 'json');

            $user->setCreatedAt(new DateTime());

            $userEmail = $user->getEmail();

            $userfind = $this->getDoctrine()->getRepository(User::class)->findOneBy(["email" => $userEmail ]);

            if ($userfind instanceof User) {
                return $this->json([
                    'status' => 409,
                    'message' => "Un compte est déja associé à cette email : $userEmail"
                ], 409);
            }
            $errors = $validator->validate($user);

            if (count($errors) > 0) {
                return $this->json([
                    'status' => 400,
                    'message' => "L'email à déjà été utilisé"
                    ], 400);
            }

            $emi->persist($user);
            $emi->flush();

            return $this->json($user, 201, [], ['groups' => 'user-get-list']);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
