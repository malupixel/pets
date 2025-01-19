<?php
declare(strict_types=1);

namespace App\Services;

use App\Dto\PetDto;
use App\Repositories\CategoryRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

final readonly class PetDtoBuilder
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private TagRepository $tagRepository
    ) {}

    public function build(Request $request): ?PetDto
    {
        $apiData = $request->all([
            'name', 'category_id', 'status', 'photo_urls',
        ]);
        $apiData['category'] = $this->buildCategory((int)$apiData['category_id']);
        $apiData['tags'] = $this->buildTags($request->get('tags'));

        if (is_array($apiData['photo_urls'])) {
            $apiData['photo_urls'] = array_values(array_filter($apiData['photo_urls']));
        }
        try {
            return new PetDto($apiData);
        } catch (\Exception $exception) {
            return null;
        }
    }

    private function buildCategory(int $categoryId): array
    {
        return $this->categoryRepository->getById($categoryId)->toArray();
    }

    private function buildTags(?array $tags): array
    {
        $result = [];
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $result[] = $this->tagRepository->getById((int)$tag)->toArray();
            }
        }

        return $result;
    }
}
