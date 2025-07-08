<?php

namespace App\Console\Commands;

use App\Http\Controllers\JopController;
use Illuminate\Console\Command;

class SyncGmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-gmail-command';

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
        $controller = new JopController(); // استبدل باسم الكنترولر
        $controller->sync(); // استدعاء الدالة
        $this->info('Gmail sync executed successfully.');
    }
}
