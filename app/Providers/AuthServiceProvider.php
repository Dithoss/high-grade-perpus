<?php

namespace App\Providers;

use App\Models\Book;
use App\Policies\BookPolicy;
use App\Policies\TransactionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Transaction::class => TransactionPolicy::class
    ];

    public function boot(): void
    {
        //
    }
}
