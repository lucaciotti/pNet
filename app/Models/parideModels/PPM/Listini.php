<?php

namespace App\Models\parideModels\PPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listini extends Model
{
    use HasFactory;
    protected $table = 'w_listini';
    protected $primaryKey = 'id';
    protected $connection = 'pNet_DATA';

    protected $guarded = [];
    // protected $fillable = [];
    protected $dates = ['datainizio', 'datafine'];
    protected $appends = ['master_grup'];

    //ACCESSOR
    public function getMasterGrupAttribute()
    {
        return substr($this->attributes['id_fam'], 0, 2);
    }

    //JOIN
    public function masterGrpProd()
    {
        return $this->hasOne('App\Models\parideModels\GrpProd', 'id_fam', 'master_grup');
    }

    public function grpProd()
    {
        return $this->hasOne('App\Models\parideModels\SubGrpProd', 'id_fam', 'id_fam');
    }

    public function client()
    {
        return $this->hasOne('App\Models\parideModels\Client', 'id_cli_for', 'id_cli_for');
    }

    public function typeCli()
    {
        return $this->hasOne('App\Models\parideModels\ClientType', 'id_tipo_cl', 'id_tipo_cl');
    }


}
