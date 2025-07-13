<?php
declare(strict_types=1);

namespace App\Satellite\Application\Query;

use App\Satellite\Domain\Entity\Satellite;
use App\Satellite\Domain\Repository\SatelliteRepositoryInterface;

class GetProjectListHandler
{
    const API_PROJECTS_DOMAINS = [
        'epapi',
        'restapi'
    ];

    public function __construct(
        private readonly SatelliteRepositoryInterface $repository
    ) {
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
