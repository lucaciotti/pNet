<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Mail\InviteUser;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use App\Models\PrivacyUserAgree;
use App\Models\parideModels\Client;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CreateClientUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        Log::info('ClientUser creation Job Created');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('ClientUser creation Job Started');

        $clients = Client::all();

        foreach ($clients as $client) {
            if(filter_var($client->e_mail, FILTER_VALIDATE_EMAIL)){
                if(!User::where('codcli', $client->id_cli_for)->exists()){
                    try {
                        $user = User::create([
                            'name' => $client->rag_soc,
                            'nickname' => $client->id_cli_for.'@pNet.it',
                            'email' => $client->e_mail,
                            'password' => Hash::make(Str::random(32)),
                            'codcli' => $client->id_cli_for,
                        ]);
                    } catch (\Throwable $th) {
                        Log::error('Creazione Utente '.$client->rag_soc.' non riuscita!');
                    }
                    if($user) {
                        $user->roles()->detach();
                        $user->attachRole(Role::where('name', 'client')->first()->id);
                        $user->ditta = 'it';
                        $user->isActive = false;
                        $user->enable_ordweb = true;
                        $user->save();                              
                    }
                }

                //Procedura inivo invito Automatino && Creazione Privacy
                if($client->fat_email) {
                    if(User::where('codcli', $client->id_cli_for)->exists()) {
                        $user = User::with(['privacyAgreement'])->where('codcli', $client->id_cli_for)->first();
                        $clientDateStart = new Carbon($client->data_m);
                        $dateStartPrivacy = Carbon::createFromFormat('d/m/Y H:i:s',  '15/04/2022 00:00:00');
                        //CREAZIONE PRIVACY AGREEMENT
                        if (!$user->privacyAgreement) {
                            $privacyAgree = PrivacyUserAgree::create([
                                'user_id' => $user->id,
                                'name' => '',
                                'surname' => '',
                                'privacy_agreement' => false,
                                'marketing_agreement' => false
                            ]);
                        }
                        $privacyAgree = PrivacyUserAgree::where('user_id', $user->id)->first();
                        if($clientDateStart < $dateStartPrivacy){
                            //PER I CLIENTI ANTECEDENTI AL 15/04(2022 -> Privacy accettata di default
                            $privacyAgree->name = '-';
                            $privacyAgree->surname = '-';
                            $privacyAgree->privacy_agreement = true;
                            $privacyAgree->marketing_agreement = false;
                            $privacyAgree->save();
                        } else {
                            if($privacyAgree->created_at->diffInDays(Carbon::now()) > 14 && !$privacyAgree->privacy_agreement) {
                                //Dopo 14 giorni-> Privacy accettata di default
                                $privacyAgree = PrivacyUserAgree::where('user_id', $user->id)->first();
                                $privacyAgree->name = '-';
                                $privacyAgree->surname = '-';
                                $privacyAgree->privacy_agreement = true;
                                $privacyAgree->marketing_agreement = true;
                                $privacyAgree->save();
                            }
                        }
                        //INVIO INVITO EMAIL
                        if(!$user->invitato_email && !$user->isActive){
                            $token = Password::getRepository()->create($user);
                            $mail = (new InviteUser($token, $user->id))->onQueue('emails');
                            if (App::environment(['local', 'staging'])) {
                                Mail::to('pnet@lucaciotti.space')->bcc(['luca.ciotti@gmail.com'])->queue($mail);
                            } else {
                                Mail::to($user->email)->bcc(['alexschiavon90@gmail.com', 'luca.ciotti@gmail.com'])->queue($mail);
                            }
                            Log::info('ClientUser sended auto invitation to:'. $client->id_cli_for.'-'. $client->rag_soc . '-' . $client->email);
                        }
                    }
                }
            } else {         
                $html = '<h1>Attenzione</h1><br>Cliente --> <b>'.$client->id_cli_for.' - '.$client->rag_soc.'</b> con email non valida <b>"'.$client->email.'"</b>';
                if (App::environment(['local', 'staging'])) {
                    Mail::send([], [], function (Message $message) use ($html) {
                        $message
                        ->to('pnet@lucaciotti.space')
                        ->bcc(['luca.ciotti@gmail.com'])
                        ->subject('ClientUser creation Job')
                        ->setBody($html, 'text/html');
                    });
                } else {
                    Mail::send([], [], function (Message $message) use ($html) {
                        $message
                        ->to('amministrazione@ferramentaparide.it')
                        ->bcc(['alexschiavon90@gmail.com', 'luca.ciotti@gmail.com'])
                        ->subject('ClientUser creation Job')
                        ->setBody($html, 'text/html');
                    });
                }
            }
        }
        Log::info('ClientUser creation Job Ended');
        return;
    }
}
