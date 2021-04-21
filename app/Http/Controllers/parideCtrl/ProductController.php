<?php

namespace App\Http\Controllers\parideCtrl;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\parideModels\GrpProd;
use App\Models\parideModels\Product;
use App\Models\parideModels\SubGrpProd;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $req)
    {
        $masterGrps = GrpProd::orderBy('id_fam')->get();
        $masterGrpFilter = $masterGrps->first()->id_fam;
        // ->whereRaw('left(id_fam,2) = ?', $masterGrpFilter)
        $gruppi = SubGrpProd::where('id_fam', '!=', '')->orderBy('id_fam')->get();
        $grpSelected = $gruppi->first()->id_fam;

        $products = Product::select('id_art', 'descr', 'um', 'pz_x_conf', 'id_fam', 'id_cod_bar', 'id_cli_for')
            ->where('id_fam', $grpSelected)->orderBy('id_art');
        $products = $products->with('grpProd')->with('supplier')->get();


        return view('parideViews.prods.index', [
            'products' => $products,
            'masterGrps' => $masterGrps,
            'gruppi' => $gruppi,
            'grpSelected' => Arr::wrap($grpSelected),
            'masterGrpFilter' => Arr::wrap($masterGrpFilter),
        ]);
    }

    public function fltIndex(Request $req)
    {

        $products = Product::select('id_art', 'descr', 'um', 'pz_x_conf', 'id_fam', 'id_cod_bar', 'id_cli_for');

        if ($req->input('codArt')) {
            if ($req->input('codArtOp') == 'eql') {
                $products = $products->where('id_art', strtoupper($req->input('codArt')));
            }
            if ($req->input('codArtOp') == 'stw') {
                $products = $products->where('id_art', 'LIKE', strtoupper($req->input('codArt')) . '%');
            }
            if ($req->input('codArtOp') == 'cnt') {
                $products = $products->where('id_art', 'LIKE', '%' . strtoupper($req->input('codArt')) . '%');
            }
        }

        if ($req->input('descrArt')) {
            if ($req->input('descrOp') == 'eql') {
                $products = $products->where('descr', strtoupper($req->input('descrArt')));
            }
            if ($req->input('descrOp') == 'stw') {
                $products = $products->where('descr', 'LIKE', strtoupper($req->input('descrArt')) . '%');
            }
            if ($req->input('descrOp') == 'cnt') {
                $products = $products->where('descr', 'LIKE', '%' . strtoupper($req->input('descrArt')) . '%');
            }
        }

        if ($req->input('barcode')) {
            if ($req->input('barcodeOp') == 'eql') {
                $products = $products->where('id_cod_bar', strtoupper($req->input('barcode')));
            }
            if ($req->input('barcodeOp') == 'stw') {
                $products = $products->where('id_cod_bar', 'LIKE', strtoupper($req->input('barcode')) . '%');
            }
            if ($req->input('barcodeOp') == 'cnt') {
                $products = $products->where('id_cod_bar', 'LIKE', '%' . strtoupper($req->input('barcode')) . '%');
            }
        }

        if ($req->input('grpSelected')) {
            $products = $products->whereIn('id_fam', $req->input('grpSelected'));
        }

        // $listGrp = '';
        // if ($req->input('masterGrpFilter')) {
        //     $first = true;
        //     foreach ($req->input('masterGrpFilter') as $value) {
        //         if (!$first) $listGrp = $listGrp . ', ';
        //         $listGrp .= $value ;
        //         $first = false;
        //     }
        //     $products = $products->whereRaw('left(id_fam,2) IN ( ? )', $listGrp);
        // } 

        $products = $products->orderBy('id_art')
            ->with('grpProd')->with('supplier')->get();

        $masterGrps = GrpProd::orderBy('id_fam')->get();
        // $gruppi = SubGrpProd::whereRaw('left(id_fam,2) IN ( ? )', $listGrp)->orderBy('id_fam')->get();
        $gruppi = SubGrpProd::orderBy('id_fam')->get();
        

        return view('parideViews.prods.index', [
            'products' => $products,
            'masterGrps' => $masterGrps,
            'gruppi' => $gruppi,
            'codArt' => $req->input('codArt'),
            'descrArt' => $req->input('descrArt'),
            'barcode' => $req->input('barcode'),
            'grpSelected' => $req->input('grpSelected'),
            'masterGrpFilter' => $req->input('masterGrpFilter'),
        ]);
    }

    public function showNewProducts(Request $req)
    {

        return redirect()->action('HomeController@index');


        $dt = Carbon::now();

        $products = Product::select('codice', 'descrizion', 'unmisura', 'gruppo', 'classe', 'listino1', 'listino6')
        ->whereIn('statoart', ['1', '8'])
            ->where('classe', 'NOT LIKE', 'DIC%')
            ->where('gruppo', 'NOT LIKE', 'DIC%')
            ->where('gruppo', 'NOT LIKE', '1%')
            ->where('gruppo', 'NOT LIKE', 'C%')
            ->where('gruppo', 'NOT LIKE', '2%')
            ->where('u_compl', '=', 1)
            ->where('codice', 'NOT LIKE', 'TKK%')
            ->where('codice', 'NOT LIKE', '#%')
            ->where('codice', 'NOT LIKE', 'CAMP%')
            ->where('u_perscli', 0)
            ->where('gruppo', '!=', '')
            ->where('u_datacrea', '>', Carbon::create($dt->year, 1, 1, 0))
            ->orderBy('gruppo');
        $products = $products->with('grpProd')->get();

        // $gruppi = SubGrpProd::where('codice', 'NOT LIKE', '1%')
        //     ->where('codice', 'NOT LIKE', 'DIC%')
        //     ->where('codice', 'NOT LIKE', '0%')
        //     ->where('codice', 'NOT LIKE', '2%')
        //     ->orderBy('codice')
        //     ->get();

        // $nazioni = Nazione::all();
        // $settori = Settore::all();
        // $zone = Zona::all();

        // dd($products);
        return view('prods.index', [
            'products' => $products,
            // 'gruppi' => $gruppi,
        ]);
    }

    public function showDetail(Request $req, $codArt)
    {

        return redirect()->action('HomeController@index');

        $product = Product::with(['grpProd', 'clasProd'])->findOrFail($codArt);
        // dd($product);
        return view('prods.detail', [
            'prod' => $product,
        ]);
    }
}
