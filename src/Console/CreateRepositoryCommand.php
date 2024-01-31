<?php

namespace Neoko\LaravelArchitectureCommands\Console;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:repository')]
class CreateRepositoryCommand extends GeneratorCommand
{
    protected $name = 'make:repository';

    protected $description = 'Create a new repository class';

    protected $type = 'Repository';

    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/repository.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Repositories';
    }

    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }
}
