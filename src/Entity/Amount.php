<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AmountRepository")
 */
class Amount
{
    const ADD_MONEY = 0;
    const REMOVE_MONEY = 1;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"amount-get-one","deal-create", "deals-get-list"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"amount-get-one","deal-create"})
     */
    private $money;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="amount", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Deal", mappedBy="amount", orphanRemoval=true)
     */
    private $deals;

    public function __construct()
    {
        $this->deals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(user $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Deal[]
     */
    public function getDeals(): Collection
    {
        return $this->deals;
    }

    public function addDeal(Deal $deal): self
    {
        if (!$this->deals->contains($deal)) {
            $this->deals[] = $deal;
            $deal->setAmount($this);
        }

        return $this;
    }

    public function removeDeal(Deal $deal): self
    {
        if ($this->deals->contains($deal)) {
            $this->deals->removeElement($deal);
            // set the owning side to null (unless already changed)
            if ($deal->getAmount() === $this) {
                $deal->setAmount(null);
            }
        }

        return $this;
    }
}
