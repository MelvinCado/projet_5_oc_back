<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BudgetCardsFavoriteRepository")
 */
class BudgetCardsFavorite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"favorite-budget-card-get-list"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="favoriteBudgetCards", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BudgetCard", inversedBy="UsersFavorite", cascade={"persist"})
     * @Groups({"favorite-budget-card-get-list"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $budgetCard;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"favorite-budget-card-get-list"})
     */
    private $isFavorite;

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

    public function getIsFavorite(): ?bool
    {
        return $this->isFavorite;
    }

    public function setIsFavorite(bool $isFavorite): self
    {
        $this->isFavorite = $isFavorite;

        return $this;
    }
}
