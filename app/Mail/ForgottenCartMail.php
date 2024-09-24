<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgottenCartMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The data array.
     *
     * @var Array
     */
    public $data;

    /**
     * The subject message.
     *
     * @var Array
     */
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $data)
    {
        $this->subject = $subject;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->with(['title' => $this->subject])->view('mails.fullmarcas_flujoabandonado');
    }
}
