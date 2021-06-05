<?php

namespace App\Http\Livewire\ParideLw\Btn;

use App\Models\User;
use Livewire\Component;
use App\Models\parideModels\Docs\wDocSent;
use App\Jobs\emails\SendOneDocListedByEmail;

class SendOneDdtListed extends Component
{
    public $idDoc;

    protected $listeners = [
        'confirmed',
        'cancelled',
    ];

    public function render()
    {
        return view('livewire.paride-lw.btn.send-one-ddt-listed');
    }

    public function confirmed()
    {
        SendOneDocListedByEmail::dispatch($this->idDoc)->onQueue('emails');
        $this->alert('success', 'Ok! Mail Inviata!', [
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

    public function sendDdt()
    {
        // $this->idDoc = $idDoc;
        $docToSend = wDocSent::where('id', $this->idDoc)->first();
        if(User::where('codcli', $docToSend->id_cli)->where('isActive', 1)->where('auto_email', 1)->exists()){
            $this->confirm('Invio il Ddt al cliente?', [
                'toast' => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'cancelButtonText' => 'Nope',
                'onConfirmed' => 'confirmed',
                'onCancelled' => 'cancelled'
            ]);
        } else {
            $this->confirm('Attenzione!! <br> Il cliente ha disabilitato la ricezione delle email. <br> Invio il Ddt al cliente?', [
                'toast' => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'cancelButtonText' => 'Nope',
                'onConfirmed' => 'confirmed',
                'onCancelled' => 'cancelled'
            ]);
        }
    }
}
