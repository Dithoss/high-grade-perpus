<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        $borrowedAt = $this->faker->dateTimeBetween('-10 days', 'now');
        $dueAt = (clone $borrowedAt)->modify('+7 days');

        return [
            'id'             => (string) Str::uuid(),
            'user_id'        => User::factory(),
            'status'         => 'borrowed',
            'receipt_number' => 'TRX-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
            'borrowed_at'    => $borrowedAt,
            'due_at'         => $dueAt,
            'returned_at'    => null,
        ];
    }

    /**
     * State: returned
     */
    public function returned()
    {
        return $this->state(function () {
            return [
                'status'      => 'returned',
                'returned_at' => now(),
            ];
        });
    }

    /**
     * State: late
     */
    public function late()
    {
        return $this->state(function () {
            return [
                'status' => 'late',
            ];
        });
    }
}
