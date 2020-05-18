<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"budget-card-create"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"budget-card-create"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"budget-card-create", "user-get-list"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"budget-card-create"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"budget-card-create", "budget-card-get-list", "user-get-list"})
     */
    private $username;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"budget-card-create", "user-get-list"})
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BudgetCard", mappedBy="user", orphanRemoval=true)
     * @Groups({"budget-card-get-list", "user-get-list"})
     */
    private $budgetCards;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Amount", inversedBy="user", cascade={"persist", "remove"})
     * @Groups({"user-get-list", "amount-get-one"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $amount;

    public function __construct()
    {
        $this->budgetCards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|BudgetCard[]
     */
    public function getBudgetCards(): Collection
    {
        return $this->budgetCards;
    }

    public function addBudgetCard(BudgetCard $budgetCard): self
    {
        if (!$this->budgetCards->contains($budgetCard)) {
            $this->budgetCards[] = $budgetCard;
            $budgetCard->setUser($this);
        }

        return $this;
    }

    public function removeBudgetCard(BudgetCard $budgetCard): self
    {
        if ($this->budgetCards->contains($budgetCard)) {
            $this->budgetCards->removeElement($budgetCard);
            // set the owning side to null (unless already changed)
            if ($budgetCard->getUser() === $this) {
                $budgetCard->setUser(null);
            }
        }

        return $this;
    }

    public function getAmount(): ?Amount
    {
        return $this->amount;
    }

    public function setAmount(Amount $amount): self
    {
        $this->amount = $amount;

        // set the owning side of the relation if necessary
        if ($amount->getUser() !== $this) {
            $amount->setUser($this);
        }

        return $this;
    }
}
