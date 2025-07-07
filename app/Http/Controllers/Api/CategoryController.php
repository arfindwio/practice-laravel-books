<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    // get semua data kategori
    public function getCategories()
    {
        $categories = Category::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Data kategori berhasil diambil',
            'data' => CategoryResource::collection($categories),
        ], 200);
    }

    // get kategori detail berdasarkan ID
    public function getCategory($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori tidak ditemukan',
                'data' => null,
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Detail kategori berhasil diambil',
            'data' => new CategoryResource($category),
        ], 200);
    }

    // Buat kategori baru
    public function postCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Kategori berhasil dibuat',
            'category' => $category
        ], 201);
    }

    // Update kategori
    public function updateCategory(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Kategori berhasil diperbarui',
            'category' => $category
        ]);
    }

    // Hapus kategori
    public function deleteCategory($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Kategori berhasil dihapus']);
    }
}