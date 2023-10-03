<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Satellite;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class SatelliteService
{
    const API_PROJECTS_DOMAINS = [
        'epapi',
        'restapi'
    ];

    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(Satellite::class);
    }

    public function getAllSatellites(): array
    {
        $satellites = $this->repository->findAll();
        $satellitesDomains = array_map(fn(Satellite $satellite) => $satellite->getDomain(), $satellites);
        sort($satellitesDomains);
        return $satellitesDomains;
    }

    public function getAllProjects(): array
    {
        $satellites = $this->getAllSatellites();

        return array_merge($satellites, self::API_PROJECTS_DOMAINS);
    }

}
