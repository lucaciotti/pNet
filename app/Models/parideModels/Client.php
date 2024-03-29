<?php

namespace App\Models\parideModels;

use App\Helpers\RedisUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
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

    public function user()
    {
        return $this->hasOne('App\Models\User', 'codcli', 'id_cli_for');
    }

    public function payType()
    {
        return $this->hasOne('App\Models\parideModels\PaymentType', 'id_pag', 'id_pag');
    }

    public function typeCli()
    {
        return $this->hasOne('App\Models\parideModels\ClientType', 'id_tipo_cl', 'id_tipo_cli');
    }

    public function destinazioni()
    {
        return $this->hasMany('App\Models\parideModels\Destinazioni', 'id_cli_for', 'id_cli_for');
    }
    
    public function skuCustomCode()
    {
        return $this->hasMany('App\Models\parideModels\wSkuCustom', 'id_cli_for', 'id_cli_for');
    }
}
