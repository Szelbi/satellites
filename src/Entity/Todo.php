<?php

namespace App\Entity;

use App\Entity\Trait\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Table(name:"todos")]
#[ORM\Entity]
class Todo implements EntityInterface
{
    use IdTrait;

    #[ORM\Column(length: 255)]
    private string $label;

    #[ORM\Column(options: ["default" => false])]
    private bool $isDone = false;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"])]
    private DateTime $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function isDone(): ?bool
    {
        return $this->isDone;
    }

    public function setIsDone(bool $isDone): void
    {
        $this->isDone = $isDone;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function __toString(): string
    {
        return (string)$this->id;
    }
}
