<?php
declare(strict_types=1);

namespace App\Satellite\Infrastructure\Repository;

use App\Satellite\Domain\Entity\Satellite;
use App\Satellite\Domain\Repository\SatelliteRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SatelliteRepository extends ServiceEntityRepository implements SatelliteRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Satellite::class);
    }

    /**
     * @return Satellite[]
     */
    public function findAll(): array
    {
        return parent::findAll();
    }
}
