<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interface\FineInterface;
use App\Models\Fine;
use Illuminate\Pagination\LengthAwarePaginator;

class FineRepository implements FineInterface
{
    /**
     * Get all fines with optional filters
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = Fine::with(['transaction.user', 'transaction.items.book'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        // Filter by type
        if (isset($filters['type']) && $filters['type'] !== '') {
            $query->where('type', $filters['type']);
        }

        return $query->paginate(15);
    }

    /**
     * Get fines by user ID
     */
    public function getByUser(string|int $userId): LengthAwarePaginator
    {
        return Fine::with(['transaction.items.book'])
            ->whereHas('transaction', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    /**
     * Mark a fine as paid
     */
    public function markAsPaid(Fine $fine): bool
    {
        return $fine->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    /**
     * Create a new fine
     */
    public function create(array $data): Fine
    {
        return Fine::create($data);
    }

    /**
     * Get unpaid fines by user ID
     */
    public function getUnpaidByUser(int $userId)
    {
        return Fine::whereHas('transaction', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->where('status', 'unpaid')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get total unpaid amount by user ID
     */
    public function getTotalUnpaidByUser(int $userId): float
    {
        return Fine::whereHas('transaction', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->where('status', 'unpaid')
            ->sum('amount');
    }
}