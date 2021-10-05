<?php

namespace App\Http\Controllers\parideCtrl;

use Carbon\Carbon;
use App\Helpers\RedisUser;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\parideModels\Client;
use App\Models\parideModels\Marche;
use App\Http\Controllers\Controller;
use App\Models\parideModels\Product;
use App\Models\parideModels\Docs\FTCli;
use App\Models\parideModels\SubGrpProd;
use App\Models\parideModels\Docs\DDTCli;
use App\Models\parideModels\Docs\RowDoc;

class StatAbcProdController extends Controller
{
    public function index(Request $req)
    {
        // FILTRI-Ricerca
        $startDate = (now()->subMonths(2))->toDateString();
        $endDate = (now())->toDateString();

        $optParams = array(
            "client" => Arr::wrap(null),
            "grpSelected" => Arr::wrap(null),
            "marcheSelected" => Arr::wrap(null),
            "supplierSelected" => Arr::wrap(null),
        );
        $abcProds = $this->searchAbcProd($startDate, $endDate, $optParams);

        //Parametri per filtri Utente
        $fltClients = (Client::select('id_cli_for', 'rag_soc')->where('bloccato', 0)->get())->sortBy('rag_soc');
        $gruppi = SubGrpProd::where('id_fam', '!=', '')->orderBy('id_fam')->get();
        $marcheList = Marche::all();
        $supplierList = Product::select('id_cli_for')->where('id_cli_for', 'like', 'F%')
        ->with('supplier')->groupBy('id_cli_for')->orderBy('id_cli_for')->get();

        return view('parideViews.stats.abcprods.index', [
            'abcProds' => $abcProds,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'gruppi' => $gruppi,
            'grpSelected' => Arr::wrap(''),
            'suppliersList' => $supplierList,
            'supplierSelected' => Arr::wrap(''),
            'marcheList' => $marcheList,
            'marcheSelected' => Arr::wrap(''),
            'fltClients' => $fltClients,
            'client' => Arr::wrap(''),
        ]);
    }

    public function fltIndex(Request $req)
    {
        if ($req->input('startDate')) {
            $startDate = (Carbon::createFromFormat('d/m/Y', $req->input('startDate')))->toDateString();
            $endDate = (Carbon::createFromFormat('d/m/Y', $req->input('endDate')))->toDateString();
        } else {
            $startDate = (now()->subMonths(2))->toDateString();
            $endDate = (now())->toDateString();
        }
        $optParams = array(
            "client" => $req->input('client'),
            "grpSelected" => $req->input('grpSelected'),
            "marcheSelected" => $req->input('marcheSelected'),
            "supplierSelected" => $req->input('supplierSelected'),
        );
        $abcProds = $this->searchAbcProd($startDate, $endDate, $optParams);

        //Parametri per filtri Utente
        $fltClients = (Client::select('id_cli_for', 'rag_soc')->where('bloccato', 0)->get())->sortBy('rag_soc');
        $gruppi = SubGrpProd::where('id_fam', '!=', '')->orderBy('id_fam')->get();
        $marcheList = Marche::all();
        $supplierList = Product::select('id_cli_for')->where('id_cli_for', 'like', 'F%')
        ->with('supplier')->groupBy('id_cli_for')->orderBy('id_cli_for')->get();

        return view('parideViews.stats.abcprods.index', [
            'abcProds' => $abcProds,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'gruppi' => $gruppi,
            'grpSelected' => $req->input('grpSelected'),
            'suppliersList' => $supplierList,
            'supplierSelected' => $req->input('supplierSelected'),
            'marcheList' => $marcheList,
            'marcheSelected' => $req->input('marcheSelected'),
            'fltClients' => $fltClients,
            'client' => $req->input('client'),
        ]);
    }

    public function fromArtToDocs(Request $req){
        if ($req->input('startDate')) {
            $startDate = (Carbon::createFromFormat('d/m/Y', $req->input('startDate')))->toDateString();
            $endDate = (Carbon::createFromFormat('d/m/Y', $req->input('endDate')))->toDateString();
        } else {
            $startDate = (now()->subMonths(2))->toDateString();
            $endDate = (now())->toDateString();
        }
        $client = unserialize(base64_decode($req->input('client')));
        $optParams = array(
            "client" => !empty($client[0]) ? $client : Arr::wrap(null),
        );
        $idArt = $req->input('idArt');
        $descrArt = Product::select('descr')->find($idArt)->descr;

        $reverseAbcProd = $this->reverseAbcProd($idArt, $startDate, $endDate, $optParams);

        // dd($reverseAbcProd);

        return view('parideViews.stats.abcprods.fromArtToDocs', [
            'docs' => $reverseAbcProd,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'idArt' => $idArt,
            'client' => unserialize(base64_decode($req->input('client'))),
            'descrArt' => $descrArt
        ]);
    }



