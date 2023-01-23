<?php

namespace App\Http\Controllers\parideCtrl;

use Carbon\Carbon;
use App\Helpers\PdfReport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\parideModels\Client;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\parideModels\Docs\FDCli;
use App\Models\parideModels\Docs\FPCli;
use App\Models\parideModels\Docs\FTCli;
use App\Models\parideModels\Docs\NCCli;
use App\Models\parideModels\Docs\DDTCli;
use App\Models\parideModels\Docs\OrdCli;
use App\Models\parideModels\Docs\RowDoc;
use App\Models\parideModels\Docs\QuoteCli;
use App\Models\parideModels\Docs\wDocNotes;

class DocCliController extends Controller
{
    public function index(Request $req, $tipomodulo = null)
    {
        $startDate = (now()->subMonths(2))->toDateString();
        switch ($tipomodulo) {
            case 'P':
                $docs = QuoteCli::where('data', '>=', $startDate)->with(['client'])->get();
                $descModulo = trans('doc.quotes_title');
                break;
            case 'O':
                $docs = OrdCli::where('data', '>=', $startDate)->with(['client'])->get();
                $descModulo = trans('doc.orders_title');
                break;
            case 'B':
                $docs = DDTCli::where('data', '>=', $startDate)->with(['client'])->get();
                $descModulo = trans('doc.ddt_title');
                break;
            case 'F':
                $invoices = FTCli::where('data', '>=', $startDate)->with(['client'])->get();
                $invoicesFree = FPCli::where('data', '>=', $startDate)->with(['client'])->get();
                $invoicesDiff = FDCli::where('data', '>=', $startDate)->with(['client'])->get();
                $docs = $invoices->merge($invoicesFree)->merge($invoicesDiff);
                $descModulo = trans('doc.invoice_title');
                break;
            case 'N':
                $docs = NCCli::where('data', '>=', $startDate)->with(['client'])->get();
                $descModulo = trans('doc.notecredito_title');
                break;

            default:
                $quotes = QuoteCli::where('data', '>=', $startDate)->with(['client'])->get();
                $orders = OrdCli::where('data', '>=', $startDate)->with(['client'])->get();
                $ddts = DDTCli::where('data', '>=', $startDate)->with(['client'])->get();
                $invoices = FTCli::where('data', '>=', $startDate)->with(['client'])->get();
                $invoicesFree = FPCli::where('data', '>=', $startDate)->with(['client'])->get();
                $invoicesDiff = FDCli::where('data', '>=', $startDate)->with(['client'])->get();
                $creditnotes = NCCli::where('data', '>=', $startDate)->with(['client'])->get();
                $docs = $quotes->merge($orders)->merge($ddts)->merge($invoices)->merge($invoicesFree)->merge($invoicesDiff)->merge($creditnotes);
                $descModulo = trans('doc.documents');
                break;
            }
        $docs = $docs->sortBy([
            ['data', 'desc'],
            ['id_doc', 'desc'],
        ]);
        
        return view('parideViews.docs.index', [
            'docs' => $docs,
            'tipomodulo' => $tipomodulo,
            'descModulo' => $descModulo,
            'startDate' => $startDate,
            'endDate' => now(),
            'noDate' => false,
        ]);
    }

