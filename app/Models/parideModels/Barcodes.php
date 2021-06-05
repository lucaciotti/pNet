<?php

namespace App\Models\parideModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barcodes extends Model
{
    protected $table = 'cod_bar';
    public $timestamps = false;
    protected $primaryKey = 'id_cod_bar';
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    // protected $guarded = ['id_mar'];
}
