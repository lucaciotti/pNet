<?php

namespace App\Http\Controllers\parideCtrl;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\parideModels\Docs\wDocSent;
use App\Jobs\emails\SendOneDocListedByEmail;

class DocToSendController extends Controller
{
    public function index(Request $req){

        $startDate = Carbon::now()->subDays(4);
        $endDate = Carbon::now();
        $docListed = wDocSent::whereBetween('created_at', [$startDate, $endDate])->with(['ddt', 'client'])->where('tipo_doc','BO')->get();

        return view('parideViews.docsToSend.index', [
            'docListed' => $docListed,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'noDate' => false,
        ]);
    }

    public function fltIndex(Request $req)
    {
        if ($req->input('startDate')) {
            $startDate = Carbon::createFromFormat('d/m/Y', $req->input('startDate'));
            $endDate = Carbon::createFromFormat('d/m/Y', $req->input('endDate'));
        } else {
            $startDate = Carbon::now()->subDays(4);
            $endDate = Carbon::now();
        }
        $noDate = $req->input('noDate');
        
        $docListed = wDocSent::where('tipo_doc', 'BO');
        if (!$noDate) {
            $docListed = $docListed->whereBetween('created_at', [$startDate, $endDate]);
        }
        $docListed = $docListed->with(['ddt', 'client'])->get();

        return view('parideViews.docsToSend.index', [
            'docListed' => $docListed,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'noDate' => $noDate,
        ]);
    }

    public function sendDdt(Request $req, $id)
    {
        SendOneDocListedByEmail::dispatch($id)->onQueue('emails');

        return redirect()->back();
    }
}
