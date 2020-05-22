<?php

namespace App\Controller;

use App\Entity\Amount;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class AmountController extends AbstractController
{

    /**
     * @Route("/api/amount/by-user/{userId}", name="api_get_one_amount", methods={"GET"})
     */
    public function get_amount_by_user(int $userId)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findBy(["id" => $userId])[0];
        return $this->json($user, 200, [], ['groups' => 'amount-get-one']);
    }

    /**
     * @Route("/api/amount/by-user/{userId}", name="api_amount_edit", methods={"PATCH"})
     */
    public function editAmount(int $userId, Request $request, EntityManagerInterface $emi)
    {
        $req = json_decode($request->getContent(), true);
        
        $money = $req['money'];
        $type = $req['type'];
        
        try {
            $user = $this->getDoctrine()->getRepository(User::class)->findBy(["id" => $userId])[0];
            $amount = $user->getAmount();

            if ($type === Amount::ADD_MONEY) {
                $amount->setMoney($amount->getMoney() + $money);
            } elseif ($type === Amount::REMOVE_MONEY) {
                $amount->setMoney($amount->getMoney() - $money);
            }
            
            $emi->persist($amount);
            $emi->flush();

            return $this->json([], 200);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
