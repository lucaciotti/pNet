<?php

namespace App\Http\Controllers\sysCtrl;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrivacyPolicyController extends Controller
{
    public function index(Request $req)
    {
        return view('sysViews.privacyPolicy.index');
    }

    public function update(Request $req)
    {
        dd($req);
        return view('sysViews.privacyPolicy.index');
    }

    public function downloadPDF (Request $req) {
        //PDF file is stored under project/public/download/info.pdf
        $file = public_path() . "/download/privacy/Privacy_Policy_Schiavon_Paride_Ferramenta_20210317.pdf";

        $headers = [
            'Content-Type' => 'application/pdf',
        ];
        // dd($file);
        return response()->download($file, 'Privacy_Policy_Schiavon_Paride_Ferramenta_20210317.pdf', $headers);
    }
}
