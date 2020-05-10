<?php

namespace App\Controller;

use App\Entity\BudgetCard;
use App\Entity\User;
use App\Repository\BudgetCardRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class BudgetCardController extends AbstractController
{
    /**
     * @Route("/api/budget-card/create", name="budget_card_create", methods={"POST"})
     */
    public function createBudgetCard(Request $request, EntityManagerInterface $emi)
    {
        $req = json_decode($request->getContent(), true);


        $title = $req['title'];
        $ceil = $req['ceil'];
        $limitDate = $req['limitDate'];
        $currentMoney = $req['currentMoney'];
        $userId = $req['userId'];

        try {
            $budgetCardToCreate = new BudgetCard();

            $user = $this->getDoctrine()->getRepository(User::class)->findBy(["id" => $userId]);

            $budgetCardToCreate->setTitle($title);
            $budgetCardToCreate->setCeil($ceil);
            $budgetCardToCreate->setLimitDate(new DateTime($limitDate));
            $budgetCardToCreate->setCurrentMoney($currentMoney);
            $budgetCardToCreate->setUser($user[0]);
            $budgetCardToCreate->setCreatedAt(new DateTime());

            $emi->persist($budgetCardToCreate);
            $emi->flush();

            return $this->json($budgetCardToCreate, 201, [], ["groups" => "budgetCard-create"]);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
