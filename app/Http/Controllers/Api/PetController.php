<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\PetStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class PetController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Pet::all()->load('tags', 'category'), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'photo_urls' => 'nullable|array',
            'photo_urls.*' => 'required|url',
            'status' => 'required|in:' . implode(',', array_column(PetStatus::cases(), 'value')),
        ]);

        $validatedData['status'] = PetStatus::from($validatedData['status']);

        $pet = Pet::create($validatedData);

        if (!empty($validatedData['tags'])) {
            $pet->tags()->sync($validatedData['tags']);
        }

        return response()->json($pet->load('tags'), 201);
    }

    public function show(int $id): JsonResponse
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return response()->json(['error' => 'Pet not found'], 404);
        }

        return response()->json($pet->load('tags', 'category'), 200);
    }

    public function findByStatus(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'status' => 'required|string',
        ]);

        $statuses = explode(',', $validatedData['status']);

        $invalidStatuses = array_diff($statuses, PetStatus::values());
        if (!empty($invalidStatuses)) {
            return response()->json([
                'error' => 'Invalid statuses: ' . implode(', ', $invalidStatuses) . '. Allowed values are: ' . implode(', ', PetStatus::cases())
            ], 400);
        }

        $pets = Pet::whereIn('status', $statuses)->get();

        return response()->json($pets);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return response()->json(['error' => 'Pet not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'photo_urls' => 'nullable|array',
            'photo_urls.*' => 'url',
            'status' => 'nullable|in:' . implode(',', array_column(PetStatus::cases(), 'value')),
        ]);

        if (!empty($validatedData['status'])) {
            $validatedData['status'] = PetStatus::from($validatedData['status']);
        }

        $pet->update($validatedData);

            $pet->tags()->sync($validatedData['tags']);

        return response()->json($pet->load('tags'), 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return response()->json(['error' => 'Pet not found'], 404);
        }

        $pet->delete();

        return response()->json(['message' => 'Pet deleted successfully'], 200);
    }
}
