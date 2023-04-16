<?php

namespace App\Entity;

use App\Repository\LeaveResquestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeaveResquestRepository::class)]
class LeaveResquest
{
    const APPROVED = "APPROVED";
    const PENDING = "PENDING";
    const REFUSED = "REFUSED";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $StartDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $EndDate = null;

//    #[ORM\Column(length: 255)]
//    private ?string $typeConge = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Reason = null;

    #[ORM\ManyToOne(inversedBy: 'leaveResquests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'leaveResquests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypesConges $type = null;

//    #[ORM\Column(length: 255)]
//    private ?string $FirstName = null;
//
    #[ORM\Column(length: 255)]
    private ?string $state = self::PENDING;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->StartDate;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string|null $state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    public function setStartDate(\DateTimeInterface $StartDate): self
    {
        $this->StartDate = $StartDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->EndDate;
    }

    public function setEndDate(\DateTimeInterface $EndDate): self
    {
        $this->EndDate = $EndDate;

        return $this;
    }

//    public function getTypeConge(): ?string
//    {
//        return $this->typeConge;
//    }
//
//    public function setTypeConge(string $typeConge): self
//    {
//        $this->typeConge = $typeConge;
//
//        return $this;
//    }

    public function getReason(): ?string
    {
        return $this->Reason;
    }

    public function setReason(string $Reason): self
    {
        $this->Reason = $Reason;

        return $this;
    }

//    public function getFirstName(): ?string
//    {
//        return $this->FirstName;
//    }
//
//    public function setFirstName(string $FirstName): self
//    {
//        $this->FirstName = $FirstName;
//
//        return $this;
//    }
//
//    public function getLastName(): ?string
//    {
//        return $this->LastName;
//    }
//
//    public function setLastName(string $LastName): self
//    {
//        $this->LastName = $LastName;
//
//        return $this;
//    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getType(): ?TypesConges
    {
        return $this->type;
    }

    public function setType(?TypesConges $type): self
    {
        $this->type = $type;

        return $this;
    }
}
