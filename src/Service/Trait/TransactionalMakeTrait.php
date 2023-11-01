<?php

namespace App\Service\Trait;

use Doctrine\ORM\EntityManagerInterface;
use Throwable;

trait TransactionalMakeTrait
{
    private EntityManagerInterface $em;

    /**
     * @required
     * @param EntityManagerInterface $em
     * @return static
     *
     */
    public function withEntityManager(EntityManagerInterface $em): static
    {
        $new = clone $this;
        $new->em = $em;

        return $new;
    }

    public function transactionalMake($model): void
    {
        $this->em->beginTransaction();

        try {
            $this->make($model)->flush();
            $this->em->commit();
        } catch (Throwable $e) {
            if ($this->em->getConnection()->isTransactionActive()) {
                $this->em->rollback();
            }
            throw $e;
        }
    }

    protected abstract function make($model): EntityManagerInterface;
}
