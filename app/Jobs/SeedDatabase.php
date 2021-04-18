<?php

namespace App\Jobs;

use ZipArchive;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Artisan;

class SeedDatabase implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $pathFile;
    public $timeout = 300;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $pathFile)
    {
        $this->pathFile = $pathFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //prima i tutto cancello tutti i file nella directory database/json
        foreach (Storage::files('DbSeed/JsonFiles') as $file) {
            Storage::delete($file);
        }
        $zip = new ZipArchive;
        if ($zip->open('storage/app/'.$this->pathFile) === TRUE) {
            $zip->extractTo('storage/app/DbSeed/JsonFiles');
            $zip->close();

            $output = '';
            Artisan::call('db:seed', array('--database' => 'pNet_DATA'), $output);
            $output .= Artisan::output();

            Storage::put('DbSeed/Logs/'. now()->format('Y-m-d-H-i-s').'.log', $output);
        } else {
            $this->fail();
            echo 'failed-'.$this->pathFile;
        }
    }
}
