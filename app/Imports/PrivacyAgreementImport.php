<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\PrivacyUserAgree;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class PrivacyAgreementImport implements ToModel, WithStartRow, WithCustomCsvSettings
{

    private $delimiter;

    public function __construct($delimiter)
    {
        $this->delimiter = $delimiter;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => $this->delimiter
        ];
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        try{
            $user_id = isset($row[0]) ? $row[0] : '';
            $id_cli_for = isset($row[2])  ? $row[2] : '';
            $name = isset($row[5]) ? $row[5] : '-';
            $surname = isset($row[6]) ? $row[6] : '-';
            $privacy_agree = isset($row[7]) ? ($row[7]==1 ? true : false) : false;
            $marketing_agree = isset($row[8]) ? ($row[8] == 1 ? true : false) : false;
            $dateAgreement = isset($row[9]) ? (str_contains($row[9], '/') ? Carbon::createFromFormat('d/m/Y H:i:s',  $row[9].' 00:00:00') :  Carbon::createFromFormat('d-m-Y H:i:s',  $row[9] . ' 00:00:00')) : now();
            
            // Se non c'è User ID errato o mancante lo cerco a partire dal codice cliente
            if($user_id!=''){
                $user = User::find($user_id);
                if($user){
                    $user_id = $user->id;
                } else {
                    Log::error("Import Privacy Agreement CSV error: User Not Found! ".$row);
                }
            }

            if($user_id=='' && $id_cli_for!=''){
                $user = User::where('codcli', $id_cli_for)->first();
                $user_id = $user->id;
            } 

            //Fine dei Mandatory check
            if($user_id == '' && $id_cli_for == '') {
                Log::error("Import Privacy Agreement CSV error: Missing parameters!");
                Log::error($row);
            } else {
                if (!PrivacyUserAgree::where('user_id', $user_id)->exists()) {
                    Log::info("Import Privacy Agreement CSV -> Info: Inserimento Privacy: " . $user->name);
                    return new PrivacyUserAgree([
                        'user_id' => $user_id,
                        'name' => $name,
                        'surname' => $surname,
                        'privacy_agreement' => $privacy_agree,
                        'marketing_agreement' => $marketing_agree,
                        'updated_at' => $dateAgreement
                    ]);
                    // $privacyAgree->save();
                } else {
                    $privacyAgree = PrivacyUserAgree::where('user_id', $user_id)->first();
                    Log::info("Import Privacy Agreement CSV -> Info: Modifica Privacy: ".$user->name);
                    $privacyAgree->name = $name;
                    $privacyAgree->surname = $surname;
                    $privacyAgree->privacy_agreement = $privacy_agree;
                    $privacyAgree->marketing_agreement = $marketing_agree;
                    $privacyAgree->updated_at = $dateAgreement;
                    return $privacyAgree;
                }
            }
        } catch (\Exception $e) {
            Log::error("Import Privacy Agreement CSV error: " . $e->getMessage());
            Log::error($row);
            // dd($row);
        }
        // return new PrivacyUserAgree([
        //     //
        // ]);
    }
}
