<?php

namespace App\Http\Livewire\ParideLw\Btn;

use App\Http\Controllers\sysCtrl\UserController;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ResetUserPassword extends Component
{
    public $idUser;

    protected $listeners = [
        'resetConfirmed',
        'resetCancelled',
    ];

    public function render()
    {
        return view('livewire.paride-lw.btn.reset-user-password');
    }

    public function resetConfirmed()
    {
        $this->alert('success', 'Ok! Richiesta Inviata! <br> Riceverai una mail a breve', [
            'position' =>  'top-end',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  'Check out!',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  true,
        ]);
        return redirect()->action([UserController::class, 'sendResetPassword'], $this->idUser);
    }

    public function resetCancelled()
    {
        $this->alert('info', 'Nessuna richiesta inviata!');
    }

    public function resetPassword()
    {
        if (Auth::user()->id == $this->idUser) {
            $this->confirm('Attenzione!! <br> Il tuo account verrà disattivato! <br> Riceverai una email con le istruzioni per impostare una nuova password. <br> Continuare?', [
                'toast' => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'cancelButtonText' => 'Nope',
                'onConfirmed' => 'resetConfirmed',
                'onCancelled' => 'resetCancelled'
            ]);
        } else {
            $this->confirm('Attenzione!! <br> L\'utente verrà disattivato fino a quando non imposterà una nuova password. <br> Continuare?', [
                'toast' => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'cancelButtonText' => 'Nope',
                'onConfirmed' => 'resetConfirmed',
                'onCancelled' => 'resetCancelled'
            ]);
        }
    }
}
