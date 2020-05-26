<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BudgetCardsFavoriteRepository")
 */
class BudgetCardsFavorite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="favoriteBudgetCards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BudgetCard", inversedBy="UsersFavorite")
     * @ORM\JoinColumn(nullable=false)
     */
    private $budgetCard;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBudgetCard(): ?BudgetCard
    {
        return $this->budgetCard;
    }

    public function setBudgetCard(?BudgetCard $budgetCard): self
    {
        $this->budgetCard = $budgetCard;

        return $this;
    }
}
