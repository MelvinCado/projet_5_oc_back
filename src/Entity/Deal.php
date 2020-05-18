<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DealRepository")
 */
class Deal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\budgetCard", inversedBy="deals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $budgetCard;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\amount", inversedBy="deals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $amount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBudgetCard(): ?budgetCard
    {
        return $this->budgetCard;
    }

    public function setBudgetCard(?budgetCard $budgetCard): self
    {
        $this->budgetCard = $budgetCard;

        return $this;
    }

    public function getAmount(): ?amount
    {
        return $this->amount;
    }

    public function setAmount(?amount $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
