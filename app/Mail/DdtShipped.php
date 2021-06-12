<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use App\Models\parideModels\Docs\FDCli;
use App\Models\parideModels\Docs\FPCli;
use App\Models\parideModels\Docs\FTCli;
use App\Models\parideModels\Docs\NCCli;
use App\Models\parideModels\Docs\DDTCli;
use App\Models\parideModels\Docs\OrdCli;
use App\Models\parideModels\Docs\QuoteCli;
use App\Models\parideModels\Docs\wDocSent;
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
        $nameDoc = $this->getNameDoc($docListed->tipo_doc, $docListed->id_doc);
        return $this->subject('Invio '.$nameDoc.' - Ferramenta Paride')
                ->markdown('parideViews._emails.docs.ddtShippede')
                ->attach($this->fileToAttach);
    }

    protected function getNameDoc($tipodoc, $id_doc)
    {
        switch ($tipodoc) {
            case 'XC':
                $doc = QuoteCli::select('num', 'data')->findOrFail($id_doc);
                break;
            case 'OC':
                $doc = OrdCli::select('num', 'data')->findOrFail($id_doc);
                break;
            case 'BO':
                $doc = DDTCli::select('num', 'data')->findOrFail($id_doc);
                break;
            case 'FT':
                $doc = FTCli::select('num', 'data')->findOrFail($id_doc);
                break;
            case 'FP':
                $doc = FPCli::select('num', 'data')->findOrFail($id_doc);
                break;
            case 'FD':
                $doc = FDCli::select('num', 'data')->findOrFail($id_doc);
                break;
            case 'NC':
                $doc = NCCli::select('num', 'data')->findOrFail($id_doc);
                break;
            default:
                break;
        }
        $nameDoc = $doc->descr_tipodoc . " n." . $doc->num . "/" . $doc->data->year;
        return $nameDoc;
    }

}
