<?php

namespace Seara\Notifications;

use Seara\Mail\ResetPasswordMail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Mail;
use Seara\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use phpDocumentor\Reflection\Types\String_;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
    * @var string $token Token utilizado para resetar a senha
    */
    private $token;

    /**
    * @var User $user Usuário para o qual enviar o email de reset
    */
    private $user;

    /**
     * Create a new notification instance.
     *
     * @param string $token Token para resetar a senha
     * @return void
     */
    public function __construct($token, $user)
    {
      $this->token = $token;
      $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new ResetPasswordMail($this->token, $this->user))->to($this->user);
        /*
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
                    */
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
