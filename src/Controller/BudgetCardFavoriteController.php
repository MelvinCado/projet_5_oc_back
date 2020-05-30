<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\BudgetCard;
use App\Entity\BudgetCardsFavorite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class BudgetCardFavoriteController extends AbstractController
{
    /**
     * @Route("/api/favorite-budget-card/by-userId/{userId}", name="api_get_list_favorite_budget_card_by_user", methods={"GET"})
     */
    public function getFavriteBudgetCardByUser(int $userId)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(["id" => $userId]);
    
        return $this->json($user, 200, [], ['groups' => 'favorite-budget-card-get-list']);
    }

    /**
     * @Route("/api/favorite-budget-card/{id}", name="api_edit_favorite_budget_card", methods={"PATCH"})
     */
    public function editFavriteBudgetCard(int $id, Request $request, EntityManagerInterface $emi)
    {
        $req = json_decode($request->getContent(), true);

        $isFavorite = $req['isFavorite'];
        

        try {
            $budgetCardsFavorite = $this->getDoctrine()->getRepository(BudgetCardsFavorite::class)->findOneBy(["id" => $id]);
            
            $budgetCardsFavorite->setIsFavorite($isFavorite);

            $emi->persist($budgetCardsFavorite);
            $emi->flush();

            return $this->json($budgetCardsFavorite, 200, [], ["groups" => "favorite-budget-card-get-list"]);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'code' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // /**
    //  * @Route("/api/favorite-budget-card/create", name="api_favorite_budgetCard_create", methods={"POST"})
    //  */
    // public function createBudgetCard(Request $request, EntityManagerInterface $emi)
    // {
    //     $req = json_decode($request->getContent(), true);

    //     $userId = $req['userId'];
    //     $budgetCardId = $req['budgetCardId'];
        
    //     try {
    //         $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(["id" => $userId]);
    //         $budgetCard = $this->getDoctrine()->getRepository(BudgetCard::class)->findOneBy(["id" => $budgetCardId]);
            
    //         $newBudgetCardsFavorite = new BudgetCardsFavorite();
    //         $newBudgetCardsFavorite->setUser($user);
    //         $newBudgetCardsFavorite->setBudgetCard($budgetCard);
    //         $newBudgetCardsFavorite->setIsFavorite(false);

    //         $budgetCardsFavoriteFind = $this->getDoctrine()->getRepository(BudgetCardsFavorite::class)->findOneBy(["user" => $user, "budgetCard" =>$budgetCard ]);

    //         if ($budgetCardsFavoriteFind instanceof BudgetCardsFavorite) {
    //             return $this->json([
    //                 'code' => 409,
    //                 'message' => "Cette enveloppe est déja dans les favoris"
    //             ], 409);
    //         }

    //         $emi->persist($user);
    //         $emi->persist($budgetCard);
    //         $emi->persist($newBudgetCardsFavorite);
    //         $emi->flush();

    //         return $this->json($newBudgetCardsFavorite, 201, [], ["groups" => "deal-create"]);
    //     } catch (NotEncodableValueException $e) {
    //         return $this->json([
    //             'code' => 400,
    //             'message' => $e->getMessage()
    //         ], 400);
    //     }
    // }
}
