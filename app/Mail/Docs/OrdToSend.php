<?php

namespace App\Mail\Docs;

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
use App\Models\parideModels\Docs\wOrdSent;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrdToSend extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $idOrdListed;
    public $fileToAttach;
    public $url;
    public $urlInvito;
    public $descrTipoDoc;
    public $urlTracking = '';
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($idUser, $fileToAttach, $idOrdListed)
    {
        $this->user = User::findOrFail($idUser);
        $this->idOrdListed = $idOrdListed;
        Log::info('Email file Attached: ' . $fileToAttach);
        $this->fileToAttach = $fileToAttach;
        $this->url = route("doc::list");
        $this->urlInvito = route("user::resetPassword", $this->user->id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $ordListed = wOrdSent::findOrFail($this->idOrdListed);
        $ordListed->inviato = true;
        $ordListed->save();
        $nameDoc = $this->getNameDoc($ordListed->tipo_doc, $ordListed->id_doc);
        $from = 'ordini@ferramentaparide.it';
        if($ordListed->tipo_doc == 'FP') $from = 'amministrazione@ferramentaparide.it';
        Log::info('Invio '.$nameDoc. ' - '.$this->user->name);
        if($this->user->isActive){
            return $this->from($from, 'pNet - Paride Srl')
                ->subject('Invio '.$nameDoc.' - Paride Srl')
                ->markdown('parideViews._emails.docs.docToSend')
                ->attach($this->fileToAttach);
        } else {
            return $this->from($from, 'pNet - Paride Srl')
                ->subject('Invio ' . $nameDoc . ' - Paride Srl')
                ->markdown('parideViews._emails.docs.docToSendWithInvite')
                ->attach($this->fileToAttach);
        }
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
        $this->descrTipoDoc = $doc->descr_tipodoc;
        $nameDoc = $doc->descr_tipodoc . " n." . $doc->num . "/" . $doc->data->year;
        return $nameDoc;
    }

}
