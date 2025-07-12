<?php

namespace App\Shared\Domain\Enum;

enum DateFormatEnum: string
{
    case DATE_TIME = 'Y-m-d H:i:s';
    case DATE = 'Y-m-d';
    case TIME = 'H:i:s';
}
