<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMailer extends Mailable
{
    use SerializesModels;

    public $name;
    public $email;
    public $subject;
    public $body;

    public function __construct($name, $email, $subject, $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->body = $message;
    }

    public function build()
    {
        return $this->view("email.contact");
    }
}