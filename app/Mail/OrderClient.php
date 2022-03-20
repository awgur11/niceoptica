<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderClient extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $order;
 
    public $user;

    public $delivery;

    public $loyalty_percent;
    
    public function __construct($order, $loyalty_percent, $user, $delivery)
    {
        $this->order = $order;

        $this->loyalty_percent = $loyalty_percent;

        $this->user = $user;

        $this->delivery = $delivery;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Ваш заказ '.\Request::getHttpHost())
                    ->view('mail.order-client');
    }
}
