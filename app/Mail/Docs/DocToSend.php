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
use App\Models\parideModels\Docs\wDocSent;
use Illuminate\Contracts\Queue\ShouldQueue;

class DocToSend extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $idDocListed;
    public $fileToAttach;
    public $url;
    public $urlInvito;
    public $descrTipoDoc;
    public $urlTracking='';
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
        $this->urlInvito = route("user::resetPassword", $this->user->id);
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
        $nameDoc = $this->getNameDocAndTracking($docListed->tipo_doc, $docListed->id_doc);
        $from = 'amministrazione@ferramentaparide.it';
        Log::info('Invio '.$nameDoc. ' - '.$this->user->name);
        if($this->user->isActive){
            return $this->from($from, 'pNet - Paride S.r.l.')
                ->subject('Invio '.$nameDoc.' - Paride S.r.l.')
                ->markdown('parideViews._emails.docs.docToSend')
                ->attach($this->fileToAttach);
        } else {
            return $this->from($from, 'pNet - Paride S.r.l.')
                ->subject('Invio ' . $nameDoc . ' - Paride S.r.l.')
                ->markdown('parideViews._emails.docs.docToSendWithInvite')
                ->attach($this->fileToAttach);
        }
    }

    protected function getNameDocAndTracking($tipodoc, $id_doc)
    {
        switch ($tipodoc) {
            case 'XC':
                $doc = QuoteCli::findOrFail($id_doc);
                break;
            case 'OC':
                $doc = OrdCli::findOrFail($id_doc);
                break;
            case 'BO':
                $doc = DDTCli::findOrFail($id_doc);
                break;
            case 'FT':
                $doc = FTCli::findOrFail($id_doc);
                break;
            case 'FP':
                $doc = FPCli::findOrFail($id_doc);
                break;
            case 'FD':
                $doc = FDCli::findOrFail($id_doc);
                break;
            case 'NC':
                $doc = NCCli::findOrFail($id_doc);
                break;
            default:
                break;
        }
        $this->descrTipoDoc = $doc->descr_tipodoc;
        if($doc->vettore){
            if($doc->tracking){
                if($doc->vettore->info){
                    $this->urlTracking= str_replace('<-id_tracking->', $doc->tracking, $doc->vettore->info->url);
                }
            }
        }
        $nameDoc = $doc->descr_tipodoc . " n." . $doc->num . "/" . $doc->data->year;
        return $nameDoc;
    }

}
