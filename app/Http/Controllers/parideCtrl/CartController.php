<?php

namespace App\Http\Controllers\parideCtrl;

use App\Helpers\PdfReport;
use App\Http\Controllers\Controller;
use App\Jobs\emails\SendXwByEmail;
use Illuminate\Http\Request;
use Jackiedo\Cart\Facades\Cart;
use Carbon\Carbon;

use App\Models\parideModels\Docs\wDocHead;
use App\Models\parideModels\Docs\wDocNotes;
use App\Models\parideModels\Docs\wDocRow;
use RedisUser;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $req){
        if (!RedisUser::get('enable_ordweb') && !in_array(RedisUser::get('role'), ['agent', 'admin', 'superAgent'])) {
            return redirect('/home');
        }
        return view('parideViews.cart.index');
    }

    public function store(Request $req){
        // $cartItems=Cart::getDetails()->get('items');
        // $cartCount=$cartItems->count();
        // $codCli = Cart::getExtraInfo('customer.code', '');
        // $idDest = Cart::getExtraInfo('customer.destination', '');

        // if($cartCount==0){
        //     redirect()->route('cart::index');
        // }
        // if(empty($codCli)){
        //     redirect()->route('cart::index');
        // }

        // $id_doc = w

        redirect()->route('cart::list');
    }

    public function list(Request $req) {
        if (!RedisUser::get('enable_ordweb') && !in_array(RedisUser::get('role'), ['agent', 'admin', 'superAgent'])) {
            return redirect('/home');
        }
        $startDate = (now()->subMonths(2))->toDateString();
        $docs = wDocHead::where('created_at', '>=', $startDate)->with(['client'])->get();
                
        $docs = $docs->sortBy([
            ['data', 'desc'],
            ['id', 'desc'],
        ]);
        
        return view('parideViews.cart.list', [
            'docs' => $docs,
            'startDate' => $startDate,
            'endDate' => now(),
            'noDate' => false,
        ]);
    }

    public function fltList(Request $req)
    {
        $docs = wDocHead::with(['client']);

        //FILTRI
        if ($req->input('startDate')) {
            $startDate = (Carbon::createFromFormat('d/m/Y', $req->input('startDate')))->toDateString();
            $endDate = (Carbon::createFromFormat('d/m/Y', $req->input('endDate')))->toDateString();
        } else {
            $startDate = (Carbon::now()->subMonth())->toDateString();
            $endDate = (Carbon::now())->toDateString();
        }
        // $diff = $startDate->diffInDays($endDate);
        $noDate = $req->input('noDate');
        $ragSoc = $req->input('ragsoc');
        $ragsocOp = $req->input('ragsocOp');

        if (!$noDate) {
            $docs = $docs->whereBetween('created_at', [$startDate, $endDate]);
        }
        if ($ragSoc) {
            $ragsoc = strtoupper($ragSoc);
            if ($ragsocOp == 'eql') {
                $docs = $docs->whereHas('client', function ($query) use ($ragsoc) {
                    $query->where('rag_soc', $ragsoc)
                        ->withoutGlobalScope('agent')
                        ->withoutGlobalScope('superAgent')
                        ->withoutGlobalScope('client');
                });
            }
            if ($ragsocOp == 'stw') {
                $docs = $docs->whereHas('client', function ($query) use ($ragsoc) {
                    $query->where('rag_soc', 'like', $ragsoc . '%')
                        ->withoutGlobalScope('agent')
                        ->withoutGlobalScope('superAgent')
                        ->withoutGlobalScope('client');
                });
            }
            if ($ragsocOp == 'cnt') {
                $docs = $docs->whereHas('client', function ($query) use ($ragsoc) {
                    $query->where('rag_soc', 'like', '%' . $ragsoc . '%')
                        ->withoutGlobalScope('agent')
                        ->withoutGlobalScope('superAgent')
                        ->withoutGlobalScope('client');
                });
            }
        }

        $docs = $docs->get();

        $docs = $docs->sortBy([
            ['data', 'desc'],
            ['id', 'desc'],
        ]);

        return view('parideViews.cart.list', [
            'docs' => $docs,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'noDate' => $noDate,
            'ragSoc' => $ragSoc,
            'ragsocOp' => $ragsocOp,
        ]);
    }

    public function showDetail(Request $req, $id) {
        
        $doc = wDocHead::with([
                    'client' => function ($query) {
                        $query->withoutGlobalScope('agent')
                        ->withoutGlobalScope('superAgent')
                        ->withoutGlobalScope('client');
                    },
                    'rows' => function ($query) {
                        $query->orderBy('id', 'asc');
                    },
                    'destinazioni',
                ])->findOrFail($id);


        return view('parideViews.cart.detail', [
            'head' => $doc
        ]);

    }

    public function exportCsv(Request $req, $id)
    {
        $doc = wDocHead::with([
                    'client' => function ($query) {
                        $query->withoutGlobalScope('agent')
                        ->withoutGlobalScope('superAgent')
                        ->withoutGlobalScope('client');
                    },
                    'rows' => function ($query) {
                        $query->orderBy('id', 'asc');
                    },
                    'destinazioni',
                ])->findOrFail($id);


        $fileName = 'XW_'.$doc->id.'_'.$doc->id_cli_for.'_'.$doc->id_dest_pro.'.csv';
        
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('id_art', 'qta');

        $callback = function () use ($doc, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';');

            foreach ($doc->rows as $row) {
                if($row->id_art!=0){
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
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadPDF(Request $req, $id)
    {

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
        ])->findOrFail($id);
        

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
        $subTitle = $doc->descr_tipodoc . "_" . $doc->id . "/" . $doc->data->year;
        $view = 'parideViews._exports.pdf.xwDetailPdf';
        $data = [
            'head' => $doc,
            'tipodoc' => 'XW',
            'noteDoc' => $noteDoc,
        ];
        $pdf = PdfReport::A4Portrait($view, $data, $title, $subTitle);

        return $pdf->inline($title . '-' . $subTitle . '.pdf');
    }

    public function sendXW(Request $req, $id)
    {
        SendXwByEmail::dispatch($id)->onQueue('emails');

        return redirect()->back();
    }
}
