<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use App\Jobs\emails\SendDocListByEmail;
use App\Models\parideModels\Docs\FTCli;
use App\Models\parideModels\Docs\DDTCli;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\parideModels\Docs\wDocSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class FetchDocToSendByEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        Log::info('FetchDocToSendByEmail Job Created');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('FetchDocToSendByEmail Job Started');
        $thisMonth = new Carbon('first day of this month');
        
        $ddtList = DDTCli::where('data', '>=', $thisMonth->subDays(1))
            ->doesntHave('docSent')
            ->whereHas('client', function($q){
                $q->where('fat_email');
            })->get();
        foreach ($ddtList as $ddt) {
            wDocSent::create([
                'id_doc' => $ddt->id_doc_tes,
                'tipo_doc' => $ddt->tipodoc,
                'id_cli' => $ddt->id_cli_for,
            ]);
        }

        $ftList = FTCli::where('data', '>=', $thisMonth->subDays(1))
            ->doesntHave('docSent')
            ->whereHas('client', function ($q) {
                $q->where('fat_email');
            })->get();
        foreach ($ftList as $ft) {
            wDocSent::create([
                'id_doc' => $ft->id_doc_tes,
                'tipo_doc' => $ft->tipodoc,
                'id_cli' => $ft->id_cli_for,
            ]);
        }

        SendDocListByEmail::dispatch()->onQueue('emails');
        Log::info('FetchDocToSendByEmail Job Ended');
    }
}
