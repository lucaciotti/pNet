<?php

namespace App\Jobs\Sys;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class DeleteOlderZip implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        Log::info('Delete OlderZipSeed Job Created');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $oldFiles = Storage::listContents('DbSeed/ZipFiles', true);
        if (!empty($oldFiles)) {
            foreach ($oldFiles as $file) {
                if ($file['timestamp'] < now()->subDays(2)->getTimestamp()) {
                    Log::info('Delete OlderZipSeed Job Created: '+$file['filename']);                
                    Storage::delete($file['path']);
                }
            }
        }
    }
}
