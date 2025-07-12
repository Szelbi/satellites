<?php

namespace App\Todo\Domain\Entity;

use App\Shared\Domain\Entity\EntityInterface;
use App\Shared\Domain\Entity\Trait\IdTrait;
use App\Shared\Domain\Entity\Trait\PositionTrait;
use App\Shared\Domain\Entity\Trait\PropertiesTrait;
use App\Shared\Domain\Entity\Trait\TimestampableEntityTrait;
use App\Shared\Domain\Enum\DateFormatEnum;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name:"todos")]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class Todo implements EntityInterface, \JsonSerializable
{
    use IdTrait;
    use PropertiesTrait;
    use TimestampableEntityTrait;
    use PositionTrait;

    #[ORM\Column(length: 255)]
    private string $label;

    #[ORM\Column(options: ["default" => false])]
    private bool $isDone = false;

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
            'position' => $this->position,
            'createdAt' => $this->createdAt->format(DateFormatEnum::DATE_TIME->value),
            'updatedAt' => $this->updatedAt?->format(DateFormatEnum::DATE_TIME->value),
        ];
    }
}
