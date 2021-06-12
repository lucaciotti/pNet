<?php

namespace App\Http\Controllers\parideCtrl;

use Carbon\Carbon;
use App\Helpers\PdfReport;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\parideModels\Client;
use App\Http\Controllers\Controller;
use App\Models\parideModels\Docs\FDCli;
use App\Models\parideModels\Docs\FPCli;
use App\Models\parideModels\Docs\FTCli;
use App\Models\parideModels\Docs\NCCli;
use App\Models\parideModels\Docs\DDTCli;
use App\Models\parideModels\Docs\OrdCli;
use App\Models\parideModels\Docs\QuoteCli;

class DocCliController extends Controller
{
    public function index(Request $req, $tipomodulo = null)
    {
        switch ($tipomodulo) {
            case 'P':
                $docs = QuoteCli::where('data', '>=', now()->subMonths(2))->with(['client'])->get();
                $descModulo = trans('doc.quotes_title');
                break;
            case 'O':
                $docs = OrdCli::where('data', '>=', now()->subMonths(2))->with(['client'])->get();
                $descModulo = trans('doc.orders_title');
                break;
            case 'B':
                $docs = DDTCli::where('data', '>=', now()->subMonths(2))->with(['client'])->get();
                $descModulo = trans('doc.ddt_title');
                break;
            case 'F':
                $invoices = FTCli::where('data', '>=', now()->subMonths(2))->with(['client'])->get();
                $invoicesFree = FPCli::where('data', '>=', now()->subMonths(2))->with(['client'])->get();
                $invoicesDiff = FDCli::where('data', '>=', now()->subMonths(2))->with(['client'])->get();
                $docs = $invoices->merge($invoicesFree)->merge($invoicesDiff);
                $descModulo = trans('doc.invoice_title');
                break;
            case 'N':
                $docs = NCCli::where('data', '>=', now()->subMonths(2))->with(['client'])->get();
                $descModulo = trans('doc.notecredito_title');
                break;

            default:
                $quotes = QuoteCli::where('data', '>=', now()->subMonths(2))->with(['client'])->get();
                $orders = OrdCli::where('data', '>=', now()->subMonths(2))->with(['client'])->get();
                $ddts = DDTCli::where('data', '>=', now()->subMonths(2))->with(['client'])->get();
                $invoices = FTCli::where('data', '>=', now()->subMonths(2))->with(['client'])->get();
                $invoicesFree = FPCli::where('data', '>=', now()->subMonths(2))->with(['client'])->get();
                $invoicesDiff = FDCli::where('data', '>=', now()->subMonths(2))->with(['client'])->get();
                $creditnotes = NCCli::where('data', '>=', now()->subMonths(2))->with(['client'])->get();
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
            'startDate' => now()->subMonths(2),
            'endDate' => now(),
            'noDate' => false,
        ]);
    }

    public function fltIndex(Request $req, $tipomodulo = null)
    {
        //FILTRI
        $tipomodulo = $req->input('optTipoDoc');
        if ($req->input('startDate')) {
            $startDate = Carbon::createFromFormat('d/m/Y', $req->input('startDate'));
            $endDate = Carbon::createFromFormat('d/m/Y', $req->input('endDate'));
        } else {
            $startDate = Carbon::now()->subMonth();
            $endDate = Carbon::now();
        }
        // $diff = $startDate->diffInDays($endDate);
        $noDate = $req->input('noDate');
        $ragSoc = $req->input('ragsoc');
        $ragsocOp = $req->input('ragsocOp');

        switch ($tipomodulo) {
            case 'P':
                $docs = $this->getFilteredTipoDocs('XC', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp);                
                $descModulo = trans('doc.quotes_title');
                break;
            case 'O':
                $docs = $this->getFilteredTipoDocs('OC', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp);
                $descModulo = trans('doc.orders_title');
                break;
            case 'B':
                $docs = $this->getFilteredTipoDocs('BO', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp);
                $descModulo = trans('doc.ddt_title');
                break;
            case 'F':
                $invoices = $this->getFilteredTipoDocs('FT', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp);
                $invoicesFree = $this->getFilteredTipoDocs('FP', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp);
                $invoicesDiff = $this->getFilteredTipoDocs('FD', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp);
                $docs = $invoices->merge($invoicesFree)->merge($invoicesDiff);
                $descModulo = trans('doc.invoice_title');
                break;
            case 'FD':
                $invoicesDiff = $this->getFilteredTipoDocs('FD', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp);
                $docs = $invoicesDiff;
                $descModulo = trans('doc.invoice_title');
                break;
            case 'N':
                $docs = $this->getFilteredTipoDocs('NC', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp);
                $descModulo = trans('doc.notecredito_title');
                break;

            default:
                $quotes = $this->getFilteredTipoDocs('XC', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp);
                $orders = $this->getFilteredTipoDocs('OC', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp);
                $ddts = $this->getFilteredTipoDocs('BO', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp);
                $invoices = $this->getFilteredTipoDocs('FT', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp);
                $invoicesFree = $this->getFilteredTipoDocs('FP', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp);
                $invoicesDiff = $this->getFilteredTipoDocs('FD', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp);
                $creditnotes = $this->getFilteredTipoDocs('NC', $startDate, $endDate, $noDate, $ragSoc, $ragsocOp);
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
        ]);
    }

    public function clientList(Request $req, $id_cli_for, $tipomodulo = null)
    {
        switch ($tipomodulo) {
            case 'P':
                $docs = QuoteCli::where('data', '>=', now()->subMonths(2))->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $descModulo = trans('doc.quotes_title');
                break;
            case 'O':
                $docs = OrdCli::where('data', '>=', now()->subMonths(2))->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $descModulo = trans('doc.orders_title');
                break;
            case 'B':
                $docs = DDTCli::where('data', '>=', now()->subMonths(2))->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $descModulo = trans('doc.ddt_title');
                break;
            case 'F':
                $invoices = FTCli::where('data', '>=', now()->subMonths(2))->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $invoicesFree = FPCli::where('data', '>=', now()->subMonths(2))->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $invoicesDiff = FDCli::where('data', '>=', now()->subMonths(2))->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $docs = $invoices->merge($invoicesFree)->merge($invoicesDiff);
                $descModulo = trans('doc.invoice_title');
                break;
            case 'N':
                $docs = NCCli::where('data', '>=', now()->subMonths(2))->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $descModulo = trans('doc.notecredito_title');
                break;

            default:
                $quotes = QuoteCli::where('data', '>=', now()->subMonths(2))->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $orders = OrdCli::where('data', '>=', now()->subMonths(2))->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $ddts = DDTCli::where('data', '>=', now()->subMonths(2))->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $invoices = FTCli::where('data', '>=', now()->subMonths(2))->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $invoicesFree = FPCli::where('data', '>=', now()->subMonths(2))->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $invoicesDiff = FDCli::where('data', '>=', now()->subMonths(2))->where('id_cli_for', $id_cli_for)->with(['client'])->get();
                $creditnotes = NCCli::where('data', '>=', now()->subMonths(2))->where('id_cli_for', $id_cli_for)->with(['client'])->get();
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
            'startDate' => now()->subMonths(2),
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

        // dd($doc);

        return view('parideViews.docs.detail', [
            'head' => $doc,
            'tipodoc' => $tipodoc,
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
        // $prevIds = DocRow::distinct('riffromt')->where('id_testa', $id_testa)->where('riffromt', '!=', 0)->get();
        // $prevDocs = DocCli::select('id', 'tipodoc', 'numerodoc', 'datadoc')->whereIn('id', $prevIds->pluck('riffromt'))->get();
        // $nextIds = DocRow::distinct('id_testa')->where('riffromt', $id_testa)->get();
        // $nextDocs = DocCli::select('id', 'tipodoc', 'numerodoc', 'datadoc')->whereIn('id', $nextIds->pluck('id_testa'))->get();

        // $totValueFOC = $rows->where('ommerce', true)->sum('prezzotot');

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
    protected function getFilteredTipoDocs($tipodoc, $startDate, $endDate, $noDate, $ragSoc, $ragsocOp){
        switch ($tipodoc) {
            case 'XC':
                $docs = QuoteCli::select('id_ord_tes', 'num', 'data', 'id_cli_for', 'tot_imp');
                break;
            case 'OC':
                $docs = OrdCli::select('id_ord_tes', 'num', 'data', 'id_cli_for', 'tot_imp');
                break;
            case 'BO':
                $docs = DDTCli::select('id_doc_tes', 'num', 'data', 'id_cli_for', 'tot_imp');
                break;
            case 'FT':
                $docs = FTCli::select('id_doc_tes', 'num', 'data', 'id_cli_for', 'tot_imp');
                break;
            case 'FP':
                $docs = FPCli::select('id_ord_tes', 'num', 'data', 'id_cli_for', 'tot_imp');
                break;
            case 'FD':
                $docs = FDCli::select('id_doc_tes', 'num', 'data', 'id_cli_for', 'tot_imp');
                break;
            case 'NC':
                $docs = NCCli::select('id_doc_tes', 'num', 'data', 'id_cli_for', 'tot_imp');
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
        $docs = $docs->with(['client' => function ($query) {
            $query
                ->withoutGlobalScope('agent')
                ->withoutGlobalScope('superAgent')
                ->withoutGlobalScope('client');
        }]);
        $docs = $docs->get();
        return $docs;
    }

}
