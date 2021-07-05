<?php

namespace App\Models\parideModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iva extends Model
{
    protected $table = 'iva';
    public $timestamps = false;
    protected $primaryKey = 'id_iva';
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id_iva'];
}
