<?php

namespace App\Models\parideModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $table = 'pagamenti';
    public $timestamps = false;
    protected $primaryKey = 'id_pag';
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id_pag'];
}
