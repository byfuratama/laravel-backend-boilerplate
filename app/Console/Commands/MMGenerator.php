<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use App\MMSettings;
use InvalidArgumentException;

class MMGenerator extends Command
{
    protected $signature = 'mmgenerate';
    protected $description = 'Generate Model and Migration based on MMSettings';
    protected $files;

    public function __construct()
    {
        parent::__construct();

        $this->files = new FileSystem();
    }

    public function handle()
    {
        MMSettings::generate();
        $mm = MMSettings::listOf();

        $this->deleteMM();
        for ($i=0; $i < count($mm); $i++) {
            $table = Str::snake($mm[$i]->getTable());

            $name = "mm_{$table}_table";
            $body = $mm[$i]->toMigration();
            $this->writeMigration($name,$table,$body);

            $name = Str::studly($table);
            $fillable = $mm[$i]->toModel();
            $softDeletes = $mm[$i]->softDeletes;
            $this->writeModel($name,$table,$fillable,$softDeletes);
        }
    }

    protected function writeMigration($name, $table, $body) {
        $file = $this->createMigration($name, $table , $body);

        $file = pathinfo($file, PATHINFO_FILENAME);

        $this->line("<info>Created Migration:</info> {$file}");
    }

    protected function writeModel($name, $table, $fillable, $softDeletes) {
        $file = $this->createModel($name, $table ,$fillable, $softDeletes);

        $file = pathinfo($file, PATHINFO_FILENAME);

        $this->line("<info>Created Model:</info> {$file}");
    }

    public function createMigration($name, $table, $fillable)
    {
        $path = $this->getMigrationPath();
        $this->ensureMigrationDoesntAlreadyExist($name);
        $stub = $this->getMigrationStub();

        $this->files->put(
            $path = $this->getMigrationNamePath($name),
            $this->populateMigrationStub($name, $stub, $table, $fillable)
        );

        return $path;
    }

    public function createModel($name, $table, $fillable, $softDeletes)
    {
        $path = $this->getModelPath();
        $this->ensureModelDoesntAlreadyExist($name);
        $stub = $this->getModelStub($softDeletes);

        $this->files->put(
            $path = $this->getModelNamePath($name),
            $this->populateModelStub($name, $stub, $table, $fillable)
        );

        return $path;
    }

    protected function ensureMigrationDoesntAlreadyExist($name)
    {
        $path = $this->getMigrationPath();
        if (! empty($path)) {
            $migrationFiles = $this->files->glob($path.'/*.php');
            foreach ($migrationFiles as $migrationFile) {
                $this->files->requireOnce($migrationFile);
            }
        }

        if (class_exists($className = $this->getClassName($name))) {
            throw new InvalidArgumentException("A {$className} class already exists.");
        }
    }

    protected function ensureModelDoesntAlreadyExist($name)
    {
        return;
        // $path = $this->getMigrationPath();
        // if (! empty($path)) {
        //     $migrationFiles = $this->files->glob($path.'/*.php');
        //     foreach ($migrationFiles as $migrationFile) {
        //         $this->files->requireOnce($migrationFile);
        //     }
        // }

        if (class_exists($className = $this->getClassName($name))) {
            throw new InvalidArgumentException("A {$className} class already exists.");
        }
    }

    public function deleteMM() {
        $path = $this->getMigrationPath();
        $migrationFiles = $this->files->glob($path.'/*_mm_*');

        foreach ($migrationFiles as $migrationFile) {
            $file = pathinfo($migrationFile, PATHINFO_FILENAME);
            $this->files->delete($migrationFile);
            $this->line("<info>Removed file:</info> {$file}");
        }

        $path = $this->getModelPath();
        $modelFiles = $this->files->glob($path.'/*.php');

        foreach ($modelFiles as $modelFiles) {
            $file = pathinfo($modelFiles, PATHINFO_FILENAME);
            $this->files->delete($modelFiles);
            $this->line("<info>Removed file:</info> {$file}");
        }
    }

    protected function populateMigrationStub($name, $stub, $table, $body)
    {
        $stub = str_replace(
            ['DummyClass', '{{ class }}', '{{class}}'],
            $this->getClassName($name), $stub
        );

        $stub = str_replace(
            ['DummyTable', '{{ table }}', '{{table}}'],
            $table, $stub
        );

        $stub = str_replace(
            ['{{ body }}', '{{body}}'],
            $body, $stub
        );

        return $stub;
    }

    protected function populateModelStub($name, $stub, $table, $fillable)
    {
        $stub = str_replace(
            ['DummyClass', '{{ name }}', '{{name}}'],
            $this->getClassName($name), $stub
        );

        $stub = str_replace(
            ['DummyTable', '{{ table }}', '{{table}}'],
            $table, $stub
        );

        $stub = str_replace(
            ['{{ fillable }}', '{{fillable}}'],
            $fillable, $stub
        );

        return $stub;
    }

    protected function getClassName($name)
    {
        return Str::studly($name);
    }

    protected function getMigrationPath()
    {
        return $this->laravel->databasePath().DIRECTORY_SEPARATOR.'migrations';
    }

    protected function getModelPath()
    {
        return $this->laravel->path().DIRECTORY_SEPARATOR.'Models';
    }

    protected function getMigrationStub()
    {
        $stub = $this->stubPath().'/mmigration.stub';
        return $this->files->get($stub);
    }

    protected function getModelStub($softDeletes)
    {
        $stub = !$softDeletes ? $this->stubPath().'/mmodel.stub' : $this->stubPath().'/mmodel.w.softdelete.stub';
        return $this->files->get($stub);
    }

    protected function getMigrationNamePath($name)
    {
        $path = $this->getMigrationPath();
        return $path.'/'.$this->getDatePrefix().'_'.$name.'.php';
    }

    protected function getModelNamePath($name)
    {
        $path = $this->getModelPath();
        return $path.'/'.$name.'.php';
    }

    protected function getDatePrefix()
    {
        return date('Y_m_d_His');
    }

    public function stubPath()
    {
        return $this->laravel->basePath().'/stubs';
    }
}
