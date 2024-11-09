<?php

namespace App\Console\Commands;

use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteExpiredLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-expired-links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes links whose delete_at has passed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $links = Link::where('delete_at', '<=', Carbon::now())->get();
    
        foreach ($links as $link) {
            $link->delete();
        }

        $this->info('Expired links deleted successfully!');
    }
}
