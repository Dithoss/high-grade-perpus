<?php

namespace App\Listeners;

use App\Events\TransactionCreated;
use App\Models\AuditLog;

class CreateTransactionAuditLog
{
    public function handle(TransactionCreated $event): void
    {
        AuditLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'create',
            'target_type' => 'transactions',
            'target_id'   => $event->transaction->id,
            'description' => 'Membuat transaksi peminjaman',
        ]);
    }
}
