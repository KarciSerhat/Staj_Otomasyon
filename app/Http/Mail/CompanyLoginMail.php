<?php

namespace App\Http\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyLoginMail extends Mailable
{
use Queueable, SerializesModels;
protected $user;
/**
* Create a new message instance.
*
* @return void
*/
public function __construct($user)
{
$this->user = $user;

}

/**
* Build the message.
*
* @return $this
*/
public function build()
{
$user = $this->user;
return $this->subject('Fırat Üniversitesi')->view('sendMail',compact('user'));
}
}
