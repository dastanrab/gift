<?php

namespace App\Providers;

use App\Models\Deliver;
use App\Models\Fail;
use App\Models\Raw;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Relation::morphMap([
            'raw' => Raw::class,
            'deliver' => Deliver::class,
            'fail'=> Fail::class
        ]);
    }
}
