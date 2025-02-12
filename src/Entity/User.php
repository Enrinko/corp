<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use function Sodium\add;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(
    fields: 'username',
    message: 'Пользователь с таким {{label}} уже существует',
)]
#[UniqueEntity(
    fields: 'phone',
    message: 'Пользователь с таким {{label}} уже существует',
)]
#[UniqueEntity(
    fields: 'email',
    message: 'Пользователь с таким {{label}} уже существует',
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateOfReg = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateOfUpd = null;

    #[ORM\Column]
    private ?bool $isAgreed = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?LegalUsers $legalUsers = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?IndividualUsers $individualUsers = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
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

    public function getDateOfReg(): ?\DateTimeInterface
    {
        return $this->dateOfReg;
    }

    public function setDateOfReg(\DateTimeInterface $dateOfReg): self
    {
        $this->dateOfReg = $dateOfReg;

        return $this;
    }

    public function getDateOfUpd(): ?\DateTimeInterface
    {
        return $this->dateOfUpd;
    }

    public function setDateOfUpd(\DateTimeInterface $dateOfUpd): self
    {
        $this->dateOfUpd = $dateOfUpd;

        return $this;
    }

    public function isIsAgreed(): ?bool
    {
        return $this->isAgreed;
    }

    public function setIsAgreed(bool $isAgreed): self
    {
        $this->isAgreed = $isAgreed;

        return $this;
    }

    public function getLegalUsers(): ?LegalUsers
    {
        return $this->legalUsers;
    }

    public function setLegalUsers(LegalUsers $legalUsers): self
    {
        // set the owning side of the relation if necessary
        if ($legalUsers->getUser() !== $this) {
            $legalUsers->setUser($this);
        }

        $this->legalUsers = $legalUsers;

        return $this;
    }

    public function getIndividualUsers(): ?IndividualUsers
    {
        return $this->individualUsers;
    }

    public function setIndividualUsers(IndividualUsers $individualUsers): self
    {
        // set the owning side of the relation if necessary
        if ($individualUsers->getUser() !== $this) {
            $individualUsers->setUser($this);
        }

        $this->individualUsers = $individualUsers;

        return $this;
    }
}
