<?php
namespace App\Contracts\Interface;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryInterface
{
    public function findById(mixed $id): ?Category;
    public function store(array $data): Category;
    public function update(mixed $id, array $data): Category;
    public function delete(mixed $id): bool;
    public function forceDelete(mixed $id): bool;
    public function restore(mixed $id): bool;
    public function trash(array $filters = []): LengthAwarePaginator;
    public function getWithFilters(array $filters = []);
    public function paginate(int $pagination = 10):LengthAwarePaginator;
    public function findBySlug(string|int $slug): Category;
    public function searchTrashed(string $keyword, int $perPage = 15);

}