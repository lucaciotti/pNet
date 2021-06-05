<?php

namespace App\Mail;

use App\Models\parideModels\Docs\wDocSent;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DdtShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $idDocListed;
    public $fileToAttach;
    public $url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($idUser, $fileToAttach, $idDocListed)
    {
        $this->user = User::findOrFail($idUser);
        $this->idDocListed = $idDocListed;
        Log::info('Email file Attached: ' . $fileToAttach);
        $this->fileToAttach = $fileToAttach;
        $this->url = route("doc::list");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $docListed = wDocSent::findOrFail($this->idDocListed);
        $docListed->inviato = true;
        $docListed->save();
        return $this->markdown('parideViews._emails.docs.ddtShippede')
                ->attach($this->fileToAttach);
    }
}
