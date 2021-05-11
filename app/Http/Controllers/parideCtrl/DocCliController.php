<?php

namespace App\Http\Controllers\parideCtrl;

use App\Helpers\PdfReport;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
                $docs = QuoteCli::where('data', '>=', now()->subMonths(12))->with(['client'])->get();
                $descModulo = trans('doc.quotes_title');
                break;
            case 'O':
                $docs = OrdCli::where('data', '>=', now()->subMonths(12))->with(['client'])->get();
                $descModulo = trans('doc.orders_title');
                break;
            case 'B':
                $docs = DDTCli::where('data', '>=', now()->subMonths(12))->with(['client'])->get();
                $descModulo = trans('doc.ddt_title');
                break;
            case 'F':
                $invoices = FTCli::where('data', '>=', now()->subMonths(12))->with(['client'])->get();
                $invoicesFree = FPCli::where('data', '>=', now()->subMonths(12))->with(['client'])->get();
                $invoicesDiff = FDCli::where('data', '>=', now()->subMonths(12))->with(['client'])->get();
                $docs = $invoices->merge($invoicesFree)->merge($invoicesDiff);
                $descModulo = trans('doc.invoice_title');
                break;
            case 'N':
                $docs = NCCli::where('data', '>=', now()->subMonths(12))->with(['client'])->get();
                $descModulo = trans('doc.notecredito_title');
                break;

            default:
                $quotes = QuoteCli::where('data', '>=', now()->subMonths(12))->with(['client'])->get();
                $orders = OrdCli::where('data', '>=', now()->subMonths(12))->with(['client'])->get();
                $ddts = DDTCli::where('data', '>=', now()->subMonths(12))->with(['client'])->get();
                $invoices = FTCli::where('data', '>=', now()->subMonths(12))->with(['client'])->get();
                $invoicesFree = FPCli::where('data', '>=', now()->subMonths(12))->with(['client'])->get();
                $invoicesDiff = FDCli::where('data', '>=', now()->subMonths(12))->with(['client'])->get();
                $creditnotes = NCCli::where('data', '>=', now()->subMonths(12))->with(['client'])->get();
                $docs = $quotes->merge($orders)->merge($ddts)->merge($invoices)->merge($invoicesFree)->merge($invoicesDiff)->merge($creditnotes);
                $descModulo = trans('doc.documents');
                break;
            }
        $docs->sortBy([
            ['data', 'desc'],
            ['id_doc', 'desc'],
        ]);

        return view('parideViews.docs.index', [
            'docs' => $docs,
            'tipomodulo' => $tipomodulo,
            'descModulo' => $descModulo,
            'startDate' => now()->subMonths(12),
            'endDate' => now(),
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

        return $pdf->stream($title . '-' . $subTitle . '.pdf');
    }

}
