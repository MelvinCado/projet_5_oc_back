<?php

namespace App\Controller;

use App\Entity\Amount;
use DateTime;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{

    /**
     * @Route("/api/user", name="api_users_get", methods={"GET"})
     */
    public function get_users(UserRepository $userRepository)
    {
        return $this->json($userRepository->findAll(), 200, [], ['groups' => 'user-get-list']);
    }

    /**
     * @Route("/api/user/create", name="api_user_create", methods={"POST"})
     */
    public function create_user(
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $emi,
        UserPasswordEncoderInterface $encoder
    ) {
        $request_json = $request->getContent();

        try {
            $user = $serializer->deserialize($request_json, User::class, 'json');
            
            $userEmail = $user->getEmail();
            $userfind = $this->getDoctrine()->getRepository(User::class)->findOneBy(["email" => $userEmail ]);

            if ($userfind instanceof User) {
                return $this->json([
                    'code' => 409,
                    'message' => "Un compte est déja associé à cette email : $userEmail"
                ], 409);
            }

            $user->setCreatedAt(new DateTime());

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $newAmount = new Amount();
            $newAmount->setMoney(0);
            $user->setAmount($newAmount);

            $emi->persist($newAmount);
            $emi->persist($user);
            $emi->flush();
            
            return $this->json($user, 201, [], ['groups' => 'user-get-list']);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'code' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
