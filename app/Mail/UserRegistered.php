<?php

namespace Seara\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegistered extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $view;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $owner = false)
    {
      // Caso seja um email para o administrador, vou enviar para o
      // adm as informações do usuário.
      if (!$owner){
        $this->view = 'emails.users.registered';
        $this->subject = 'Registro Realizado com Sucesso';
      }
      else {
        $this->view = 'emails.owner.user_registered';
        $this->subject = 'Novo Cadastro Efetuado';
      }

      // Dados a serem disponibilizados para as views
      $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown($this->view)
                    ->subject($this->subject);
    }
}
