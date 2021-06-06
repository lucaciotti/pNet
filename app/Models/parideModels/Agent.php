<?php

namespace App\Models\parideModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'agenti';
    public $timestamps = false;
    protected $primaryKey = 'id_agente';
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id_agente'];
}
