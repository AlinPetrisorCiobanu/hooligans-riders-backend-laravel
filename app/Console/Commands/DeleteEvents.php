<?php

namespace App\Console\Commands;

use App\Models\events_routes;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DeleteEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-events-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now()->toDateString();
        $eventIdsToDelete = events_routes::whereDate('date', '<', $today)->pluck('id');
        DB::table('user_events')->whereIn('id_event', $eventIdsToDelete)->delete();
        events_routes::whereDate('date', '<', $today)->delete();
        $this->info('eventos borrados.');
    }
}
