<?php

namespace App\Entity;

use App\Repository\LegalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LegalRepository::class)]
class Legal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $inn = null;

    #[ORM\Column(length: 255)]
    private ?string $companyName = null;

    #[ORM\OneToOne(mappedBy: 'legal', cascade: ['persist', 'remove'])]
    private ?LegalUsers $legalUsers = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInn(): ?string
    {
        return $this->inn;
    }

    public function setInn(string $inn): self
    {
        $this->inn = $inn;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getLegalUsers(): ?LegalUsers
    {
        return $this->legalUsers;
    }

    public function setLegalUsers(LegalUsers $legalUsers): self
    {
        // set the owning side of the relation if necessary
        if ($legalUsers->getLegal() !== $this) {
            $legalUsers->setLegal($this);
        }

        $this->legalUsers = $legalUsers;

        return $this;
    }
}
