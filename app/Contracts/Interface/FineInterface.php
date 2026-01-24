<?php

namespace App\Contracts\Interface;

use App\Models\Fine;
use Illuminate\Pagination\LengthAwarePaginator;

interface FineInterface
{
    public function getAll(array $filters = []): LengthAwarePaginator;

    public function getByUser(string|int $userId): LengthAwarePaginator;

    public function markAsPaid(Fine $fine): bool;

    public function create(array $data): Fine;

    public function getUnpaidByUser(int $userId);

    public function getTotalUnpaidByUser(int $userId): float;
}