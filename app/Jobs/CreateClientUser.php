<?php

namespace App\Jobs;

use App\Models\Role;
use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\parideModels\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
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
                        'password' => Hash::make($client->id_cli_for), /* Hash::make(str_random(32)) */
                        'codcli' => $client->id_cli_for,
                    ]);
                    $user->roles()->detach();
                    $user->attachRole(Role::where('name', 'client')->first()->id);
                    $user->ditta = 'it';
                    $user->isActive = true;
                    $user->save();                    
                }
            }
        }
        Log::info('ClientUser creation Job Ended');
        return;
    }
}
