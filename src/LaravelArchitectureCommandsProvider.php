<?php

namespace Neoko\LaravelArchitectureCommands;

use Illuminate\Support\ServiceProvider;

class LaravelArchitectureCommandsProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([

            ]);
        }
    }
}
