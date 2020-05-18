<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DealRepository")
 */
class Deal
{
    const AMOUNT_TO_BUDGETCARD = 0;
    const BUDGETCARD_TO_AMOUNT = 1;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"deal-create"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\budgetCard", inversedBy="deals")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"deal-create"})
     */
    private $budgetCard;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\amount", inversedBy="deals")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"deal-create"})
     */
    private $amount;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $money;

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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMoney(): ?int
    {
        return $this->money;
    }

    public function setMoney(int $money): self
    {
        $this->money = $money;

        return $this;
    }
}
