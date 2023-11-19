<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Mapping as ORM;

trait PositionTrait
{
    #[ORM\Column(name: "position", type: "integer", nullable: false)]
    private ?int $position = null;

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    #[ORM\PrePersist]
    public function setDefaultPositionValue(PrePersistEventArgs $event): void
    {
        if ($this->position === null) {

            $entityManager = $event->getObjectManager();
            $repository = $entityManager->getRepository(get_class($this));

            $maxPosition = $repository->createQueryBuilder('t')
                ->select('MAX(t.position)')
                ->getQuery()
                ->getSingleScalarResult();

            $this->position = $maxPosition + 1;
        }
    }
}
