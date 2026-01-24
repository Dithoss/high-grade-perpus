<?php

namespace App\Providers;

use App\Events\TransactionCreated;
use App\Listeners\CreateTransactionAuditLog;
use App\Listeners\ReduceBookStock;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TransactionCreated::class => [
            CreateTransactionAuditLog::class,
            ReduceBookStock::class,
        ],
    ];
}
