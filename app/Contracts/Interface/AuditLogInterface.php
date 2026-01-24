<?php

namespace App\Contracts\Interface;

use App\Models\AuditLog;
use Illuminate\Pagination\LengthAwarePaginator;

interface AuditLogInterface
{
    public function store(array $data): AuditLog;
    public function paginate(int $perPage = 10): LengthAwarePaginator;
}
