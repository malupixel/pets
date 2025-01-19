<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Dto\PetDto;

final readonly class PetRepository extends ApiRepository
{
    /**
     * @return array|PetDto[]
     */
    public function getAll(): array
    {
        $result = [];
        $pets = json_decode($this->api->get('pet', 'GET'), true);
        foreach ($pets as $pet) {
            $result[] = new PetDto($pet);
        }

        return $result;
    }

    public function getById(int $id): PetDto
    {
        return new PetDto(json_decode($this->api->get("pet/{$id}", "GET"), true));
    }

    public function create(PetDto $petDto): array
    {
        return json_decode($this->api->get('pet', 'POST', json_encode($petDto->toArray())), true);
    }

    public function update(PetDto $petDto): array
    {
        return json_decode($this->api->get("pet/{$petDto->id}", 'PUT', json_encode($petDto->toArray())), true);
    }

    public function delete(int $id): array
    {
        return json_decode($this->api->get("pet/{$id}", "DELETE"), true);
    }
}
