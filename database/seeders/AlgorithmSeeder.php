<?php

namespace Database\Seeders;

use App\Models\Algorithm;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;

class AlgorithmSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $books = Book::all();

        if ($users->isEmpty() || $books->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            $books->random(5)->each(function ($book) use ($user) {
                Algorithm::create([
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                    'action' => 'view',
                    'created_at' => now(),
                ]);
            });
        }
    }
}
