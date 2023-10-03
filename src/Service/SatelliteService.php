<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Satellite;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class SatelliteService
{
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $em
    ) {
        $this->repository = $em->getRepository(Satellite::class);
    }

    public function getAllSatellites(): array
    {
        $satellites = $this->repository->findAll();
        $satellitesDomains = array_map(fn(Satellite $satellite) => $satellite->getDomain(), $satellites);
        sort($satellitesDomains);
        return $satellitesDomains;
    }
}
