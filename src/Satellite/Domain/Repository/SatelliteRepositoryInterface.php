<?php
declare(strict_types=1);

namespace App\Satellite\Domain\Repository;

use App\Satellite\Domain\Entity\Satellite;

interface SatelliteRepositoryInterface
{
    /**
     * @return Satellite[]
     */
    public function findAll(): array;
}