    // PRIVATE FUNCTIONS
    // ------------------
    private function searchAbcProd($startDate, $endDate, $optParams=null){
        $client = isset($optParams["client"]) ? $optParams["client"] : Arr::wrap(null);
        $grpSelected = isset($optParams["grpSelected"]) ? $optParams["grpSelected"] : Arr::wrap(null);
        $marcheSelected = isset($optParams["marcheSelected"]) ? $optParams["marcheSelected"] : Arr::wrap(null);
        $supplierSelected = isset($optParams["supplierSelected"]) ? $optParams["supplierSelected"] : Arr::wrap(null);

        $ddts = DDTCli::select('id_doc_tes')->whereBetween('data', [$startDate, $endDate]);
        if (!empty($client) && RedisUser::get('role') != 'client') {
            $ddts->whereIn('id_cli_for', $client);
        }
        $ddts=$ddts->get();
        $invoices = FTCli::select('id_doc_tes')->whereBetween('data', [$startDate, $endDate]);
        if (!empty($client) && RedisUser::get('role') != 'client') {
            $invoices->whereIn('id_cli_for', $client);
        }
        $invoices = $invoices->get();
        $docsID = ($ddts->merge($invoices))->pluck('id_doc_tes')->toArray();
        
        $rowsProds = RowDoc::select('id_art', DB::raw("sum(qta) as qta"), DB::raw("sum(val_riga) as val"))
                        ->whereIn('id_doc_tes', $docsID)
                        ->where('id_art', '!=', '')
                        ->where('id_art', '!=', 34199)
                        ->where('id_art', '!=', 0);
        if (!empty($grpSelected)) {
            $rowsProds->whereHas('product', function ($q) use ($grpSelected) {
                $q->whereIn('id_fam', $grpSelected);
            });
        }
        if (!empty($marcheSelected)) {
            $rowsProds->whereHas('product', function ($q) use ($marcheSelected) {
                $q->whereIn('id_mar', $marcheSelected);
            });
        }
        if (!empty($supplierSelected)) {
            $rowsProds->whereHas('product', function ($q) use ($supplierSelected) {
                $q->whereIn('id_cli_for', $supplierSelected);
            });
        }
        $rowsProds->with('product', function($query){
                return $query->select('id_art', 'descr', 'um', 'pz_x_conf', 'id_fam', 'id_cod_bar', 'id_cli_for', 'prezzo_1', 'non_attivo', 'nome_foto');
            })
            ->groupBy('id_art')
            ->orderBy('qta', 'desc');

        if(empty($client) && RedisUser::get('role')!='client'){
            $rowsProds->limit(150);
        }
        $rowsProds = $rowsProds->get();
        // dd($rowsProds->first());

        return $rowsProds;
    }

    private function reverseAbcProd($idArt, $startDate, $endDate, $optParams=null){
        $client = isset($optParams["client"]) ? $optParams["client"] : Arr::wrap(null);

        $ddts = DDTCli::select('id_doc_tes', 'num', 'data', 'id_cli_for')->whereBetween('data', [$startDate, $endDate]);
        if (!empty($client) && RedisUser::get('role') != 'client') {
            // dd(empty($client));
            $ddts->whereIn('id_cli_for', $client);
        }
        $ddts->whereHas('rows', function ($q) use ($idArt) {
            $q->where('id_art', $idArt);
        });
        $ddts->with('rows', function ($query) use ($idArt) {
            return $query->select('id_doc_tes', 'id_art', 'prezzo', 'um', 'sc1', 'sc2', 'qta', 'val_riga')
                ->where('id_art', $idArt)
                ->with('product', function ($query) {
                    return $query->select('id_art', 'descr', 'um', 'pz_x_conf', 'id_fam', 'id_cod_bar', 'id_cli_for', 'prezzo_1', 'non_attivo', 'nome_foto');
                });
        });
        $ddts->with('client', function ($query) {
            return $query->select('id_cli_for', 'rag_soc');
        });
        $ddts = $ddts->get();
        
        $invoices = FTCli::select('id_doc_tes')->whereBetween('data', [$startDate, $endDate]);
        if (!empty($client) && RedisUser::get('role') != 'client') {
            $invoices->whereIn('id_cli_for', $client);
        }
        $invoices->whereHas('rows', function ($q) use ($idArt) {
            $q->where('id_art', $idArt);
        });
        $invoices->with('rows', function ($query) use ($idArt) {
            return $query->select('id_doc_tes', 'id_art', 'qta', 'val_riga')
                ->where('id_art', $idArt)
                ->with('product', function ($query) {
                    return $query->select('id_art', 'descr', 'um', 'pz_x_conf', 'id_fam', 'id_cod_bar', 'id_cli_for', 'prezzo_1', 'non_attivo', 'nome_foto');
                });
        });
        $invoices->with('client', function ($query) {
            return $query->select('id_cli_for', 'rag_soc');
        });
        $invoices = $invoices->get();
        
        $docs = ($ddts->merge($invoices))->sortBy('data');
        
        return $docs;        
    }
}
