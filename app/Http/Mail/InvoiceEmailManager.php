<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceEmailManager extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Data passed to the email view.
     *
     * @var array
     */
    public $data;

    /**
     * Create a new message instance.
     *
     * @param array $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        dd($this->data);
        return $this->view($this->data['view'])
                    ->from($this->data['from'])
                    ->subject($this->data['subject'])
                    ->with([
                        'order' => $this->data['order'],
                        'orderDetails' => $this->data['orderDetails'],  // Pass orderDetails to the view
                    ]);
    }
}
