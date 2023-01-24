<?php

namespace App\Jobs\emails;

use App\Models\User;
use App\Mail\DdtShipped;
use App\Helpers\PdfReport;
use App\Mail\Docs\DocToSend;
use App\Mail\Docs\OrdToSend;
use Illuminate\Bus\Queueable;
use App\Models\parideModels\Client;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use App\Models\parideModels\Docs\FDCli;
use App\Models\parideModels\Docs\FPCli;
use App\Models\parideModels\Docs\FTCli;
use App\Models\parideModels\Docs\NCCli;
use Illuminate\Support\Facades\Storage;
use App\Models\parideModels\Docs\DDTCli;
use App\Models\parideModels\Docs\OrdCli;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\parideModels\Docs\QuoteCli;
use App\Models\parideModels\Docs\wDocSent;
use App\Models\parideModels\Docs\wOrdSent;
use App\Models\parideModels\Docs\wDocNotes;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendOneDocListedByEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
        Log::info('SendDocListByEmail Job Created');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(wOrdSent::where('id', $this->id)->exists()) {
            $ordToSend = wOrdSent::where('id', $this->id)->first();
            $user = User::where('codcli', $ordToSend->id_cli)->first();
            $client = Client::find($ordToSend->id_cli);
            $toEmail = 'pnet@lucaciotti.space';
            if ($user) {
                $toEmail = $this->setEmailTo($ordToSend->tipo_doc, $client);
                $fileToAttach = $this->createPdfDoc($ordToSend->tipo_doc, $ordToSend->id_doc);
                $mail = (new OrdToSend($user->id, $fileToAttach, $ordToSend->id))->onQueue('emails');
                if (App::environment(['local', 'staging'])) {
                    Mail::to('pnet@lucaciotti.space')->cc(['alexschiavon90@gmail.com', 'luca.ciotti@gmail.com'])->queue($mail);
                } else {
                    Mail::to($toEmail)->bcc(['alexschiavon90@gmail.com', 'luca.ciotti@gmail.com'])->queue($mail);
                }
            }
        } else {            
            $docToSend = wDocSent::where('id', $this->id)->first();
            $user = User::where('codcli', $docToSend->id_cli)->first();
            $client = Client::find($docToSend->id_cli);
            $toEmail = 'pnet@lucaciotti.space';
            if ($user) {
                $toEmail = $this->setEmailTo($docToSend->tipo_doc, $client);
                $fileToAttach = $this->createPdfDoc($docToSend->tipo_doc, $docToSend->id_doc);
                $mail = (new DocToSend($user->id, $fileToAttach, $docToSend->id))->onQueue('emails');
                if (App::environment(['local', 'staging'])) {
                    Mail::to('pnet@lucaciotti.space')->cc(['alexschiavon90@gmail.com', 'luca.ciotti@gmail.com'])->queue($mail);
                } else {
                    Mail::to($toEmail)->bcc(['alexschiavon90@gmail.com', 'luca.ciotti@gmail.com'])->queue($mail);
                }
            }
        }
    }

    protected function createPdfDoc($tipodoc, $id_doc)
    {
        switch ($tipodoc) {
            case 'XC':
                $doc = QuoteCli::with([
                    'client' => function ($query) {
                        $query->withoutGlobalScope('agent')
                        ->withoutGlobalScope('superAgent')
                        ->withoutGlobalScope('client');
                    },
                    'rows' => function ($query) {
                        $query->orderBy('id_ord_rig', 'asc')->with(['tva']);
                    },
                ])->findOrFail($id_doc);
                break;
            case 'OC':
                $doc = OrdCli::with([
                    'client' => function ($query) {
                        $query->withoutGlobalScope('agent')
                        ->withoutGlobalScope('superAgent')
                        ->withoutGlobalScope('client');
                    },
                    'rows' => function ($query) {
                        $query->orderBy('id_ord_rig', 'asc')->with(['tva']);
                    },
                ])->findOrFail($id_doc);
                break;
            case 'BO':
                $doc = DDTCli::with([
                    'client' => function ($query) {
                        $query->withoutGlobalScope('agent')
                        ->withoutGlobalScope('superAgent')
                        ->withoutGlobalScope('client');
                    },
                    'rows' => function ($query) {
                        $query->orderBy('id_doc_rig', 'asc')->with(['tva']);
                    },
                ])->findOrFail($id_doc);
                break;
            case 'FT':
                $doc = FTCli::with([
                    'client' => function ($query) {
                        $query->withoutGlobalScope('agent')
                        ->withoutGlobalScope('superAgent')
                        ->withoutGlobalScope('client');
                    },
                    'rows' => function ($query) {
                        $query->orderBy('id_doc_rig', 'asc')->with(['tva']);
                    },
                ])->findOrFail($id_doc);
                break;
            case 'FP':
                $doc = FPCli::with([
                    'client' => function ($query) {
                        $query->withoutGlobalScope('agent')
                        ->withoutGlobalScope('superAgent')
                        ->withoutGlobalScope('client');
                    },
                    'rows' => function ($query) {
                        $query->orderBy('id_ord_rig', 'asc')->with(['tva']);
                    },
                ])->findOrFail($id_doc);
                break;
            case 'FD':
                $doc = FDCli::with([
                    'client' => function ($query) {
                        $query->withoutGlobalScope('agent')
                        ->withoutGlobalScope('superAgent')
                        ->withoutGlobalScope('client');
                    },
                    'rows' => function ($query) {
                        $query->orderBy('id_doc_rig', 'asc')->with(['tva']);
                    },
                ])->findOrFail($id_doc);
                break;
            case 'NC':
                $doc = NCCli::with([
                    'client' => function ($query) {
                        $query->withoutGlobalScope('agent')
                        ->withoutGlobalScope('superAgent')
                        ->withoutGlobalScope('client');
                    },
                    'rows' => function ($query) {
                        $query->orderBy('id_doc_rig', 'asc')->with(['tva']);
                    },
                ])->findOrFail($id_doc);
                break;
            default:
                break;
        }

        $listNoteDoc = wDocNotes::where('start_date', '<=', $doc->data)
                            ->where('end_date', '>', $doc->data)
                            ->where('tipo_doc', $tipodoc)
                            ->orderBy('start_date')
                            ->get();
        
        $noteDoc='';                            
        foreach ($listNoteDoc as $note) {
            $noteDoc = nl2br($note->note) . '<br/>';
        } 

        $title = "Doc Detail";
        $filename = $doc->descr_tipodoc . "_" . $doc->num . "_" . $doc->data->year;
        $view = 'parideViews._exports.pdf.docDetailPdf';
        $data = [
            'head' => $doc,
            'tipodoc' => $tipodoc,
            'noteDoc' => $noteDoc,
        ];
        $pdf = PdfReport::A4Portrait($view, $data, $title, $filename);
        if (Storage::exists('DocPDFToSend/' . $filename . '.pdf')) {
            Storage::delete('DocPDFToSend/' . $filename . '.pdf');
        }
        $pdf->save(storage_path('app') . '/' . 'DocPDFToSend/' . $filename . '.pdf');
        return storage_path('app') . '/' . 'DocPDFToSend/' . $filename . '.pdf';
    }


    protected function setEmailTo($tipodoc, $client)
    {
        $toEmail = '';
        switch ($tipodoc) {
            case 'XC':
                if (!empty($client->e_mail_ordini) && filter_var($client->e_mail_ordini, FILTER_VALIDATE_EMAIL)) {
                    $toEmail = $client->e_mail_ordini;
                } else {
                    $toEmail = $client->e_mail;
                }
                break;
            case 'OC':
                if (!empty($client->e_mail_ordini) && filter_var($client->e_mail_ordini, FILTER_VALIDATE_EMAIL)) {
                    $toEmail = $client->e_mail_ordini;
                } else {
                    $toEmail = $client->e_mail;
                }
                break;
            case 'BO':
                if (!empty($client->e_mail_ddt) && filter_var($client->e_mail_ddt, FILTER_VALIDATE_EMAIL)) {
                    $toEmail = $client->e_mail_ddt;
                } else {
                    $toEmail = $client->e_mail;
                }
                break;
            case 'FT':
                if (!empty($client->e_mail_fatture) && filter_var($client->e_mail_fatture, FILTER_VALIDATE_EMAIL)) {
                    $toEmail = $client->e_mail_fatture;
                } else {
                    $toEmail = $client->e_mail;
                }
                break;
            case 'FP':
                if (!empty($client->e_mail_fatture) && filter_var($client->e_mail_fatture, FILTER_VALIDATE_EMAIL)) {
                    $toEmail = $client->e_mail_fatture;
                } else {
                    $toEmail = $client->e_mail;
                }
                break;
            case 'FD':
                if (!empty($client->e_mail_fatture) && filter_var($client->e_mail_fatture, FILTER_VALIDATE_EMAIL)) {
                    $toEmail = $client->e_mail_fatture;
                } else {
                    $toEmail = $client->e_mail;
                }
                break;
            case 'NC':
                if (!empty($client->e_mail_fatture) && filter_var($client->e_mail_fatture, FILTER_VALIDATE_EMAIL)) {
                    $toEmail = $client->e_mail_fatture;
                } else {
                    $toEmail = $client->e_mail;
                }
                break;
            default:
                break;
        }
        return $toEmail;
    }
}
