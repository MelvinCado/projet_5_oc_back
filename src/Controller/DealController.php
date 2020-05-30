<?php

namespace App\Controller;

use App\Entity\Deal;
use App\Entity\User;
use App\Entity\Amount;
use App\Entity\BudgetCard;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class DealController extends AbstractController
{

    /**
    * @Route("/api/deal/by-userId/{userId}", name="api_deal_get", methods={"GET"})
    */
    public function getDealByUserId(int $userId, Request $request, EntityManagerInterface $emi)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findBy(["id" => $userId]);
        $deals = $this->getDoctrine()->getRepository(Deal::class)->findBy(["user" => $user]);

        return $this->json($deals, 200, [], ["groups" => "deals-get-list"]);
    }

    /**
    * @Route("/api/deal/create", name="api_deal_create", methods={"POST"})
    */
    public function createDeal(Request $request, EntityManagerInterface $emi)
    {
        $req = json_decode($request->getContent(), true);

        $type = $req['type'];
        $money = $req['money'];
        $budgetCardId = $req['budgetCardId'];
        $amountId = $req['amountId'];
        $userId = $req['userId'];
        
        try {
            $amount = $this->getDoctrine()->getRepository(Amount::class)->findOneBy(["id" => $amountId]);
            $budgetCard = $this->getDoctrine()->getRepository(BudgetCard::class)->findOneBy(["id" => $budgetCardId]);
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(["id" => $userId]);
            
            $newDeal = new Deal();
            $newDeal->setType($type);
            $newDeal->setMoney($money);
            $newDeal->setAmount($amount);
            $newDeal->setBudgetCard($budgetCard);
            $newDeal->setuser($user);
            $newDeal->setCreatedAt(new DateTime());

            if ($type === Deal::AMOUNT_TO_BUDGETCARD) {
                $amount->setMoney($amount->getMoney() - $money);
                $budgetCard->setCurrentMoney($budgetCard->getCurrentMoney() + $money);
            } else {
                $amount->setMoney($amount->getMoney() + $money);
                $budgetCard->setCurrentMoney($budgetCard->getCurrentMoney() - $money);
            }

            $emi->persist($amount);
            $emi->persist($budgetCard);
            $emi->persist($newDeal);
            $emi->flush();

            return $this->json($newDeal, 201, [], ["groups" => "deal-create"]);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'code' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
