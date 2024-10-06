<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Rental;
use App\Mail\OverdueNotice;
use Mail;

class SendOverdueEmails extends Command
{
    protected $signature = 'rental:send-overdue-emails';
    protected $description = 'Send overdue email notifications to users with overdue rentals';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $overdueRentals = Rental::where('due_at', '<', now())
                               ->where('status', '!=', 'returned')
                               ->get();

        foreach ($overdueRentals as $rental) {
            Mail::to($rental->user->email)->send(new OverdueNotice($rental));
        }

        $this->info('Overdue notifications sent.');
    }
}
