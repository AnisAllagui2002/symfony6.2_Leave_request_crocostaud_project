<?php

namespace App\Entity;

use App\Repository\TypesCongesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypesCongesRepository::class)]
class TypesConges
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column]
    private ?bool $paye = null;

    #[ORM\Column]
    private ?int $limite = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private ?\DateTimeInterface $unite = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: LeaveResquest::class)]
    private Collection $leaveResquests;

    public function __toString(): string
    {
       return $this->label;
    }

    public function __construct()
    {
        $this->leaveResquests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function isPaye(): ?bool
    {
        return $this->paye;
    }

    public function setPaye(bool $paye): self
    {
        $this->paye = $paye;

        return $this;
    }

    public function getLimite(): ?int
    {
        return $this->limite;
    }

    public function setLimite(int $limite): self
    {
        $this->limite = $limite;

        return $this;
    }

    public function getUnite(): ?\DateTimeInterface
    {
        return $this->unite;
    }

    public function setUnite(\DateTimeInterface $unite): self
    {
        $this->unite = $unite;

        return $this;
    }

    /**
     * @return Collection<int, LeaveResquest>
     */
    public function getLeaveResquests(): Collection
    {
        return $this->leaveResquests;
    }

    public function addLeaveResquest(LeaveResquest $leaveResquest): self
    {
        if (!$this->leaveResquests->contains($leaveResquest)) {
            $this->leaveResquests->add($leaveResquest);
            $leaveResquest->setType($this);
        }

        return $this;
    }

    public function removeLeaveResquest(LeaveResquest $leaveResquest): self
    {
        if ($this->leaveResquests->removeElement($leaveResquest)) {
            // set the owning side to null (unless already changed)
            if ($leaveResquest->getType() === $this) {
                $leaveResquest->setType(null);
            }
        }

        return $this;
    }
}
