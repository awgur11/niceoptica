<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderSendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void 
     */

    protected $details;

    protected $recipient;

    public function __construct($details, $recipient)
    {
        $this->details = $details;

        $this->recipient = $recipient;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->recipient == 'admin')
            \Mail::to(trim($this->details['email']))->send(new \App\Mail\OrderAdmin($this->details['cart_arr'],  $this->details['loyalty_percent'], $this->details['user'], $this->details['delivery']));
        elseif($this->recipient == 'user')
            \Mail::to($this->details['email'])->send(new \App\Mail\OrderClient($this->details['cart_arr'], $this->details['loyalty_percent'], $this->details['user'], $this->details['delivery']));
    }
}
