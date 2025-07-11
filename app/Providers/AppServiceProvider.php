<?php

namespace App\Providers;

use App\Models\Link;
use App\Models\Tag;
use App\Policies\LinkPolicy;
use App\Policies\TagPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Link::class, LinkPolicy::class);
        Gate::policy(Tag::class, TagPolicy::class);
    }
}
