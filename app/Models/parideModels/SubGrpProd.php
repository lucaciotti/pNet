<?php

namespace App\Models\parideModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubGrpProd extends Model
{
    use HasFactory;
    
    protected $table = 'famiglia';
    public $timestamps = false;
    protected $primaryKey = 'id_farm';
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id_farm'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('subGruppo', function (Builder $builder) {
            $builder->whereRaw('length(id_fam)>2');
        });
    }
}