    public function fltIndex(Request $req, $tipomodulo = null)
    {
        //FILTRI
        $tipomodulo = $req->input('optTipoDoc');
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
        $numdoc = $req->input('numdoc');
        $numdocOp = $req->input('numdocOp');

        switch ($tipomodulo) {
            case 'P':
                $docs = $this->getFilteredTipoDocs('XC', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp, $numdoc, $numdocOp);                
                $descModulo = trans('doc.quotes_title');
                break;
            case 'O':
                $docs = $this->getFilteredTipoDocs('OC', $startDate, $endDate, $noDate, $ragSoc,$ragsocOp, $numdoc, $numdocOp);
                $descModulo = trans('doc.orders_title');
                break;
            case 'B':
                $docs = $this->getFilteredTipoDocs('BO', $startDate, $endDate, $noDate, $ragSoc,$ragsocOp, $numdoc, $numdocOp);
                $descModulo = trans('doc.ddt_title');
                break;
            case 'F':
                $invoices = $this->getFilteredTipoDocs('FT', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp, $numdoc, $numdocOp);
                $invoicesFree = $this->getFilteredTipoDocs('FP', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp, $numdoc, $numdocOp);
                $invoicesDiff = $this->getFilteredTipoDocs('FD', $startDate, $endDate, $noDate, $ragSoc,$ragsocOp, $numdoc, $numdocOp);
                $docs = $invoices->merge($invoicesFree)->merge($invoicesDiff);
                $descModulo = trans('doc.invoice_title');
                break;
            case 'FD':
                $invoicesDiff = $this->getFilteredTipoDocs('FD', $startDate, $endDate, $noDate, $ragSoc,$ragsocOp, $numdoc, $numdocOp);
                $docs = $invoicesDiff;
                $descModulo = trans('doc.invoice_title');
                break;
            case 'N':
                $docs = $this->getFilteredTipoDocs('NC', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp, $numdoc, $numdocOp);
                $descModulo = trans('doc.notecredito_title');
                break;

            default:
                $quotes = $this->getFilteredTipoDocs('XC', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp, $numdoc, $numdocOp);
                $orders = $this->getFilteredTipoDocs('OC', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp, $numdoc, $numdocOp);
                $ddts = $this->getFilteredTipoDocs('BO', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp, $numdoc, $numdocOp);
                $invoices = $this->getFilteredTipoDocs('FT', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp, $numdoc, $numdocOp);
                $invoicesFree = $this->getFilteredTipoDocs('FP', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp, $numdoc, $numdocOp);
                $invoicesDiff = $this->getFilteredTipoDocs('FD', $startDate, $endDate, $noDate, $ragSoc,$ragsocOp, $numdoc, $numdocOp);
                $creditnotes = $this->getFilteredTipoDocs('NC', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp, $numdoc, $numdocOp);
                $docs = $quotes->merge($orders)->merge($ddts)->merge($invoices)->merge($invoicesFree)->merge($invoicesDiff)->merge($creditnotes);
                $descModulo = trans('doc.documents');
                break;
        }

        $docs = $docs->sortBy([
            ['data', 'desc'],
            ['id_doc', 'desc'],
        ]);

        return view('parideViews.docs.index', [
            'docs' => $docs,
            'tipomodulo' => $tipomodulo,
            'descModulo' => $descModulo,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'noDate' => $noDate,
            'ragSoc' => $ragSoc,
            'ragsocOp' => $ragsocOp,
            'numdoc' => $numdoc,
            'numdocOp' => $numdocOp,
        ]);
    }

    public function clientList(Request $req, $id_cli_for, $tipomodulo = null)
    {
        $startDate = (now()->subMonths(2))->toDateString();
        switch ($tipomodulo) {
            case 'P':
                $docs = QuoteCli::where('data', '>=', $startDate)->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $descModulo = trans('doc.quotes_title');
                break;
            case 'O':
                $docs = OrdCli::where('data', '>=', $startDate)->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $descModulo = trans('doc.orders_title');
                break;
            case 'B':
                $docs = DDTCli::where('data', '>=', $startDate)->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $descModulo = trans('doc.ddt_title');
                break;
            case 'F':
                $invoices = FTCli::where('data', '>=', $startDate)->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $invoicesFree = FPCli::where('data', '>=', $startDate)->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $invoicesDiff = FDCli::where('data', '>=', $startDate)->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $docs = $invoices->merge($invoicesFree)->merge($invoicesDiff);
                $descModulo = trans('doc.invoice_title');
                break;
            case 'N':
                $docs = NCCli::where('data', '>=', $startDate)->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $descModulo = trans('doc.notecredito_title');
                break;

            default:
                $quotes = QuoteCli::where('data', '>=', $startDate)->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $orders = OrdCli::where('data', '>=', $startDate)->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $ddts = DDTCli::where('data', '>=', $startDate)->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $invoices = FTCli::where('data', '>=', $startDate)->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $invoicesFree = FPCli::where('data', '>=', $startDate)->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $invoicesDiff = FDCli::where('data', '>=', $startDate)->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $creditnotes = NCCli::where('data', '>=', $startDate)->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $docs = $quotes->merge($orders)->merge($ddts)->merge($invoices)->merge($invoicesFree)->merge($invoicesDiff)->merge($creditnotes);
                $descModulo = trans('doc.documents');
                break;
        }
        $docs = $docs->sortBy([
            ['data', 'desc'],
            ['id_doc', 'desc'],
        ]);

        $client = Client::select('rag_soc')->where('id_cli_for', $id_cli_for)->first();

        return view('parideViews.docs.index', [
            'docs' => $docs,
            'tipomodulo' => $tipomodulo,
            'descModulo' => $descModulo,
            'startDate' => $startDate,
            'endDate' => now(),
            'noDate' => false,
            'ragSoc' => $client->rag_soc,
        ]);
    }

