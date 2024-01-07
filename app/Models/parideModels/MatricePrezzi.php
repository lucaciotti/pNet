<?php

namespace App\Models\parideModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatricePrezzi extends Model
{
    protected $table = 'listmatrice';
    public $timestamps = false;
    protected $primaryKey = 'idlis';
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['idlis'];
    protected $dates = ['da_data', 'a_data'];

    public function cliente()
    {
        return $this->hasOne('App\Models\parideModels\Client', 'id_cli_for', 'id_cli_for');
    }

    public function typeCli()
    {
        return $this->hasOne('App\Models\parideModels\ClientType', 'id_tipo_cl', 'id_tipo_cl');
    }

    public function masterGrpProd()
    {
        return $this->hasOne('App\Models\parideModels\GrpProd', 'id_fam', 'master_grup');
    }

    public function grpProd()
    {
        return $this->hasOne('App\Models\parideModels\SubGrpProd', 'id_fam', 'id_fam');
    }

    public function product()
    {
        return $this->hasOne('App\Models\parideModels\Product', 'id_art', 'id_art');
    }
}
