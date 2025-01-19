<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Dto\TagDto;

final readonly class TagRepository extends ApiRepository
{
    /**
     * @return array|TagDto[]
     */
    public function getAll(): array
    {
        $result = [];
        $tags = json_decode($this->api->get('tag', 'GET'), true);
        foreach ($tags as $tag) {
            $result[] = new TagDto($tag);
        }

        return $result;
    }

    public function getById(int $id): TagDto
    {
        return new TagDto(json_decode($this->api->get("tag/{$id}", "GET"), true));
    }
}
