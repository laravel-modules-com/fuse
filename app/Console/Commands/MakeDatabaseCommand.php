<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeDatabaseCommand extends Command
{
    protected $signature = 'db:build';

    protected $description = 'Build and seed all table from fresh.';

    public function handle(): void
    {
        if (in_array(config('app.env'), ['local', 'staging'])) {
            if ($this->confirm('This will DELETE all data and re-migrate and seed. Do you wish to continue?')) {
                $this->call('migrate:fresh');
                $this->call('module:seed');
                $this->call('db:seed');
                $this->line('Completed!');
            }
        } else {
            $this->error('This command is disabled on production.');
        }
    }
}
