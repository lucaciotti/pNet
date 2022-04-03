<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\PrivacyUserAgree;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class PrivacyAgreementImport implements ToModel, WithStartRow, WithCustomCsvSettings
{

    public function startRow(): int
    {
        return 2;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
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
        $user_id = $row[0];
        $id_cli_for = $row[2];
        $name = $row[4]==null ? '' : $row[4];
        $surname = $row[5] == null ? '' : $row[5];
        $privacy_agree = $row[6]==1 ? true : false;
        $marketing_agree = $row[7]==1 ? true : false;
        $dateAgreement = Carbon::createFromFormat('d/m/Y H:i:s',  $row[8].' 00:00:00');

        if($user_id==''){
            $user = User::select('id')->where('codcli', $id_cli_for)->first();
            $user_id = $user->id;
        }

        if (!PrivacyUserAgree::where('user_id', $user_id)->exists()) {
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
            $privacyAgree->name = $name;
            $privacyAgree->surname = $surname;
            $privacyAgree->privacy_agreement = $privacy_agree;
            $privacyAgree->marketing_agreement = $marketing_agree;
            $privacyAgree->updated_at = $dateAgreement;
            return $privacyAgree;
        }
        // return new PrivacyUserAgree([
        //     //
        // ]);
    }
}
