<?php

namespace App\Http\Controllers\parideCtrl;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\parideModels\Product;
use App\Models\parideModels\Docs\FDCli;
use App\Models\parideModels\Docs\FTCli;
use App\Models\parideModels\Docs\DDTCli;
use App\Models\parideModels\Docs\OrdCli;
use App\Models\parideModels\Docs\QuoteCli;
use App\Models\parideModels\Docs\wDocHead;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //dd(session('user.ditta_DB'));
        $dt = now();
        $lastMonth = (new Carbon('first day of last month'))->toDateString();
        $thisMonth = (new Carbon('first day of this month'))->toDateString();

        // $nQuotes = QuoteCli::whereHas('rows', function ($query) {
        //                 return $query->where('qta_eva', '<', 'qta_ord');
        //             })->count();
        $nQuotes = QuoteCli::where('data', '>=', $thisMonth)->count();

        // $nOrds = OrdCli::whereHas('rows', function ($query) {
        //                 return $query->where('qta_eva', '<', 'qta_ord');
        //             })->count();

        $nDDTs = DDTCli::where('data', '>=', $thisMonth)->count();
        $nXWs = wDocHead::where('data', '>=', $thisMonth)->count();
                    
        $nFattDir = FTCli::where('data', '>=', $lastMonth)->count();
        $nFattDif = FDCli::where('data', '>=', $lastMonth)->count();

        $nNewProds = 50; //Product::where('non_attivo', 0)->count();

        return view('home', [
            'nQuotes' => $nQuotes,
            'nDDTs' => $nDDTs,
            'nXWs' => $nXWs,
            'nFattDir' => $nFattDir,
            'nFattDif' => $nFattDif,
            'nNewProds' => $nNewProds,
        ]);
    }

    public function leftQuotes(Request $req)
    {        
        $docs = QuoteCli::whereHas('rows', function ($query) {
            return $query->where('qta_eva', '<', 'qta_ord');
        })->with(['client'])->get();
        $descModulo = trans('doc.quotes_title');
                
        $docs = $docs->sortBy([
            ['data', 'desc'],
            ['id_doc', 'desc'],
        ]);

        return view('parideViews.docs.index', [
            'docs' => $docs,
            'tipomodulo' => "P",
            'descModulo' => $descModulo,
            'startDate' => now()->subMonths(2),
            'endDate' => now(),
            'noDate' => true,
        ]);
    }

    public function newQuotes(Request $req)
    {
        $thisMonth = (new Carbon('first day of this month'))->toDateString();

        $docs = QuoteCli::where('data', '>=', $thisMonth)->with(['client'])->get();
        $descModulo = trans('doc.quotes_title');

        $docs = $docs->sortBy([
            ['data', 'desc'],
            ['id_doc', 'desc'],
        ]);

        return view('parideViews.docs.index', [
            'docs' => $docs,
            'tipomodulo' => "P",
            'descModulo' => $descModulo,
            'startDate' => $thisMonth,
            'endDate' => now(),
            'noDate' => false,
        ]);
    }

    public function showDDTs(Request $req)
    {
        $thisMonth = (new Carbon('first day of this month'))->toDateString();
        
        $docs = DDTCli::where('data', '>=', $thisMonth)->with(['client'])->get();
        $descModulo = trans('doc.ddt_title');
                
        $docs = $docs->sortBy([
            ['data', 'desc'],
            ['id_doc', 'desc'],
        ]);

        return view('parideViews.docs.index', [
            'docs' => $docs,
            'tipomodulo' => "B",
            'descModulo' => $descModulo,
            'startDate' => $thisMonth,
            'endDate' => now(),
            'noDate' => false,
        ]);
    }

    public function showInvoices(Request $req, $tipomodulo = null)
    {
        $lastMonth = (new Carbon('first day of last month'))->toDateString();
        $thisMonth = (new Carbon('first day of this month'))->toDateString();
        
        $invoices = FTCli::where('data', '>=', $lastMonth)->with(['client'])->get();
        $invoicesDiff = FDCli::where('data', '>=', $lastMonth)->with(['client'])->get();
        $docs = $invoices->merge($invoicesDiff);
        $descModulo = trans('doc.invoice_title');
                
        $docs = $docs->sortBy([
            ['data', 'desc'],
            ['id_doc', 'desc'],
        ]);

        return view('parideViews.docs.index', [
            'docs' => $docs,
            'tipomodulo' => 'F',
            'descModulo' => $descModulo,
            'startDate' => $lastMonth,
            'endDate' => now(),
            'noDate' => false,
        ]);
    }

}
