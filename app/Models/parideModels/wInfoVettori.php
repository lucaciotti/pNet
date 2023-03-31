<?php

namespace App\Models\parideModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wInfoVettori extends Model
{
    
    protected $table = 'w_info_vettori';
    protected $connection = 'pNet_DATA';
    
    protected $fillable = ['id_vet', 'url'];

    public function vettore()
    {
        return $this->hasOne('App\Models\parideModels\Vettori', 'id_vet', 'id_vet');
    }
}
