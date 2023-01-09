<?php

namespace App\Listeners;

use App\Events\CadastroProfessor;
use App\Mail\EmailCadastroProfessor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EnviarEmailCadastroProfessor
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CadastroProfessor $event)

    {
        $link = 'https://google.com';
        $email = (object) array(
            'mensagem' => "Prezado(a) $event->nomeProfessor, <br><br>
            Seu cadastro foi realizado com sucesso!! <br>
            <a href='$link'>Clique aqui</a> para ativar sua conta",
            'assunto' => "Quiz Sales - Cadastro realizado"
        );
        Mail::to($event->emailProfessor)->send(new EmailCadastroProfessor($email));
    }
}
