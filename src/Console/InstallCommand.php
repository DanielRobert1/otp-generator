<?php

namespace DanielRobert\Otp\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otp:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Otp Generator resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing Otp Migrations...');
        $this->callSilent('vendor:publish', ['--tag' => 'otp-migrations']);

        $this->comment('Publishing Otp Generator Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'otp-config']);

        $this->info('Otp Generator scaffolding installed successfully.');
    }
}