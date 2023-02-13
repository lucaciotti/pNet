<?php

namespace App\Models\parideModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrpProd extends Model
{
    use HasFactory;
    
    protected $table = 'famiglia';
    public $timestamps = false;
    protected $primaryKey = 'id_fam';
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id_fam'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('masterGrp', function (Builder $builder) {
            $builder->whereRaw('length(id_fam)=2');
        });
    }

    public function __construct($attributes = array())
    {
        self::boot();
        parent::__construct($attributes);
    }
}
