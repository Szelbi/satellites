<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

trait UpdatedAtTrait
{
    #[ORM\Column(name: "updated_at", type: "datetime", nullable: false)]
    private ?DateTime $updatedAt = null;

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new DateTime("now");
    }
}
