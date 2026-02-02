<?php
namespace App\Contracts\Interface;

use App\Models\Transaction;
use Illuminate\Pagination\LengthAwarePaginator;

interface TransactionInterface
{
    public function findById(string $id): Transaction;
    public function store(array $data): Transaction;
    public function update(string $id, array $data): Transaction;
    public function delete(mixed $id): bool;
    public function forceDelete(mixed $id): bool;
    public function restore(mixed $id): bool;
    public function trash(array $filters = []): LengthAwarePaginator;
    public function getWithFilters(array $filters = [], string|int $userId = null);
    public function paginate(): LengthAwarePaginator;
    public function findBySlug(string|int $slug): Transaction;
    public function searchTrashed(string $keyword, int $perPage = 15);
    public function confirmReturn(Transaction $transaction): void;
    public function requestReturn(string $id): Transaction;
}