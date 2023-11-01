<?php

namespace App\Service;

interface TransactionalMakeInterface
{
    public function transactionalMake($model): void;
}
