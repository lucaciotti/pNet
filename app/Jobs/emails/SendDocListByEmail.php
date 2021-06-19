<?php

namespace App\Jobs\emails;

use App\Models\User;
use App\Mail\DdtShipped;
use App\Helpers\PdfReport;
use App\Models\parideModels\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use App\Models\parideModels\Docs\FDCli;
use App\Models\parideModels\Docs\FPCli;
use App\Models\parideModels\Docs\FTCli;
use App\Models\parideModels\Docs\NCCli;
use App\Models\parideModels\Docs\DDTCli;
use App\Models\parideModels\Docs\OrdCli;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\parideModels\Docs\QuoteCli;
use App\Models\parideModels\Docs\wDocSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendDocListByEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        Log::info('SendDocListByEmail Job Created');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('SendDocListByEmail Job Started');

        $listOfDocs = wDocSent::where('inviato', false)->get();

        foreach ($listOfDocs as $docToSend) {
            $user = User::where('codcli', $docToSend->id_cli)->first();
            $client = Client::find($docToSend->id_cli);
            $isInvio = ($client->fatt_email || $user->auto_email); 
            if($isInvio) {                
                $toEmail = [$client->e_mail, $client->e_mail_ddt];
                $fileToAttach = $this->createPdfDoc($docToSend->tipo_doc, $docToSend->id_doc);
                $mail = (new DdtShipped($user->id, $fileToAttach, $docToSend->id))->onQueue('emails');
                if (App::environment(['local', 'staging'])) {
                    Mail::to('pnet@lucaciotti.space')->cc(['luca.ciotti@gmail.com'])->queue($mail);
                } else {
                    Mail::to('pnet@lucaciotti.space')->cc(['alexschiavon90@gmail.com', 'luca.ciotti@gmail.com'])->queue($mail);
                }
            }
        }
    }

    protected function createPdfDoc($tipodoc, $id_doc){
        switch ($tipodoc) {
            case 'XC':
                $doc = QuoteCli::with([
                    'client' => function ($query) {
                        $query->withoutGlobalScope('agent')
                            ->withoutGlobalScope('superAgent')
                            ->withoutGlobalScope('client');
                    },
                    'rows' => function ($query) {
                        $query->orderBy('id_ord_rig', 'asc');
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
                        $query->orderBy('id_ord_rig', 'asc');
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
                        $query->orderBy('id_doc_rig', 'asc');
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
                        $query->orderBy('id_doc_rig', 'asc');
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
                        $query->orderBy('id_ord_rig', 'asc');
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
                        $query->orderBy('id_doc_rig', 'asc');
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
                        $query->orderBy('id_doc_rig', 'asc');
                    },
                ])->findOrFail($id_doc);
                break;
            default:
                break;
        }
        $title = "Doc Detail";
        $filename = $doc->descr_tipodoc . "_" . $doc->num . "_" . $doc->data->year;
        $view = 'parideViews._exports.pdf.docDetailPdf';
        $data = [
            'head' => $doc,
            'tipodoc' => $tipodoc,
        ];
        $pdf = PdfReport::A4Portrait($view, $data, $title, $filename);
        $pdf->save(storage_path('app') . '/' .'DocPDFToSend/'.$filename.'.pdf');
        return storage_path('app') .'/'. 'DocPDFToSend/' . $filename . '.pdf';
    }
}
