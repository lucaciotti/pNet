<?php

namespace App\Models\parideModels;

use App\Helpers\RedisUser;
use Awobaz\Compoships\Compoships;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Destinazioni extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'destinazioni';
    public $timestamps = false;
    // protected $primaryKey = ['id_dest', 'id_dest_pro', 'id_cli_for'];
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id_dest', 'id_dest_pro', 'id_cli_for'];

    // Scope that garante to find only Client from anagrafe
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('clients', function (Builder $builder) {
            $builder->where('id_cli_for', 'like', 'C%');
        });

        if (Auth::check()) {
            switch (RedisUser::get('role')) {
                    // case 'agent':
                    //     static::addGlobalScope('agent', function (Builder $builder) {
                    //         $builder->where('agente', RedisUser::get('codag'));
                    //     });
                    //     break;
                case 'client':
                    static::addGlobalScope('client', function (Builder $builder) {
                        $builder->where('id_cli_for', RedisUser::get('codcli'));
                    });
                    break;

                default:
                    break;
            }
        }
    }

    public function __construct($attributes = array())
    {
        self::boot();
        parent::__construct($attributes);
        //Imposto la Connessione al Database
        // $this->setConnection(RedisUser::get('ditta_DB'));
    }


}
