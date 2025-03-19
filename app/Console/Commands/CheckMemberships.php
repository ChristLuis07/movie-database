<?php

namespace App\Console\Commands;

use App\Jobs\CheckMembershipStatus;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class CheckMemberships extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'membership:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and deactivate expired memberships';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Bus::batch([
            new CheckMembershipStatus(),
        ])
        ->then(function () {
            Log::info('Membership Checks completed');
        })->catch(function () {
            Log::error('Membership Checks failed');
        })->finally(function (Batch $batch) {
            Log::info('Membership check finished');
        })
        ->dispatch();
        $this->info('Membership check job has been dispatched');
    }
}
