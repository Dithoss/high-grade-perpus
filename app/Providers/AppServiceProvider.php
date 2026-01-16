<?php

namespace App\Providers;

use App\Contracts\Interface\AuthInterface;
use App\Contracts\Interface\BookInterface;
use App\Contracts\Interface\CategoryInterface;
use App\Contracts\Repositories\AuthRepository;
use App\Contracts\Repositories\BookRepository;
use App\Contracts\Repositories\CategoryRepository;
use App\Models\Book;
use App\Observers\BookObserver;
use App\Policies\BookPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
   public function register(): void
    {

        $bindings = [
            AuthInterface::class => AuthRepository::class,
            BookInterface::class => BookRepository::class,
            CategoryInterface::class => CategoryRepository::class,        ];

        foreach ($bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Book::observe(BookObserver::class);
    }
}
