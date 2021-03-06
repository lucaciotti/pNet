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

        // switch (RedisUser::get('role')) {
        //     case 'agent':
        //         static::addGlobalScope('agent', function (Builder $builder) {
        //             $builder->where('agente', RedisUser::get('codag'));
        //         });
        //         break;
        //     case 'superAgent':
        //         static::addGlobalScope('superAgent', function (Builder $builder) {
        //             $builder->whereHas('agent', function ($query) {
        //                 $query->where('u_capoa', RedisUser::get('codag'));
        //             });
        //         });
        //         break;
        //     case 'client':
        //         static::addGlobalScope('client', function (Builder $builder) {
        //             $builder->where('codice', RedisUser::get('codcli'));
        //         });
        //         break;

        //     default:
        //         break;
        // }
    }

    public function __construct($attributes = array())
    {
        self::boot();
        parent::__construct($attributes);
        //Imposto la Connessione al Database
        // $this->setConnection(RedisUser::get('ditta_DB'));
    }
}
