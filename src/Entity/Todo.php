<?php

namespace App\Entity;

use App\Entity\Trait\PropertiesTrait;
use App\Entity\Trait\IdTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Enum\DateFormatEnum;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Table(name:"todos")]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class Todo implements EntityInterface, \JsonSerializable
{
    use IdTrait;
    use PropertiesTrait;
    use UpdatedAtTrait;

    #[ORM\Column(length: 255)]
    private ?string $label;

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

    public function setLabel(?string $label): void
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

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'isDone' => $this->isDone,
            'createdAt' => $this->createdAt->format(DateFormatEnum::DATE_TIME->value),
            'updatedAt' => $this->updatedAt?->format(DateFormatEnum::DATE_TIME->value),
        ];
    }
}
