<?php

namespace App\Models\parideModels;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;

class ProdSupCod extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'cod_for';
    public $timestamps = false;
    protected $primaryKey = ['id_art', 'id_cod_for', 'id_cli_for'];
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id_art', 'id_cod_for', 'id_cli_for'];
}
