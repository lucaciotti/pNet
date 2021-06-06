<?php

namespace App\Http\Controllers\parideCtrl;

use Mapper;
use App\Helpers\RedisUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\parideModels\Client;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $req)
    {

        if (RedisUser::get('role') == 'client') {
            return redirect()->action([ClientController::class, 'detail'], RedisUser::get('codcli'));
        }
        // on($this->connection)->
        $clients = Client::select('id_cli_for', 'rag_soc', 'citta', 'provincia', 'p_i')->where('bloccato', 0)->get();

        // $nazioni = DB::table('cli_for')->distinct()->get();
        // $settori = Settore::all();
        $zone = DB::connection('pNet_DATA')->table('cli_for')->select('provincia')->distinct('provincia')->get();

        // $clients = $clients->paginate(25);
        // dd($zone);
        // Session::forget('_old_input');
        return view('parideViews.client.index', [
            'clients' => $clients,
            'fltClients' => $clients->sortBy('rag_soc'),
            // 'nazioni' => $nazioni,
            // 'settori' => $settori,
            'zone' => $zone,
            'mapsException' => ''
        ]);
    }

    public function fltIndex(Request $req)
    {
        // dd($req);
        $clients = Client::select('*');
        if ($req->input('ragsoc')) {
            $clients = $clients->whereIn('id_cli_for', $req->input('ragsoc'));
        }
        if ($req->input('partiva')) {
            if ($req->input('partivaOp') == 'eql') {
                $clients = $clients->where('p_i', strtoupper($req->input('partiva')));
            }
            if ($req->input('partivaOp') == 'stw') {
                $clients = $clients->where('p_i', 'LIKE', strtoupper($req->input('partiva')) . '%');
            }
            if ($req->input('partivaOp') == 'cnt') {
                $clients = $clients->where('p_i', 'LIKE', '%' . strtoupper($req->input('partiva')) . '%');
            }
        }
        if ($req->input('codcli')) {
            if ($req->input('codcliOp') == 'eql') {
                $clients = $clients->where('id_cli_for', strtoupper($req->input('codcli')));
            }
            if ($req->input('codcliOp') == 'stw') {
                $clients = $clients->where('id_cli_for', 'LIKE', strtoupper($req->input('codcli')) . '%');
            }
            if ($req->input('codcliOp') == 'cnt') {
                $clients = $clients->where('id_cli_for', 'LIKE', '%' . strtoupper($req->input('codcli')) . '%');
            }
        }
        if ($req->input('zona')) {
            $clients = $clients->whereIn('provincia', $req->input('zona'));
        }
        $clients = $clients->get();
        // dd($clients);
        $zone = DB::connection('pNet_DATA')->table('cli_for')->select('provincia')->distinct('provincia')->get();

        $req->flash();

        return view('parideViews.client.index', [
            'clients' => $clients,
            'fltClients' => $clients, //Client::select('codice', 'descrizion')->orderBy('descrizion')->get(),
            // 'nazioni' => $nazioni,
            // 'settori' => $settori,
            'zone' => $zone,
        ]);
    }

    public function detail(Request $req, $codCli)
    {
        $client = Client::findOrFail($codCli);
        // $scadToPay = ScadCli::where('codcf', $codCli)->where('pagato', 0)->whereIn('tipoacc', ['F', ''])->orderBy('datascad', 'desc')->get();
        $address = $client->indirizzo . ", " . $client->citta . ", " . $client-> provincia . ", IT";
        $expt = '';
        try {
            Mapper::location($address)
                ->map([
                    'zoom' => 14,
                    'center' => true,
                    'markers' => [
                        'title' => $client->descrizion,
                        'animation' => 'DROP'
                    ],
                    'eventAfterLoad' => 'onMapLoad(maps[0].map);'
                ]);
        } catch (\Exception $e) {
            $expt = $e->getMessage();
        }
        // $visits = wVisit::where('codicecf', $codCli)->with('user')->take(3)->orderBy('data', 'desc')->orderBy('id')->get();
        // dd($visits->isEmpty());
        // dd($client);
        return view('parideViews.client.detail', [
            'client' => $client,
            // 'scads' => $scadToPay,
            'mapsException' => $expt,
            // 'visits' => $visits,
            'dateNow' => now(),
        ]);
    }
}
