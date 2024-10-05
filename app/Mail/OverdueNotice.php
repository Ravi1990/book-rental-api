<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OverdueNotice extends Mailable
{
    use Queueable, SerializesModels;

    public $rental;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rental)
    {
        $this->rental = $rental;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your book rental is overdue!')
                    ->view('emails.overdueNotification')
                    ->with([
                        'user' => $this->rental->user,
                        'book' => $this->rental->book,
                    ]);
    }
}
