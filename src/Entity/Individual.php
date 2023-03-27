<?php

namespace App\Entity;

use App\Repository\IndividualRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IndividualRepository::class)]
class Individual
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\Column(length: 255)]
    private ?string $patronymic = null;

    #[ORM\OneToOne(mappedBy: 'individual', cascade: ['persist', 'remove'])]
    private ?IndividualUsers $individualUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    public function setPatronymic(string $patronymic): self
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    public function getIndividualUser(): ?IndividualUsers
    {
        return $this->individualUser;
    }

    public function setIndividualUser(IndividualUsers $individualUser): self
    {
        // set the owning side of the relation if necessary
        if ($individualUser->getIndividual() !== $this) {
            $individualUser->setIndividual($this);
        }

        $this->individualUser = $individualUser;

        return $this;
    }
}
