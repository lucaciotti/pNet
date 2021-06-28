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
        $lastMonth = new Carbon('first day of last month');
        $thisMonth = new Carbon('first day of this month');

        $nQuotes = QuoteCli::whereHas('rows', function ($query) {
                        return $query->where('qta_eva', '<', 'qta_ord');
                    })->count();

        // $nOrds = OrdCli::whereHas('rows', function ($query) {
        //                 return $query->where('qta_eva', '<', 'qta_ord');
        //             })->count();

        $nDDTs = DDTCli::where('data', '>=', $thisMonth->subDays(1))->count();
                    
        $nFattDir = FTCli::where('data', '>=', $lastMonth->subDays(1))->count();
        $nFattDif = FDCli::where('data', '>=', $lastMonth->subDays(1))->count();

        $nNewProds = 50; //Product::where('non_attivo', 0)->count();

        return view('home', [
            'nQuotes' => $nQuotes,
            'nDDTs' => $nDDTs,
            'nFattDir' => $nFattDir,
            'nFattDif' => $nFattDif,
            'nNewProds' => $nNewProds,
        ]);
    }

    public function showQuotes(Request $req)
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

    public function showDDTs(Request $req)
    {
        $thisMonth = new Carbon('first day of this month');
        
        $docs = DDTCli::where('data', '>=', $thisMonth->subDays(1))->with(['client'])->get();
        $descModulo = trans('doc.ddt_title');
                
        $docs = $docs->sortBy([
            ['data', 'desc'],
            ['id_doc', 'desc'],
        ]);

        return view('parideViews.docs.index', [
            'docs' => $docs,
            'tipomodulo' => "B",
            'descModulo' => $descModulo,
            'startDate' => $thisMonth->subDays(1),
            'endDate' => now(),
            'noDate' => false,
        ]);
    }

    public function showInvoices(Request $req, $tipomodulo = null)
    {
        $lastMonth = new Carbon('first day of last month');
        $thisMonth = new Carbon('first day of this month');
        
        $invoices = FTCli::where('data', '>=', $lastMonth->subDays(1))->with(['client'])->get();
        $invoicesDiff = FDCli::where('data', '>=', $lastMonth->subDays(1))->with(['client'])->get();
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
            'startDate' => $lastMonth->subDays(1),
            'endDate' => now(),
            'noDate' => false,
        ]);
    }

}
