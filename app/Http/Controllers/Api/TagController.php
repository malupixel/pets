<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class TagController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Tag::all(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tag = Tag::create($request->all());

        return response()->json($tag, 201);
    }

    public function show(int $id): JsonResponse
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json(['error' => 'Tag not found'], 404);
        }

        return response()->json($tag, 200);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $tag->update($request->all());

        return response()->json($tag, 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json(['error' => 'Tag not found'], 404);
        }

        $tag->delete();

        return response()->json(['message' => 'Tag deleted successfully'], 200);
    }
}
