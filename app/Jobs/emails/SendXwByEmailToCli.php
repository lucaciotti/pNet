<?php

namespace App\Jobs\emails;

use App\Models\User;
use App\Helpers\PdfReport;
use Illuminate\Bus\Queueable;
use App\Models\parideModels\Client;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\parideModels\Docs\wDocNotes;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Mail\Docs\XwToSendToCli;
use App\Models\parideModels\Docs\wDocHead;

class SendXwByEmailToCli implements ShouldQueue
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
        Log::info('SendXwByEmailToCli Job Created');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(wDocHead::where('id', $this->id)->exists()) {
            $doc = wDocHead::with([
                'client' => function ($query) {
                    $query->withoutGlobalScope('agent')
                        ->withoutGlobalScope('superAgent')
                        ->withoutGlobalScope('client');
                },
                'rows' => function ($query) {
                    $query->orderBy('id', 'asc');
                },
                'destinazioni', 'payType'
            ])->findOrFail($this->id);
            $user = User::where('codcli', $doc->id_cli_for)->first();
            $client = Client::find($doc->id_cli_for);
            $toEmail = 'pnet@lucaciotti.space';
            $filePDFToAttach = $this->createPdfDoc($doc);
            $fileCSVToAttach = $this->createCsvDoc($doc);
            // $filePDFToAttach = $fileCSVToAttach;
            if ($user) {
                $toEmail = $client->e_mail;
                $mail = (new XwToSendToCli($user->id, $filePDFToAttach, $fileCSVToAttach, $doc->id))->onQueue('emails');
                if (App::environment(['local', 'staging'])) {
                    Mail::to('pnet@lucaciotti.space')->cc(['alexschiavon90@gmail.com', 'luca.ciotti@gmail.com'])->queue($mail);
                    // Mail::to('pnet@lucaciotti.space')->cc(['luca.ciotti@gmail.com'])->queue($mail);
                } else {
                    Mail::to($toEmail)->bcc(['alexschiavon90@gmail.com', 'luca.ciotti@gmail.com'])->queue($mail);
                }
            }
        } 
    }

    protected function createPdfDoc($doc)
    {
        $listNoteDoc = wDocNotes::where('start_date', '<=', $doc->data)
            ->where('end_date', '>', $doc->data)
            ->where('tipo_doc', 'XW')
            ->orderBy('start_date')
            ->get();

        $noteDoc = '';
        foreach ($listNoteDoc as $note) {
            $noteDoc .= nl2br($note->note) . '<br/>';
        }
        // dd($noteDoc);

        $title = "Doc Detail";
        $filename = $doc->descr_tipodoc . "_" . $doc->id . "_" . $doc->data->year;
        $view = 'parideViews._exports.pdf.xwDetailPdf';
        $data = [
            'head' => $doc,
            'tipodoc' => 'XW',
            'noteDoc' => $noteDoc,
        ];
        $pdf = PdfReport::A4Portrait($view, $data, $title, $filename);

        if (Storage::exists('XWToSend/' . $filename . '.pdf')) {
            Storage::delete('XWToSend/' . $filename . '.pdf');
        }
        $pdf->save(storage_path('app') . '/' . 'XWToSend/' . $filename . '.pdf');
        return storage_path('app') . '/' . 'XWToSend/' . $filename . '.pdf';
    }

    public function createCsvDoc($doc)
    {
        $fileName = 'XW_' . $doc->id . '_' . $doc->id_cli_for . '_' . $doc->id_dest_pro . '.csv';

        $csvFile = tmpfile();
        $csvPath = stream_get_meta_data($csvFile)['uri'];

        $columns = array('id_art', 'qta');

        $file = fopen($csvPath, 'w');
        fputcsv($file, $columns, ';');

        foreach ($doc->rows as $row) {
            if ($row->id_art != 0) {
                $row['id_art']  = $row->id_art;
                $row['qta']  = $row->quantity;

                fputcsv(
                    $file,
                    array(
                        $row['id_art'],
                        $row['qta'],
                    ),
                    ';'
                );
            }
        }

        fclose($file);
        if (Storage::exists('XWToSend/' . $fileName)) {
            Storage::delete('XWToSend/' . $fileName);
        }
        Storage::putFileAs('XWToSend', $csvPath, $fileName);
        return storage_path('app') . '/' . 'XWToSend/' . $fileName;
    }

}
