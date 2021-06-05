<?php

namespace App\Models\parideModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marche extends Model
{
    protected $table = 'marche';
    public $timestamps = false;
    protected $primaryKey = 'id_mar';
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id_mar'];
}
