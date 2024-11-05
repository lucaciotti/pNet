<?php

namespace App\Mail\Docs;

use App;
use App\Models\parideModels\Client;
use App\Models\parideModels\Docs\wDocHead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Log;

class XwToSend extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $client;
    public $idOrdListed;
    public $filePDFToAttach;
    public $fileCSVToAttach;
    public $url;
    public $urlClient;
    public $urlXW;
    public $descrTipoDoc;
    public $doc;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($filePDFToAttach, $fileCSVToAttach, $idOrdListed)
    {
        $this->idOrdListed = $idOrdListed;
        Log::info('Email file PDF Attached: ' . $filePDFToAttach);
        Log::info('Email file CSV Attached: ' . $fileCSVToAttach);
        $this->filePDFToAttach = $filePDFToAttach;
        $this->fileCSVToAttach = $fileCSVToAttach;
        $this->url = route("cart::list");
        $this->urlXW = route("cart::docdetail", [$idOrdListed]);
        // $this->urlInvito = route("user::resetPassword", $this->user->id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->doc = wDocHead::select('id', 'id_cli_for', 'rif_num', 'data')->findOrFail($this->idOrdListed);
        $this->client = Client::find($this->doc->id_cli_for);
        $this->urlClient = route("client::detail", $this->doc->id_cli_for);
        // $from = 'ordini@ferramentaparide.it';
        if (App::environment(['local', 'staging'])) {
            $from = 'pnet@lucaciotti.space';
        } else {
            $from = 'ordini@ferramentaparide.it';
        }
        $nameDoc = $this->getNameDoc($this->doc);
        Log::info('Invio ' . $nameDoc . '- Mail interna');
        return $this->from($from, 'pNet - Ferramenta Paride')
                    ->subject('Invio ' . $nameDoc . ' - Ferramenta Paride')
                    ->markdown('parideViews._emails.docs.xwToSend')
                    ->attach($this->filePDFToAttach)
                    ->attach($this->fileCSVToAttach);
        // return $this->view('view.name');
    }

    protected function getNameDoc($doc)
    {
        $this->descrTipoDoc = $doc->descr_tipodoc;
        $nameDoc = $doc->descr_tipodoc . " n." . $doc->id . "/" . $doc->data->year;
        return $nameDoc;
    }
}
