<?php

namespace App\Actions\Sys\DbSeed;

use App\Jobs\SeedDatabase;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\RedirectResponse;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Lorisleiva\Actions\Concerns\AsAction;

class ZipFileUpload
{
    use AsAction;

    public function handle(UploadedFile $file) :string
    {
        $filename = now()->format('Y-m-d-H-i-s').'.'.$file->getClientOriginalExtension();
        return Storage::putFileAs('DbSeed/ZipFiles', $file, $filename);
    }

    public function asController(ActionRequest $request)
    {   
        $path = '';
        $message = '';
        $success = false;
        
        $validator = Validator::make(
            $request->all(),
            [
                'file' => 'required|mimes:zip|max:102400',
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors();
            $success = false;
        } else {
            $file = $request->file;
            $path = $this->handle($file);
            $message = "File successfully uploaded";
            $success = true;
            SeedDatabase::dispatch($path)->onQueue('dbSeed');
        }
        return [
            "success" => $success,
            "message" => $message,
            "path" => $path
        ];
    }

    public function jsonResponse(array $data): JsonResponse
    {
        $success = Arr::get($data, 'success');
        return $success ? response()->json($data) : response()->json($data, 401) ;
    }

    public function htmlResponse(array $data): RedirectResponse
    {
        return redirect()->back()->with('data', $data);
    }

}
