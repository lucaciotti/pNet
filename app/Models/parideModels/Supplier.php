<?php

namespace App\Models\parideModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'cli_for';
    public $timestamps = false;
    protected $primaryKey = 'id_cli_for';
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    // Scope that garante to find only Client from anagrafe
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('supplier', function (Builder $builder) {
            $builder->where('id_cli_for', 'like', 'F%');
        });
    }

    public function __construct($attributes = array())
    {
        self::boot();
        parent::__construct($attributes);
        //Imposto la Connessione al Database
        // $this->setConnection(RedisUser::get('ditta_DB'));
    }

    public function products()
    {
        return $this->hasMany('App\Models\parideModels\Product', 'id_cli_for', 'id_cli_for');
    }
}
