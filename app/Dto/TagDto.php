<?php
declare(strict_types=1);

namespace App\Dto;

final class TagDto
{
    public int $id;
    public string $name;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
