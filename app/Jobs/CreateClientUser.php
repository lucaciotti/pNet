<?php

namespace App\Jobs;

use App\Models\Role;
use App\Models\User;
use App\Mail\InviteUser;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
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
                    $user = User::create([
                        'name' => $client->rag_soc,
                        'nickname' => $client->id_cli_for.'@pNet.it',
                        'email' => $client->e_mail,
                        'password' => Hash::make(Str::random(32)),
                        'codcli' => $client->id_cli_for,
                    ]);
                    $user->roles()->detach();
                    $user->attachRole(Role::where('name', 'client')->first()->id);
                    $user->ditta = 'it';
                    $user->isActive = false;
                    $user->save();                              
                }
                //ora se cliente è configurato per invito automatico, inivo invito
                if($client->fat_email){
                    if(User::where('codcli', $client->id_cli_for)->exists()){
                        $user = User::where('codcli', $client->id_cli_for)->first();
                        if(!$user->invitato_email && !$user->isActive){
                            $token = Password::getRepository()->create($user);
                            $mail = (new InviteUser($token, $user->id))->onQueue('emails');
                            if (App::environment(['local', 'staging'])) {
                                Mail::to('pnet@lucaciotti.space')->cc(['luca.ciotti@gmail.com'])->queue($mail);
                            } else {
                                Mail::to('pnet@lucaciotti.space')->cc(['alexschiavon90@gmail.com', 'luca.ciotti@gmail.com'])->queue($mail);
                            }
                            Log::info('ClientUser sended auto invitation to:'. $client->id_cli_for.'-'. $client->rag_soc);
                        }
                    }
                }
            }
        }
        Log::info('ClientUser creation Job Ended');
        return;
    }
}
