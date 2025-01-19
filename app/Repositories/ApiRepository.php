<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Services\Api;

abstract readonly class ApiRepository
{
    public function __construct(protected Api $api) {}
}
