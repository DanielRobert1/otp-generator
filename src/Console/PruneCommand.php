<?php

namespace DanielRobert\Otp\Console;

use Illuminate\Console\Command;
use DanielRobert\Otp\Contracts\PrunableRepository;

class PruneCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otp:prune {--minutes=30 : The number of minutes to retain Otp expired data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune expired entries from the otp database';

    /**
     * Execute the console command.
     *
     * @param  \DanielRobert\Otp\Contracts\PrunableRepository  $repository
     * @return void
     */
    public function handle(PrunableRepository $repository)
    {
        $this->info($repository->prune(now()->subMinutes((int) $this->option('minutes'))).' entries pruned.');
    }
}
