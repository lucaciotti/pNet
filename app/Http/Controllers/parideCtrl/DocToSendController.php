<?php

namespace App\Http\Controllers\parideCtrl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\parideModels\Docs\wDocSent;
use App\Jobs\emails\SendOneDocListedByEmail;

class DocToSendController extends Controller
{
    public function index(Request $req){
        $docListed = wDocSent::where('created_at', '>', now()->subDays(4))->with(['ddt', 'client'])->where('tipo_doc','BO')->get();

        return view('parideViews.docsToSend.index', [
            'docListed' => $docListed,
        ]);
    }

    public function sendDdt(Request $req, $id)
    {
        SendOneDocListedByEmail::dispatch($id)->onQueue('emails');

        return redirect()->back();
    }
}
