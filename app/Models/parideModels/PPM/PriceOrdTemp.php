<?php

namespace App\Models\parideModels\PPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceOrdTemp extends Model
{
    use HasFactory;
    protected $table = 'w_price_ord_temp';
    protected $primaryKey = 'id';
    protected $connection = 'pNet_DATA';

    //JOIN
}
