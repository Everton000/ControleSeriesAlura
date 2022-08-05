<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SeriesRepository;
use App\Repositories\EloquentSeriesRepository;

class SeriesRepositoryProvider extends ServiceProvider
{
    public array $bindings = [
        SeriesRepository::class => EloquentSeriesRepository::class
    ];
}
