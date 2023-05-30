<?php

namespace App\Jobs\emails;

use App\Helpers\PdfReport;
use App\Mail\Docs\XwToSend;
use App\Models\parideModels\Docs\wDocHead;
use App\Models\parideModels\Docs\wDocNotes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Storage;

class SendXwByEmail implements ShouldQueue
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
        Log::info('SendXwByEmail Job Created');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (wDocHead::where('id', $this->id)->exists()) {
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
            // $user = User::where('codcli', $ordToSend->id_cli)->first();
            // $client = Client::find($doc->id_cli);
            $toEmail = 'pnet@lucaciotti.space';
            // if ($user) {
                // $toEmail = $this->setEmailTo($ordToSend->tipo_doc, $client);
                $filePDFToAttach = $this->createPdfDoc($doc);
                $fileCSVToAttach = $this->createCsvDoc($doc);
                $mail = (new XwToSend($filePDFToAttach, $fileCSVToAttach, $doc->id))->onQueue('emails');
                if (App::environment(['local', 'staging'])) {
                    Mail::to('pnet@lucaciotti.space')->cc(['luca.ciotti@gmail.com'])->queue($mail);
                } else {
                    Mail::to($toEmail)->bcc(['luca.ciotti@gmail.com'])->queue($mail);
                }
            // }
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
        $filename = $doc->descr_tipodoc . "_" . $doc->num . "_" . $doc->data->year;
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
        return Storage::putFileAs('app/XWToSend', $csvPath, $fileName);
    }
}
