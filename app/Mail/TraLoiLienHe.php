<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TraLoiLienHe extends Mailable
{
    use Queueable, SerializesModels;

    public $noiDung;

    public function __construct($noiDung)
    {
        $this->noiDung = $noiDung;
    }

    public function build()
    {
        return $this->view('email.admin.traloilienhe')
                    ->with(['noiDung' => $this->noiDung]);
    }
}
