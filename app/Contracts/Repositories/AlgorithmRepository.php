<?php
namespace App\Contracts\Repositories;

use App\Models\Algorithm;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class AlgorithmRepository
{
    public function logView(?string $userId, string $bookId): void
    {
        Algorithm::create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'action' => 'view',
            'created_at' => now(),
        ]);
    }

    public function relatedByCategory(Book $book, int $limit = 6)
    {
        return Book::with('category')
            ->where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->limit($limit)
            ->get();
    }

    public function personalized(string $userId, int $limit = 6)
    {
        $favoriteCategory = Algorithm::query()
            ->join('books', 'books.id', '=', 'algorithms.book_id')
            ->where('algorithms.user_id', $userId)
            ->select('books.category_id', DB::raw('COUNT(*) as total'))
            ->groupBy('books.category_id')
            ->orderByDesc('total')
            ->first();

        if (!$favoriteCategory) {
            return collect();
        }

        return Book::where('category_id', $favoriteCategory->category_id)
            ->limit($limit)
            ->get();
    }
}
