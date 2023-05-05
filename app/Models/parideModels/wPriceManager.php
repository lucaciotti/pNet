<?php

namespace App\Models\parideModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wPriceManager extends Model
{
    use HasFactory;

    protected $table = 'w_price_manager';
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id'];
    protected $dates = ['start_date', 'end_date'];

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
}
