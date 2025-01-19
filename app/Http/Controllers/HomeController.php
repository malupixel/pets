<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Dto\PetDto;
use App\PetStatus;
use App\Repositories\CategoryRepository;
use App\Repositories\PetRepository;
use App\Repositories\TagRepository;
use App\Services\PetDtoBuilder;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class HomeController extends Controller
{
    public function __construct(
        private readonly PetRepository $petRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly TagRepository $tagRepository,
        private readonly PetDtoBuilder $petDtoBuilder
    ) {}

    public function index(): Renderable
    {
        $data = [
            'pets' => $this->petRepository->getAll(),
        ];

        return view('home', $data);
    }

    public function add(Request $request): View|RedirectResponse
    {
        $data = [
            'categories' => $this->categoryRepository->getAll(),
            'tags' => $this->tagRepository->getAll(),
            'statuses' => PetStatus::values(),
        ];

        if ($request->isMethod('POST')) {
            $petDto = $this->petDtoBuilder->build($request);
            if ($petDto === null) {
                $response['errors'][] = 'Pet cannot be created.';
            }
            $response = $this->petRepository->create($petDto);
            if (!isset($response['errors'])) {
                return redirect()->route('home')->with('success', 'Pet created successfully!');;
            }
            $data['validate'] = $response['errors'];
        }

        return view('form', $data);
    }



    public function edit(int $id, Request $request): View|RedirectResponse
    {
        $data = [
            'pet' => $this->petRepository->getById($id),
            'categories' => $this->categoryRepository->getAll(),
            'tags' => $this->tagRepository->getAll(),
            'statuses' => PetStatus::values(),
        ];

        if ($request->isMethod('PUT')) {
            $petDto = $this->petDtoBuilder->build($request);
            if ($petDto === null) {
                $response['errors'][] = 'Pet cannot be created.';
            } else {
                $petDto->id = $id;
            }
            $response = $this->petRepository->update($petDto);
            if (!isset($response['errors'])) {
                return redirect()->route('home')->with('success', 'Pet updated successfully!');;
            }
            $data['validate'] = $response['errors'];
        }

        return view('form', $data);
    }

    public function remove(int $id): RedirectResponse
    {
        $apiResponse = $this->petRepository->delete($id);

        if (isset($apiResponse['errors'])) {
            return redirect()->route('home')->with($apiResponse);
        }
        return redirect()->route('home');
    }
}
