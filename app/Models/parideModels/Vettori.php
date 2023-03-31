<?php

namespace App\Models\parideModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vettori extends Model
{
    protected $table = 'vettori';
    public $timestamps = false;
    protected $primaryKey = 'id_vet';
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id_vet'];

    public function info()
    {
        return $this->hasOne('App\Models\parideModels\wInfoVettori', 'id_vet', 'id_vet');
    }
}
