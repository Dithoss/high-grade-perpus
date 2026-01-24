<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interface\AuditLogInterface;
use App\Models\AuditLog;
use Illuminate\Pagination\LengthAwarePaginator;

class AuditLogRepository implements AuditLogInterface
{
    public function __construct(
        protected AuditLog $model
    ) {}

    public function store(array $data): AuditLog
    {
        return $this->model->create($data);
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->with('user')
            ->latest()
            ->paginate($perPage);
    }
}
