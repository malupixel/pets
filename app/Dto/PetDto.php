<?php
declare(strict_types=1);

namespace App\Dto;

use App\PetStatus;

final class PetDto
{
    public ?int $id = null;
    public ?string $name;
    public array $photoUrls;
    public PetStatus $status;
    public CategoryDto $category;
    /** @var array|TagDto[] */
    public array $tags = [];

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'];
        $this->photoUrls = $data['photo_urls'] ?? [];
        $this->status = PetStatus::from($data['status']);
        $this->category = new CategoryDto($data['category']);
        foreach ($data['tags'] as $tag) {
            $this->tags[] = new TagDto($tag);
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category_id' => $this->category->id,
            'photo_urls' => $this->photoUrls,
            'status' => $this->status->value,
            'category' => $this->category->toArray(),
            'tags' => array_map(function (TagDto $tag) {return $tag->id;}, $this->tags),
        ];
    }

    public function hasTag(int $tagId): bool
    {
        return in_array($tagId, $this->toArray()['tags']);
    }
}
