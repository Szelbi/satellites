<?php

namespace App\User\Domain\Entity;

use App\Shared\Domain\Entity\Trait\IdTrait;
use App\Shared\Domain\Entity\Trait\TimestampableEntityTrait;
use App\User\Infrastructure\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Table('users')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use IdTrait;
    use TimestampableEntityTrait;

    #[ORM\Column(length: 255, options: ["default" => null])]
    private ?string $email = null;

    #[ORM\Column(type: "json", nullable: true)]
    private ?array $roles = ['ROLE_USER'];

    #[ORM\Column(length: 255, options: ["default" => null])]
    private ?string $password = null;

    #[ORM\Column(type: "boolean", options: ["default" => false])]
    private bool $emailVerified = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $verificationToken = null;


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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

    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isEmailVerified(): bool
    {
        return $this->emailVerified;
    }

    public function setEmailVerified(): static
    {
        $this->emailVerified = true;
        $this->verificationToken = null;

        return $this;
    }

    public function getVerificationToken(): ?string
    {
        return $this->verificationToken;
    }

    public function setVerificationToken(?string $verificationToken): static
    {
        $this->verificationToken = $verificationToken;
        return $this;
    }

    public function __toString(): string
    {
        return \sprintf(
            '#%d %s',
            $this->id,
            $this->email
        );
    }
}
