<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use App\Jobs\emails\SendDocListByEmail;
use App\Models\parideModels\Docs\FTCli;
use App\Models\parideModels\Docs\DDTCli;
use App\Models\parideModels\Docs\FDCli;
use App\Models\parideModels\Docs\FPCli;
use App\Models\parideModels\Docs\NCCli;
use App\Models\parideModels\Docs\OrdCli;
use App\Models\parideModels\Docs\QuoteCli;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\parideModels\Docs\wDocSent;
use App\Models\parideModels\Docs\wOrdSent;
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

        $XCList = QuoteCli::where('data', '>', now()->subDays(2))
            ->doesntHave('docSent')
            ->whereHas('client', function ($q) {
                $q->where('fat_email', '1');
            })->get();
        foreach ($XCList as $doc) {
            wOrdSent::create([
                'id_doc' => $doc->id_ord_tes,
                'tipo_doc' => $doc->tipodoc,
                'id_cli' => $doc->id_cli_for,
            ]);
        }
        Log::info('FetchDocToSendByEmail Quotes Ended');

        $OCList = OrdCli::where('data', '>', now()->subDays(2))
            ->doesntHave('docSent')
            ->whereHas('client', function ($q) {
                $q->where('fat_email', '1');
            })->get();
        foreach (
        $OCList as $doc) {
            wOrdSent::create([
                'id_doc' => $doc->id_ord_tes,
                'tipo_doc' => $doc->tipodoc,
                'id_cli' => $doc->id_cli_for,
            ]);
        }
        Log::info('FetchDocToSendByEmail OC Ended');
        
        $ddtList = DDTCli::where('data', '>', now()->subDays(2))
            ->doesntHave('docSent')
            ->whereHas('client', function($q){
                $q->where('fat_email', '1');
            })->get();
        foreach ($ddtList as $ddt) {
            wDocSent::create([
                'id_doc' => $ddt->id_doc_tes,
                'tipo_doc' => $ddt->tipodoc,
                'id_cli' => $ddt->id_cli_for,
            ]);
        }
        Log::info('FetchDocToSendByEmail DDT Ended');

        $ftList = FTCli::where('data', '>', now()->subDays(30))
            ->doesntHave('docSent')
            ->whereHas('client', function ($q) {
                $q->where('fat_email', '1');
            })->get();
        foreach ($ftList as $ft) {
            wDocSent::create([
                'id_doc' => $ft->id_doc_tes,
                'tipo_doc' => $ft->tipodoc,
                'id_cli' => $ft->id_cli_for,
            ]);
        }
        Log::info('FetchDocToSendByEmail FT Ended');

        $FDList = FDCli::where('data', '>', now()->subDays(30))
            ->doesntHave('docSent')
            ->whereHas('client', function ($q) {
                $q->where('fat_email', '1');
            })->get();
        foreach ($FDList as $doc) {
            wDocSent::create([
                'id_doc' => $doc->id_doc_tes,
                'tipo_doc' => $doc->tipodoc,
                'id_cli' => $doc->id_cli_for,
            ]);
        }
        Log::info('FetchDocToSendByEmail FD Ended');

        $FPList = FPCli::where('data', '>', now()->subDays(30))
            ->doesntHave('docSent')
            ->whereHas('client', function ($q) {
                $q->where('fat_email', '1');
            })->get();
        foreach ($FPList as $doc) {
            wOrdSent::create([
                'id_doc' => $doc->id_ord_tes,
                'tipo_doc' => $doc->tipodoc,
                'id_cli' => $doc->id_cli_for,
            ]);
        }
        Log::info('FetchDocToSendByEmail FP Ended');

        $NCCli = NCCli::where('data', '>', now()->subDays(30))
            ->doesntHave('docSent')
            ->whereHas('client', function ($q) {
                $q->where('fat_email', '1');
            })->get();
        foreach ($NCCli as $doc) {
            wDocSent::create([
                'id_doc' => $doc->id_doc_tes,
                'tipo_doc' => $doc->tipodoc,
                'id_cli' => $doc->id_cli_for,
            ]);
        }
        Log::info('FetchDocToSendByEmail NC Ended');

        SendDocListByEmail::dispatch()->onQueue('emails');
        Log::info('FetchDocToSendByEmail Job Ended');
    }
}
