<?php

namespace Api\V1\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CreateSwaggerSpecification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api-v1:create-swagger-specification';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var Application
     */
    private $application;

    public function __construct(Application $application)
    {
        parent::__construct();
        $this->application = $application;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $process = new Process(
            [
                'vendor/bin/openapi!',
                '--output', 'public/swagger.json',
                'api/v1/Http/Controllers',
                'api/v1/resources',
            ],
            $this->application->basePath()
        );

        $exitCode = $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $exitCode;
    }
}
