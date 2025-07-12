<?php

namespace App\Shared\Domain\Entity\Trait;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait TimestampableEntityTrait
{
    #[ORM\Column(name: "created_at", type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private DateTime $createdAt;

    #[ORM\Column(name: "updated_at", type: "datetime", nullable: true)]
    private ?DateTime $updatedAt = null;

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new DateTime;
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new DateTime();
    }
}