    public function showDetail(Request $req, $tipodoc, $id_doc) {
        switch ($tipodoc) {
            case 'XC':
                $doc = QuoteCli::with([
                            'client' => function ($query) {
                                $query->withoutGlobalScope('agent')
                                ->withoutGlobalScope('superAgent')
                                ->withoutGlobalScope('client');
                            },
                            'rows' => function ($query) {
                                $query->orderBy('id_ord_rig', 'asc')->with('tva');
                            },
                            'destinazioni',
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
                                $query->orderBy('id_ord_rig', 'asc')->with('tva');
                            },
                            'destinazioni',
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
                                $query->orderBy('id_doc_rig', 'asc')->with('tva');
                            },
                            'destinazioni',
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
                                $query->orderBy('id_doc_rig', 'asc')->with('tva');
                            },
                            'destinazioni',
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
                                $query->orderBy('id_ord_rig', 'asc')->with('tva');
                            },
                            'destinazioni',
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
                                $query->orderBy('id_doc_rig', 'asc')->with('tva');
                            },
                            'destinazioni',
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
                                $query->orderBy('id_doc_rig', 'asc')->with('tva');
                            },
                            'destinazioni',
                        ])->findOrFail($id_doc);
                break;
            default:
                break;
        }

        // dd($doc);
        $prevDocs = $this->searchPrevDocs($doc->rows);
        $nextDocs = $this->searchNextDocs($doc->num, $doc->data);

        return view('parideViews.docs.detail', [
            'head' => $doc,
            'tipodoc' => $tipodoc,
            'prevDocs' => $prevDocs,
            'nextDocs' => $nextDocs,
        ]);

    }

    // EXPORT Docs
    public function downloadPDF(Request $req, $tipodoc, $id_doc) {
        switch ($tipodoc) {
            case 'XC':
                $doc = QuoteCli::with([
                    'client' => function ($query) {
                        $query->withoutGlobalScope('agent')
                            ->withoutGlobalScope('superAgent')
                            ->withoutGlobalScope('client');
                    },
                    'rows' => function ($query) {
                        $query->orderBy('id_ord_rig', 'asc')->with(['tva', 'skuCustomCode']);
                    },
                    'destinazioni',
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
                        $query->orderBy('id_ord_rig', 'asc')->with(['tva', 'skuCustomCode']);
                    },
                    'destinazioni',
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
                        $query->orderBy('id_doc_rig', 'asc')->with(['tva', 'skuCustomCode']);
                    },
                    'destinazioni',
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
                        $query->orderBy('id_doc_rig', 'asc')->with(['tva', 'skuCustomCode']);
                    },
                    'destinazioni',
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
                        $query->orderBy('id_ord_rig', 'asc')->with(['tva', 'skuCustomCode']);
                    },
                    'destinazioni',
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
                        $query->orderBy('id_doc_rig', 'asc')->with(['tva', 'skuCustomCode']);
                    },
                    'destinazioni',
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
                        $query->orderBy('id_doc_rig', 'asc')->with(['tva', 'skuCustomCode']);
                    },
                    'destinazioni',
                ])->findOrFail($id_doc);
                break;
            default:
                break;
        }
        // $prevIds = DocRow::distinct('riffromt')->where('id_testa', $id_testa)->where('riffromt', '!=', 0)->get();
        // $prevDocs = DocCli::select('id', 'tipodoc', 'numerodoc', 'datadoc')->whereIn('id', $prevIds->pluck('riffromt'))->get();
        // $nextIds = DocRow::distinct('id_testa')->where('riffromt', $id_testa)->get();
        // $nextDocs = DocCli::select('id', 'tipodoc', 'numerodoc', 'datadoc')->whereIn('id', $nextIds->pluck('id_testa'))->get();

        // $totValueFOC = $rows->where('ommerce', true)->sum('prezzotot');

        $noteDoc = wDocNotes::where('start_date', '<=', $doc->data)
                            ->where('end_date', '>', $doc->data)
                            ->where('tipo_doc', $tipodoc)->first()->note;
        
        // dd($noteDoc);

        $title = "Doc Detail";
        $subTitle = $doc->descr_tipodoc . "_" . $doc->num . "/" . $doc->data->year;
        $view = 'parideViews._exports.pdf.docDetailPdf';
        $data = [
            'head' => $doc,
            'tipodoc' => $tipodoc,
        ];
        $pdf = PdfReport::A4Portrait($view, $data, $title, $subTitle);

        return $pdf->inline($title . '-' . $subTitle . '.pdf');
    }

    //PROTECTED FUNCTIONS
    protected function getFilteredTipoDocs($tipodoc, $startDate, $endDate, $noDate, $ragSoc, $ragsocOp, $numdoc, $numdocOp){
        switch ($tipodoc) {
            case 'XC':
                $docs = QuoteCli::select('id_ord_tes', 'num', 'data', 'id_cli_for','tot_imp', 'tot_iva');
                break;
            case 'OC':
                $docs = OrdCli::select('id_ord_tes', 'num', 'data', 'id_cli_for', 'tot_imp', 'tot_iva');
                break;
            case 'BO':
                $docs = DDTCli::select('id_doc_tes', 'num', 'data', 'id_cli_for', 'tot_imp', 'tot_rit', 'tot_iva');
                break;
            case 'FT':
                $docs = FTCli::select('id_doc_tes', 'num', 'data', 'id_cli_for', 'tot_imp', 'tot_rit', 'tot_iva');
                break;
            case 'FP':
                $docs = FPCli::select('id_ord_tes', 'num', 'data', 'id_cli_for', 'tot_imp', 'tot_iva');
                break;
            case 'FD':
                $docs = FDCli::select('id_doc_tes', 'num', 'data', 'id_cli_for', 'tot_imp', 'tot_rit', 'tot_iva');
                break;
            case 'NC':
                $docs = NCCli::select('id_doc_tes', 'num', 'data', 'id_cli_for', 'tot_imp', 'tot_rit', 'tot_iva');
                break;
            default:
                break;
        }

        if (!$noDate) {
            $docs = $docs->whereBetween('data', [$startDate, $endDate]);
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
        if ($numdoc) {
            if ($numdocOp == 'eql') {
                $docs = $docs->where('num', $numdoc);
            }
            if ($numdocOp == 'stw') {
                $docs = $docs->where('num', 'like', $numdoc . '%');
            }
            if ($numdocOp == 'cnt') {
                $docs = $docs->where('num', 'like', '%' . $numdoc . '%');
            }
        }
        $docs = $docs->with(['client' => function ($query) {
            $query
                ->withoutGlobalScope('agent')
                ->withoutGlobalScope('superAgent')
                ->withoutGlobalScope('client');
        }]);
        $docs = $docs->get();
        return $docs;
    }

    protected function searchPrevDocs($rows){
        $listDocs = collect();
        foreach($rows as $row){
            $tipodoc = null;
            $numdoc = null;
            $datadoc = null;
            if(empty($row->id_art) && stripos($row->descr, 'rif')!==false){
                if(stripos($row->descr, 'off')!==false){
                    $tipodoc= 'OC';
                }
                if (stripos($row->descr, 'ordine') !== false) {
                    $tipodoc = 'OC';
                }
                if (stripos($row->descr, 'ddt') !== false) {
                    $tipodoc = 'BO';
                }
                $n = preg_match_all('!\d+!', $row->descr, $matches);
                if($n==4 && stripos($row->descr, 'vostro') === false){
                    $numdoc = $matches[0][0];
                    try{
                        if(Str::length($matches[0][3])==4){
                            $datadoc = (Carbon::createFromFormat('Y-m-d', $matches[0][3] . "-" . $matches[0][2] . "-" . $matches[0][1]))->toDateString();
                        } else {
                            $datadoc = (Carbon::createFromFormat('Y-m-d', "20" . $matches[0][3] . "-" . $matches[0][2] . "-" . $matches[0][1]))->toDateString();
                        }
                        if ($tipodoc != null) $prevDoc = $this->getDocFromTipoNumData($tipodoc, $numdoc, $datadoc);
                        if (!$prevDoc->isEmpty()) $listDocs = $listDocs->merge($prevDoc);
                    } catch (\Exception $e) {
                        Log::error("Error Search Prev Doc: " .$e->getMessage());
                    }
                }
            }
        }
        return $listDocs;
    }

    protected function searchNextDocs($numdoc, $datadoc){
        $dateString = $datadoc->format('d-m-y');
        $rowsFound=RowDoc::select('id_doc_tes')
            ->where('id_art', '==', '')
            ->where('descr', 'LIKE', '%'.$numdoc.'%')
            ->where('descr', 'LIKE', '%' . $dateString . '%')
            ->get();
        $ddt = DDTCli::select('id_doc_tes', 'num', 'data', 'id_cli_for')
            ->whereIn('id_doc_tes', $rowsFound->pluck('id_doc_tes')->all())
            ->get();
        $ft = FTCli::select('id_doc_tes', 'num', 'data', 'id_cli_for')
            ->whereIn('id_doc_tes', $rowsFound->pluck('id_doc_tes')->all())
            ->get();
        $fd = FDCli::select('id_doc_tes', 'num', 'data', 'id_cli_for')
            ->whereIn('id_doc_tes', $rowsFound->pluck('id_doc_tes')->all())
            ->get();
        $listDocs = collect()->merge($ddt)->merge($ft)->merge($fd);
        // dd($listDocs);
        return $listDocs;
    }

    protected function getDocFromTipoNumData($tipodoc, $numerodoc, $datadoc){
        switch ($tipodoc) {
            case 'XC':
                $doc = QuoteCli::select('id_ord_tes', 'num', 'data', 'id_cli_for');
                break;
            case 'OC':
                $doc = OrdCli::select('id_ord_tes', 'num', 'data', 'id_cli_for');
                break;
            case 'BO':
                $doc = DDTCli::select('id_doc_tes', 'num', 'data', 'id_cli_for');
                break;
            case 'FT':
                $doc = FTCli::select('id_doc_tes', 'num', 'data', 'id_cli_for');
                break;
            case 'FP':
                $doc = FPCli::select('id_ord_tes', 'num', 'data', 'id_cli_for');
                break;
            case 'FD':
                $doc = FDCli::select('id_doc_tes', 'num', 'data', 'id_cli_for');
                break;
            case 'NC':
                $doc = NCCli::select('id_doc_tes', 'num', 'data', 'id_cli_for');
                break;
            default:
                break;
        }

        $doc = $doc->where('num', $numerodoc);
        $doc = $doc->where('data', $datadoc);
        $doc = $doc->get();
        if($doc->isEmpty()){
            if($tipodoc=='OC'){
                return $this->getDocFromTipoNumData('XC', $numerodoc, $datadoc);
            }
        }
        return $doc;
    }

}
