<?php

namespace App\Http\Livewire\Test;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailSendTest extends Component
{   
    protected $listeners = [
    'confirmed',
    'cancelled',
    ];

    public function render()
    {
        return view('livewire.test.mail-send-test');
    }

    public function confirmed()
    {
        Mail::raw('Hi, welcome user!', function ($message) {
            $message->to(Auth::user()->email)->subject('Test Invio');
        });
        
        $this->alert('success', 'Ok! Mail Sended', [
            'position' =>  'top-end',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  'Check out!',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  true,
            'showConfirmButton' =>  false,
        ]);
    }

    public function cancelled()
    {
        $this->alert('info', 'Nessuna email Inviata!');
    }

    public function triggerConfirm()
    {
        $this->confirm('Would you send a test email?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Nope',
            'onConfirmed' => 'confirmed',
            'onCancelled' => 'cancelled'
        ]);
        Log::info('ok end');
    }
}
