<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MarkOverdueRentals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mark-overdue-rentals';

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
        $overdueRentals = Rental::whereNull('returned_at')
            ->where('rented_at', '<', now()->subWeeks(2))
            ->update(['is_overdue' => true]);

        $this->info('Marked overdue rentals');
    }
}
