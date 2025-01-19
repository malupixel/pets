<?php

namespace App\Repositories;

use App\Services\Api;

abstract readonly class ApiRepository
{
    public function __construct(protected Api $api) {}
}
