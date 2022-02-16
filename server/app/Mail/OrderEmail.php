<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $created_at;
    public $fullname;
    public $tel;
    public $description;
    public $photo;
    public $type;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fullname, $created_at, $tel, $description, $photo = '', $type)
    {
        $this->created_at = $created_at;
        $this->fullname = $fullname;
        $this->tel = $tel;
        $this->description = $description;
        $this->photo = $photo;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('emails.orderemail')->with([
            'fullname' => $this->fullname,
            'created_at' => $this->created_at,
            'tel' => $this->tel,
            'description' => $this->description,
            'photo' => $this->photo,
            'type' => $this->type,
        ]);
    }
}