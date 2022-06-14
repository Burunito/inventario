<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Faker\ProductoProvider;
use Faker\{Factory, Generator};

class FakerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Generator::class, function () {
            $faker = Factory::create();
            $faker->addProvider(new ProductoProvider($faker));
            return $faker;
        });
    }
}