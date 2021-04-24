<?php

namespace App\Jobs;

use ZipArchive;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SeedDatabase implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $pathFile;
    protected string $jsonFilesPath;
    protected string $logFilesPath;
    public $timeout = 300;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $pathFile)
    {
        $this->pathFile = Storage::path($pathFile);
        $this->jsonFilesPath = Storage::path('DbSeed/JsonFiles');
        $this->logFilesPath = Storage::path('DbSeed/Logs');
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
        try {
            if ($zip->open($this->pathFile) === TRUE) {
                $zip->extractTo($this->jsonFilesPath);
                $zip->close();

                $output = '';
                Artisan::call('db:seed', array('--database' => 'pNet_DATA', '--force' => true), $output);
                $output .= Artisan::output();

                $filename = now()->format('Y-m-d-H-i-s') . '.log';
                Storage::put('DbSeed/Logs/' . $filename, $output);

                Mail::raw('Attached the Database Log!', function ($message) use ($filename) {
                    $message->to('luca.ciotti@gmail.com')
                    ->subject('Log Database')
                    ->attach($this->logFilesPath . $filename);
                });
            } else {
                $this->fail();
                Log::error('failed-job: ' . $this->pathFile);
                $filename = $this->pathFile;
                Mail::raw('FAIL! Log Database!', function ($message) {
                    $message->to('luca.ciotti@gmail.com')
                    ->subject('FAIL! Log Database');
                });
            }
        } catch ( \Exception $e) {
            $this->fail();
            Log::error('failed-job: ' . $this->pathFile);
            Log::error($e->getMessage());
            Mail::raw($e->getMessage(), function ($message) {
                $message->to('luca.ciotti@gmail.com')
                ->subject('FAIL! Log Database');
            });
        }
    }
}
