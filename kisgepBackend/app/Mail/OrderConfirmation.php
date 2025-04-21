<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Rendeles;
use Illuminate\Support\Facades\Mail;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $rendeles;

    /**
     * Create a new message instance.
     */
    public function __construct(Rendeles $rendeles)
    {
        $this->rendeles = $rendeles;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->view('emails.order-confirmation')
                    ->subject('Rendelés visszaigazolás - #' . $this->rendeles->rendeles_azonosito);
    }

    /**
     * Send the order confirmation email.
     */
    public static function sendOrderConfirmation($user, Rendeles $rendeles): void
    {
        Mail::to($user->email)->send(new self($rendeles));
    }
}

