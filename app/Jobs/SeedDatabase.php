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
    public $timeout = 3600;
    public $tries = 5;

    public function __construct(string $pathFile)
    {
        // Log::info("Path:");
        $this->pathFile = Storage::path($pathFile);
        Log::info('Seeding Job Created: '.$this->pathFile);
        $this->jsonFilesPath = Storage::path('DbSeed/JsonFiles');
        // Log::info($this->jsonFilesPath);
        $this->logFilesPath = Storage::path('DbSeed/Logs');
        // Log::info($this->logFilesPath);
    }

    public function handle()
    {
        //Estraggo i nuovi file nella directory JsonTmp
        $this->unZipJsonFiles();

        //ESEGUO PROCEDURA IN FASI DIVERSE PER SEEDING
        //Fase 1 - Sposto File articoli se esiste
        $filename1 = now()->format('Y-m-d-H-i-s') . '_Art_.log';
        $this->jsonSeeding($filename1, ['articoli.json']);

        // //Fase 2 - Sposto File magazzino se esiste
        $filename2 = now()->format('Y-m-d-H-i-s') . '_Mag_.log';
        $this->jsonSeeding($filename2, ['magazzino.json']);

        // //Fase 3 - Sposto File Doc_rig e Doc_tes se esiste
        $filename3 = now()->format('Y-m-d-H-i-s') . '_Doc_.log';
        $this->jsonSeeding($filename3, ['doc_tes.json', 'doc_rig.json']);

        // //Fase 4 - Sposto File Ord_rig e Ord_tes se esiste
        $filename4 = now()->format('Y-m-d-H-i-s') . '_Ord_.log';
        $this->jsonSeeding($filename4,['ord_tes.json', 'ord_rig.json']);

        // //Fase 5 - Sposto Altri Files se esiste
        $filename5 = now()->format('Y-m-d-H-i-s') . '_Anag_.log';
        $this->jsonSeeding($filename5, []);

        Mail::raw('Attached the Database Log!', function ($message) use ($filename1, $filename2, $filename3, $filename4, $filename5) {
            $message->to('luca.ciotti@gmail.com')
            ->subject('Log Database')
            ->attach($this->logFilesPath . '/' . $filename1)
            ->attach($this->logFilesPath . '/' . $filename2)
            ->attach($this->logFilesPath . '/' . $filename3)
            ->attach($this->logFilesPath . '/' . $filename4)
            ->attach($this->logFilesPath . '/' . $filename5);
        });

        Log::info('Seeding-job ENDED');

        CreateClientUser::dispatch()->onQueue('dbSeed');
        return;
        // $this->release();
    }

    public function failed(\Throwable $e)
    {
        Log::error('failed-job: ' . $this->pathFile);
        Log::error($e->getMessage());
        Mail::raw($e->getMessage(), function ($message) {
            $message->to('luca.ciotti@gmail.com')
            ->subject('FAIL! Log Database');
        });
    }

    public function retryUntil()
    {
        return now()->addSeconds(3600);
    }

    protected function cleanJsonTmpFolder()
    {
        if(!Storage::exists('DbSeed/JsonFiles')){
            Storage::makeDirectory('DbSeed/JsonFiles');
        }
        if(!Storage::exists('DbSeed/JsonFiles/tmp')){
            Storage::makeDirectory('DbSeed/JsonFiles/tmp');
        }
        $oldFiles = Storage::files('DbSeed/JsonFiles/tmp');
        if (!empty($oldFiles)) {
            Log::info("Elimino file tmp vecchi");
            foreach ($oldFiles as $file) {
                Storage::delete($file);
            }
        }
    }

    protected function cleanJsonSeedFolder()
    {
        $oldFiles = Storage::files('DbSeed/JsonFiles');
        if (!empty($oldFiles)) {
            Log::info("Elimino file seeded");
            foreach ($oldFiles as $file) {
                Storage::delete($file);
            }
        }
    }

    protected function unZipJsonFiles()
    {
        Log::info("Unzip Files: " . $this->pathFile);
        $this->cleanJsonTmpFolder();
        $zip = new ZipArchive;
        if ($zip->open($this->pathFile) === TRUE) {
            $zip->extractTo($this->jsonFilesPath . '/tmp' . '/');
        } else {
            $this->fail();
        }
        $zip->close();
        //Cancello file Movimenti - NON MI SERVE
        if (Storage::exists('DbSeed/JsonFiles/tmp/movimenti.json')) {
            Storage::delete('DbSeed/JsonFiles/tmp/movimenti.json');
        }
    }

    protected function moveFilesToSeed($aFiles = [])
    {
        $this->cleanJsonSeedFolder();
        if (!empty($aFiles)) {
            foreach ($aFiles as $file) {
                if (Storage::exists('DbSeed/JsonFiles/tmp/' . $file)) {
                    Storage::move('DbSeed/JsonFiles/tmp/' . $file, 'DbSeed/JsonFiles/' . $file);
                }
            }
        } else {
            $tmpFiles = Storage::files('DbSeed/JsonFiles/tmp');
            if (!empty($tmpFiles)) {
                foreach ($tmpFiles as $file) {
                    Storage::move($file, 'DbSeed/JsonFiles/' . basename($file) );
                }
            }
        }
        return !empty(Storage::files('DbSeed/JsonFiles'));
    }

    protected function jsonSeeding($filename, $aFiles = [])
    {
        $isSeed = false;
        $output = '';
        try {
            Log::info('Seeding-job: Move File on ' . $filename);
            $isSeed = $this->moveFilesToSeed($aFiles);
        } catch (\Exception $e) {
            $this->fail($e);
        }
        if ($isSeed) {
            try {
                Log::info('Seeding-job: Artisan Call on ' . $filename);
                Artisan::call('db:seed', array('--database' => 'pNet_DATA', '--force' => true));
            } catch (\Exception $e) {
                $this->fail($e);
            } finally {
                $output .= Artisan::output();
                Storage::put('DbSeed/Logs/' . $filename, $output);
            }
        } else {
            $output .= "NoFileToSeed";
            Storage::put('DbSeed/Logs/' . $filename, $output);
        }
        $output = null;
    }
}
