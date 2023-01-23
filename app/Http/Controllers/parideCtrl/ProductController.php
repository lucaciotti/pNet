<?php

namespace App\Http\Controllers\parideCtrl;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\parideModels\GrpProd;
use App\Models\parideModels\Marche;
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
        $masterGrpFilter = ''; //$masterGrps->first()->id_fam;
        // ->whereRaw('left(id_fam,2) = ?', $masterGrpFilter)
        $gruppi = SubGrpProd::where('id_fam', '!=', '')->orderBy('id_fam')->get();
        $grpSelected = '';//$gruppi->first()->id_fam;

        $products = Product::select('id_art', 'descr', 'um', 'pz_x_conf', 'id_fam', 'id_cod_bar', 'id_cli_for','prezzo_1', 'non_attivo', 'nome_foto');
            // ->where('data_reg', '>', now()->subMonths(6))->orderBy('data_reg');
        $products = $products->with(['grpProd', 'supplier', 'magGiac', 'marche', 'skuCustomCode'])->orderBy('id_art', 'desc')->take(50)->get();

        $supplierList = Product::select('id_cli_for')->where('id_cli_for', 'like', 'F%')
            ->with('supplier')->groupBy('id_cli_for')->orderBy('id_cli_for')->get();

        $marcheList = Marche::all();

        return view('parideViews.prods.index', [
            'products' => $products,
            'masterGrps' => $masterGrps,
            'gruppi' => $gruppi,
            'grpSelected' => Arr::wrap($grpSelected),
            'masterGrpFilter' => Arr::wrap($masterGrpFilter),
            'suppliersList' => $supplierList,
            'supplierSelected' => Arr::wrap(''),
            'marcheList' => $marcheList,
            'marcheSelected' => Arr::wrap(''),
        ]);
    }

    public function fltIndex(Request $req)
    {
        $isFilter = false;
        $products = Product::select('id_art', 'descr', 'um', 'pz_x_conf', 'id_fam', 'id_cod_bar', 'id_cli_for','prezzo_1', 'non_attivo', 'nome_foto');

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
            $isFilter = true;
        }

        if ($req->input('descrArt')) {
            if ($req->input('descrArtOp') == 'eql') {
                $products = $products->where('descr', strtoupper($req->input('descrArt')));
            }
            if ($req->input('descrArtOp') == 'stw') {
                $products = $products->where('descr', 'LIKE', strtoupper($req->input('descrArt')) . '%');
            }
            if ($req->input('descrArtOp') == 'cnt') {
                $products = $products->where('descr', 'LIKE', '%' . strtoupper($req->input('descrArt')) . '%');
            }
            $isFilter = true;
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
            $isFilter = true;
        }

        if ($req->input('grpSelected')) {
            $products = $products->whereIn('id_fam', $req->input('grpSelected'));
            $isFilter = true;
        }

        if ($req->input('supplierSelected')) {
            $products = $products->whereIn('id_cli_for', $req->input('supplierSelected'));
            $isFilter = true;
        }

        if ($req->input('marcheSelected')) {
            $products = $products->whereIn('id_mar', $req->input('marcheSelected'));
            $isFilter = true;
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
        // dd($products->toSql());
        $products = $products->orderBy('id_art')
                        ->with('grpProd')
                        ->with('supplier')
                        ->with('magGiac');
        if(!$isFilter){
            $products = $products->take(50);    
        }
        $products = $products->get();

        $masterGrps = GrpProd::orderBy('id_fam')->get();
        // $gruppi = SubGrpProd::whereRaw('left(id_fam,2) IN ( ? )', $listGrp)->orderBy('id_fam')->get();
        $gruppi = SubGrpProd::orderBy('id_fam')->get();
        $supplierList = Product::select('id_cli_for')->where('id_cli_for', 'like', 'F%')
            ->with('supplier')->groupBy('id_cli_for')->orderBy('id_cli_for')->get();

        $marcheList = Marche::all();     

        return view('parideViews.prods.index', [
            'products' => $products,
            'masterGrps' => $masterGrps,
            'gruppi' => $gruppi,
            'codArt' => $req->input('codArt'),
            'descrArt' => $req->input('descrArt'),
            'barcode' => $req->input('barcode'),
            'grpSelected' => $req->input('grpSelected'),
            'masterGrpFilter' => $req->input('masterGrpFilter'),
            'suppliersList' => $supplierList,
            'supplierSelected' => $req->input('supplierSelected'),
            'marcheList' => $marcheList,
            'marcheSelected' => $req->input('marcheSelected'),
        ]);
    }

    public function searchProducts(Request $req, $searchStr)
    {
        return view('parideViews.prods.searchProducts', [
            'searchStr' => $searchStr
        ]);
    }

    public function detail(Request $req, $codArt)
    {
        $product = Product::with(
            [
                'masterGrpProd',
                'grpProd',
                'supplier', 
                'magGiac', 
                'marche', 
                'barcodes', 
                'supplierCodes',
                'tva'
            ]
        )->findOrFail($codArt);

        // $productsFam = Product::select('id_art', 'descr', 'um', 'pz_x_conf', 'id_fam', 'id_cod_bar', 'id_cli_for', 'prezzo_1', 'non_attivo');
        // $productsFam = $productsFam->where('id_fam', $product->id_fam);
        // $productsFam = $productsFam->with(['grpProd', 'supplier', 'magGiac', 'marche'])->orderBy('id_art', 'desc')->get();

        // $productsMarca = Product::select('id_art', 'descr', 'um', 'pz_x_conf', 'id_fam','id_mar', 'id_cod_bar', 'id_cli_for', 'prezzo_1', 'non_attivo');
        // $productsMarca = $productsMarca->where('id_mar', $product->id_mar);
        // $productsMarca = $productsMarca->with(['grpProd', 'supplier', 'magGiac', 'marche'])->orderBy('id_art', 'desc')->get();
        // dd($product);
        return view('parideViews.prods.detail', [
            'prod' => $product,
            // 'productsFam' => $productsFam,
            // 'productsMarca' => $productsMarca,
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
        $products = $products->with('grpProd')->with('grpProd')->get();

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
}
