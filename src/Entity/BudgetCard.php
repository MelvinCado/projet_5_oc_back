<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BudgetCardRepository")
 */
class BudgetCard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({
     *   "budget-card-get-list",
     *   "deal-create",
     *   "favorite-budget-card-get-list",
     *   "favorite-budget-card-get-list",
     *   "deals-get-list"
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"budget-card-create",
     *   "budget-card-get-list",
     *   "deal-create",
     *   "favorite-budget-card-get-list",
     *   "deals-get-list"})
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"budget-card-create", "budget-card-get-list","deal-create", "favorite-budget-card-get-list"})
     */
    private $ceil;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"budget-card-create", "budget-card-get-list", "favorite-budget-card-get-list"})
     */
    private $limitDate;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"budget-card-create", "budget-card-get-list","deal-create", "favorite-budget-card-get-list"})
     */
    private $currentMoney;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"budget-card-create"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="budgetCards", cascade={"persist"})
     * @Groups({"budget-card-create"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Deal", mappedBy="budgetCard", orphanRemoval=true)
     */
    private $deals;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BudgetCardsFavorite", mappedBy="budgetCard", cascade={"remove"})
     */
    private $UsersFavorite;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->deals = new ArrayCollection();
        $this->UsersFavorite = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCeil(): ?int
    {
        return $this->ceil;
    }

    public function setCeil(int $ceil): self
    {
        $this->ceil = $ceil;

        return $this;
    }

    public function getLimitDate(): ?\DateTimeInterface
    {
        return $this->limitDate;
    }

    public function setLimitDate(\DateTimeInterface $limitDate): self
    {
        $this->limitDate = $limitDate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setBudgetCard($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getBudgetCard() === $this) {
                $user->setBudgetCard(null);
            }
        }

        return $this;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCurrentMoney(): ?int
    {
        return $this->currentMoney;
    }

    public function setCurrentMoney(int $currentMoney): self
    {
        $this->currentMoney = $currentMoney;

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
            $deal->setBudgetCard($this);
        }

        return $this;
    }

    public function removeDeal(Deal $deal): self
    {
        if ($this->deals->contains($deal)) {
            $this->deals->removeElement($deal);
            // set the owning side to null (unless already changed)
            if ($deal->getBudgetCard() === $this) {
                $deal->setBudgetCard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BudgetCardsFavorite[]
     */
    public function getUsersFavorite(): Collection
    {
        return $this->UsersFavorite;
    }

    public function addUsersFavorite(BudgetCardsFavorite $usersFavorite): self
    {
        if (!$this->UsersFavorite->contains($usersFavorite)) {
            $this->UsersFavorite[] = $usersFavorite;
            $usersFavorite->setBudgetCard($this);
        }

        return $this;
    }

    public function removeUsersFavorite(BudgetCardsFavorite $usersFavorite): self
    {
        if ($this->UsersFavorite->contains($usersFavorite)) {
            $this->UsersFavorite->removeElement($usersFavorite);
            // set the owning side to null (unless already changed)
            if ($usersFavorite->getBudgetCard() === $this) {
                $usersFavorite->setBudgetCard(null);
            }
        }

        return $this;
    }
}
