<?php

namespace Neoko\LaravelArchitectureCommands\Console;

use Exception;
use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

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

    public function handle()
    {
        if ($this->isReservedName($this->getNameInput())) {
            $this->components->error('The name "'.$this->getNameInput().'" is reserved by PHP.');

            return false;
        }

        $name = $this->qualifyClass($this->getNameInput());

        $path = $this->getPath($name);
        $exceptionPath = dirname($path) . '/Exceptions/' . basename($this->getNameInput()) . 'Exception.php';

        if ((! $this->hasOption('force') ||
                ! $this->option('force')) &&
            $this->alreadyExists($this->getNameInput())) {
            $this->components->error($this->type.' already exists.');

            return false;
        }

        $this->makeDirectory($path);
        $this->makeDirectory($exceptionPath);

        $stubException = $this->files->get($this->resolveStubPath('/stubs/exception.stub'));
        $this->files->put($exceptionPath, $this->sortImports(
            $this->replaceNamespace($stubException, $name)
                ->replaceClass($stubException, $name . 'Exception')
        ));

        $this->files->put($path, $this->sortImports($this->buildClass($name)));

        $info = $this->type;

        if (windows_os()) {
            $path = str_replace('/', '\\', $path);
        }

        $this->components->info(sprintf('%s [%s] created successfully.', $info, $path));
    }
}
