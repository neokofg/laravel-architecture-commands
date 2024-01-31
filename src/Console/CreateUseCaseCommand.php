<?php

namespace Neoko\LaravelArchitectureCommands\Console;

use Exception;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;
#[AsCommand(name: 'make:usecase')]
class CreateUseCaseCommand extends GeneratorCommand
{
    protected $name = 'make:usecase';

    protected $description = 'Create a new usecase class';

    protected $type = 'UseCase';

    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/usecase.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\UseCases';
    }

    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }
}
