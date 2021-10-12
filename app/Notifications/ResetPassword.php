<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends ResetPasswordNotification {

    public function toMail($notifiable) {
        return ( new MailMessage )
            ->view('emails.user-reset-password',["link"=>url('password/reset', $this->token)])
            ->from(env('MAIL_USERNAME'))
            ->subject( 'Reset your password' );
    }

}
