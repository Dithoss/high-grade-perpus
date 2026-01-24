<?php

namespace Database\Factories;

use App\Models\TransactionItem;
use App\Models\Transaction;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TransactionItemFactory extends Factory
{
    protected $model = TransactionItem::class;

    public function definition(): array
    {
        return [
            'id'             => (string) Str::uuid(),
            'transaction_id' => Transaction::factory(),
            'book_id'        => Book::factory(),
            'quantity'       => $this->faker->numberBetween(1, 3),
        ];
    }
}
