<?php
namespace App\Contracts\Interface;

use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;

interface BookInterface
{
    public function findById(mixed $id): ?Book;
    public function store(array $data): Book;
    public function update(mixed $id, array $data): Book;
    public function delete(mixed $id): bool;
    public function forceDelete(mixed $id): bool;
    public function restore(mixed $id): bool;
    public function trash(array $filters = []): LengthAwarePaginator;
    public function getWithFilters(array $filters = []);
    public function paginate(int $pagination = 10):LengthAwarePaginator;
    public function findBySlug(string|int $slug): Book;
    public function searchTrashed(string $keyword, int $perPage = 15);
}