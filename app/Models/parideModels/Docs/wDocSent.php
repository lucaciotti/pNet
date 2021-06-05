<?php

namespace App\Models\parideModels\Docs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wDocSent extends Model
{
    use HasFactory;
    protected $table = 'w_doc_sent';
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id'];
    // protected $dates = ['data_invio'];
    // protected $appends = ['id_doc'];

    public function ddt()
    {
        return $this->hasOne('App\Models\parideModels\Docs\DDTCli', 'id_doc_tes', 'id_doc');
    }

    public function client()
    {
        return $this->hasOne('App\Models\parideModels\Client', 'id_cli_for', 'id_cli');
    }
}
