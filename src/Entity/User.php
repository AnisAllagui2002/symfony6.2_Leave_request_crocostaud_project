<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use  Symfony\Bridge\Doctrine\Validator\Constraints as Assert;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(
    fields: 'email',message: "This Email adress is used by someone"
)]
class User Implements PasswordUpgraderInterface, PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email()]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Assert\EqualTo(propertyPath: 'confirm_password')]
    private ?string $password = null;
    #[Assert\EqualTo(propertyPath: 'password')]
    private ?string $Confirm_password = null;

    /**
     * @return string|null
     */
    public function getConfirmPassword(): ?string
    {
        return $this->Confirm_password;
    }

    /**
     * @param string|null $Confirm_password
     */
    public function setConfirmPassword(?string $Confirm_password): void
    {
        $this->Confirm_password = $Confirm_password;
    }


    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: LeaveResquest::class)]
    private Collection $leaveResquests;

    public function __construct()
    {
        $this->leaveResquests = new ArrayCollection();
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        $user->setPassword($newHashedPassword);
    }

    public function getRoles(): array
    {
        if ($this->getRole() == 0 )
            return ['ROLE_USER'];
        else
            return ['ROLE_ADMIN'];
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return "";
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
            $leaveResquest->setUser($this);
        }

        return $this;
    }

    public function removeLeaveResquest(LeaveResquest $leaveResquest): self
    {
        if ($this->leaveResquests->removeElement($leaveResquest)) {
            // set the owning side to null (unless already changed)
            if ($leaveResquest->getUser() === $this) {
                $leaveResquest->setUser(null);
            }
        }

        return $this;
    }
}
