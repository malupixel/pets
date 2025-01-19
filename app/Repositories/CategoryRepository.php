<?php

namespace App\Repositories;

use App\Dto\CategoryDto;

final readonly class CategoryRepository extends ApiRepository
{
    /**
     * @return array|CategoryDto[]
     */
    public function getAll(): array
    {
        $result = [];
        $categories = json_decode($this->api->get('category', 'GET'), true);
        foreach ($categories as $category) {
            $result[] = new CategoryDto($category);
        }

        return $result;
    }

    public function getById(int $id): CategoryDto
    {
        return new CategoryDto(json_decode($this->api->get("category/{$id}", "GET"), true));
    }
}
