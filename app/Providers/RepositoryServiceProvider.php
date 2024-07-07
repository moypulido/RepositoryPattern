<?php

namespace App\Providers;

use App\Interfaces\BooksRepositoryInterface;
use App\Repositories\BooksRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BooksRepositoryInterface::class, BooksRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
