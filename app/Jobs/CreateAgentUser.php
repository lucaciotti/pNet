<?php

namespace App\Jobs;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use App\Models\parideModels\Agent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CreateAgentUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        Log::info('AgentUser creation Job Created');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('AgentUser creation Job Started');

        $agents = Agent::all();

        foreach ($agents as $agent) {
            if (filter_var($agent->emaila, FILTER_VALIDATE_EMAIL)) {
                if (!User::where('codag', $agent->id_agente)->exists()) {
                    $user = User::create([
                        'name' => $agent->nome,
                        'nickname' => $agent->emaila,
                        'email' => $agent->emaila,
                        'password' => Hash::make(Str::random(32)),
                        'codag' => $agent->id_agente,
                    ]);
                    $user->roles()->detach();
                    $user->attachRole(Role::where('name', 'agent')->first()->id);
                    $user->ditta = 'it';
                    $user->isActive = false;
                    $user->save();
                }
            }
        }
        Log::info('AgentUser creation Job Ended');
        return;
    }
}
