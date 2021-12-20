<?php

namespace App\Models\parideModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientType extends Model
{
    use HasFactory;

    protected $table = 'tipo_clienti';
    public $timestamps = false;
    protected $primaryKey = 'id_tipo_cl';
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

}
