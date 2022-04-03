<?php

namespace App\Http\Controllers\sysCtrl;

use RedisUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PrivacyUserAgree;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Mail\PrivacyUserAgreement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PrivacyPolicyController extends Controller
{
    public function index(Request $req, $user_id)
    {
        if(RedisUser::get('role')=='client'){
            $user_id = Auth::user()->id;
        }
        $showTerms = false;
        $user = User::with(['roles', 'client', 'privacyAgreement'])->findOrFail($user_id);
        if(!$user->privacyAgreement){
            $showTerms = true;
        } else {
            if(!$user->privacyAgreement->privacy_agreement) $showTerms = true;
        }
        // dd($user);
        return view('sysViews.privacyPolicy.index', [
            'user' => $user,
            'user_id' => $user_id,
            'showTerms' => $showTerms,
        ]);
    }

    public function update(Request $req)
    {
        $user_id = $req->user_id;
        if (RedisUser::get('role') == 'client') {
            $user_id = Auth::user()->id;
        }
        if (!PrivacyUserAgree::where('user_id', $user_id)->exists()) {
            $privacyAgree = PrivacyUserAgree::create([
                'user_id' => $user_id,
                'name' => $req->name,
                'surname' => $req->surname,
                'privacy_agreement' => $req->checkDatiPers=='on' ? true : false,
                'marketing_agreement' => $req->checkNewsLetter==1 ? true : false
            ]);
            // $privacyAgree->save();
        } else {
            $privacyAgree = PrivacyUserAgree::where('user_id', $user_id)->first();
            $privacyAgree->name = $req->name;
            $privacyAgree->surname = $req->surname;
            if (RedisUser::get('role') == 'client' && $privacyAgree->privacy_agreement==true) {
                //il cliente non può scegliere in autonomia di togliere il consenso una volta che lo ha concesso
                $privacyAgree->privacy_agreement = $privacyAgree->privacy_agreement;
            } else {
                $privacyAgree->privacy_agreement = $req->checkDatiPers == 'on' ? true : false;
            }
            $privacyAgree->marketing_agreement = $req->checkNewsLetter == 1 ? true : false;
            $privacyAgree->save();
        }

        if($user_id == Auth::user()->id){
            $user = User::findOrFail($user_id);
            try {
                if (App::environment(['local', 'staging'])) {
                    Mail::to('pnet@lucaciotti.space')->cc(['luca.ciotti@gmail.com'])->send(new PrivacyUserAgreement($user->id));
                } else {
                    Mail::to($user->email)->bcc(['alexschiavon90@gmail.com', 'luca.ciotti@gmail.com'])->send(new PrivacyUserAgreement($user->id));
                }
            } catch (\Exception $e) {
                Log::error("Send Privacy Agreement error: " . $e->getMessage());
                $req->session()->flash('status', 'Errore imprevisto per favore riprovare!');
            }
        }

        $showTerms = false;
        $user = User::with(['roles', 'client', 'privacyAgreement'])->findOrFail($user_id);
        if (!$user->privacyAgreement) {
            $showTerms = true;
        } else {
            if (!$user->privacyAgreement->privacy_agreement) $showTerms = true;
        }

        return view('sysViews.privacyPolicy.index', [
            'user' => $user,
            'user_id' => $user_id,
            'showTerms' => $showTerms,
        ]);
    }

    public function listAgreement(Request $req) {
        $privacyAgree = PrivacyUserAgree::whereHas('user', function ($query) {
                            $query->where('codcli', '!=', '');
                        })->with(['user' => function ($query) {
                            $query->with(['client' => function ($q) {
                                return $q->select('id_cli_for', 'rag_soc');
                            }]);
                        }])->orderBy('id')->get();
        // dd($privacyAgree->last());
        return view('sysViews.privacyPolicy.listAgreement', [
            'privacyAgree' => $privacyAgree,
        ]);
    }

    public function downloadPDF (Request $req) {
        //PDF file is stored under project/public/download/info.pdf
        $file = public_path() . "/download/privacy/Privacy_Policy_Schiavon_Paride_Ferramenta_V02.pdf";

        $headers = [
            'Content-Type' => 'application/pdf',
        ];
        // dd($file);
        return response()->download($file, 'Privacy_Policy_Schiavon_Paride_Ferramenta_V02.pdf', $headers);
    }

    public function exportCsv(Request $req)
    {
        $fileName = 'users_privacy_agreement.csv';
        $privacyAgree = PrivacyUserAgree::whereHas('user', function ($query) { $query->where('codcli', '!=', ''); })
                        ->with(['user' => function ($query) {
                            $query->with(['client' => function ($q) {
                                return $q->select('id_cli_for', 'rag_soc');
                            }]);
                        }])->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('user_id', 'user_name', 'id_cli_for', 'rag_soc', 'name', 'surname', 'privacy_agreement', 'marketing_agreement', 'date_agreement');

        $callback = function () use ($privacyAgree, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';');

            foreach ($privacyAgree as $userAgree) {
                $row['user_id']  = $userAgree->user->id;
                $row['user_name']  = $userAgree->user->name;
                $row['id_cli_for'] = ($userAgree->user->client ? $userAgree->user->client->id_cli_for : '' );
                $row['rag_soc'] = ($userAgree->user->client ? $userAgree->user->client->rag_soc : '' );

                $row['name']  = $userAgree->name;
                $row['surname']  = $userAgree->surname;
                $row['privacy_agreement']  = $userAgree->privacy_agreement;
                $row['marketing_agreement']  = $userAgree->marketing_agreement;
                $row['date_agreement']  = $userAgree->updated_at->format('d-m-Y');

                fputcsv(
                    $file, 
                    array(
                        $row['user_id'], 
                        $row['user_name'], 
                        $row['id_cli_for'], 
                        $row['rag_soc'], 
                        $row['name'],
                        $row['surname'],
                        $row['privacy_agreement'],
                        $row['marketing_agreement'],
                        $row['date_agreement'],
                    ),
                    ';'
                );
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function sendMailPrivacyAgreement(Request $req, $id){
        $user = User::findOrFail($id);
        try {
            if (App::environment(['local', 'staging'])) {
                Mail::to('pnet@lucaciotti.space')->cc(['luca.ciotti@gmail.com'])->send(new PrivacyUserAgreement($user->id));
            } else {
                Mail::to($user->email)->bcc(['alexschiavon90@gmail.com', 'luca.ciotti@gmail.com'])->send(new PrivacyUserAgreement($user->id));
            }
        } catch (\Exception $e) {
            Log::error("Send Privacy Agreement error: " . $e->getMessage());
            $req->session()->flash('status', 'Errore imprevisto per favore riprovare!');
        }
        return redirect()->back();
    }
}
