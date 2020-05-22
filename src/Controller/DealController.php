<?php

namespace App\Controller;

use App\Entity\Deal;
use App\Entity\Amount;
use App\Entity\BudgetCard;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class DealController extends AbstractController
{

     /**
     * @Route("/api/deal/create", name="api_deal_create", methods={"POST"})
     */
    public function createBudgetCard(Request $request, EntityManagerInterface $emi)
    {
        $req = json_decode($request->getContent(), true);

        $type = $req['type'];
        $money = $req['money'];
        $budgetCardId = $req['budgetCardId'];
        $amountId = $req['amountId'];
        
        try {
            $amount = $this->getDoctrine()->getRepository(Amount::class)->findBy(["id" => $amountId])[0];
            $budgetCard = $this->getDoctrine()->getRepository(BudgetCard::class)->findBy(["id" => $budgetCardId])[0];
            
            $newDeal = new Deal();
            $newDeal->setType($type);
            $newDeal->setMoney($money);
            $newDeal->setAmount($amount);
            $newDeal->setBudgetCard($budgetCard);

            if ($type === Deal::AMOUNT_TO_BUDGETCARD) {
                $amount->setMoney( $amount->getMoney() - $money);
                $budgetCard->setCurrentMoney( $budgetCard->getCurrentMoney() + $money);
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
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
