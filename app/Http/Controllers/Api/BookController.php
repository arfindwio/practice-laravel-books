<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller\Api;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    // lihat semua buku
    public function getBooks()
    {
        $books = Book::with('category')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Data buku berhasil diambil',
            'data' => BookResource::collection($books),
        ], 200);
    }

    // lihat detail buku
    public function getBook($id)
    {
        $book = Book::with('category')->find($id);
        if (!$book) {
            return response()->json([
                'status' => 'error',
                'message' => 'Buku tidak ditemukan',
                'data' => null,
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Detail buku berhasil diambil',
            'data' => new BookResource($book),
        ], 200);
    }

    // buat buku baru
    public function postBook(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $book = Book::create($request->only('title', 'author', 'category_id'));

        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'book' => $book
        ], 201);
    }

    // update buku
    public function updateBook(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $book->update($request->only('title', 'author', 'category_id'));

        return response()->json([
            'message' => 'Buku berhasil diperbarui',
            'book' => $book
        ]);
    }

    // hapus buku
    public function deleteBook($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        $book->delete();

        return response()->json(['message' => 'Buku berhasil dihapus']);
    }
}
