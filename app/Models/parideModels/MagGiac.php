<?php

namespace App\Models\parideModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagGiac extends Model
{
    use HasFactory;
    protected $table = 'magazzino';
    public $timestamps = false;
    protected $primaryKey = ['id_mag', 'id_art'];
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id_mag', 'id_art'];
    // protected $appends = ['esistenza', 'disp'];


    // public function getDispAttribute()
    // {
    //     return substr($this->attributes['id_fam'], 0, 2);
    // }


}
