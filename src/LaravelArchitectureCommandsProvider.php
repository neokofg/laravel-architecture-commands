<?php

namespace Neoko\LaravelArchitectureCommands;

use Illuminate\Support\ServiceProvider;
use Neoko\LaravelArchitectureCommands\Console\CreateRepositoryCommand;
use Neoko\LaravelArchitectureCommands\Console\CreateUseCaseCommand;

class LaravelArchitectureCommandsProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateUseCaseCommand::class,
                CreateRepositoryCommand::class
            ]);
        }
    }
}
