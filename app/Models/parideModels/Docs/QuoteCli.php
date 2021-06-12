<?php

namespace App\Models\parideModels\Docs;

use App\Helpers\RedisUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuoteCli extends Model
{
    use HasFactory;

    protected $table = 'ord_tes';
    public $timestamps = false;
    protected $primaryKey = 'id_ord_tes';
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id_ord_tes'];
    protected $dates = ['data','data_eva'];
    protected $appends = ['id_doc'];

    // Scope that garante to find only the right Model
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('docCli', function (Builder $builder) {
            $builder->where('id_cli_for', 'like', 'C%')->where('tipo','3');
        });

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

    // APPENDS Calculated Columns
    public function getIdDocAttribute()
    {
        return $this->attributes['id_ord_tes'];
    }

    public function getDescrTipodocAttribute()
    {
        return 'Preventivo';
    }

    public function getTipoDocAttribute()
    {
        return 'XC';
    }

    public function getTipomoduloAttribute()
    {
        return 'P';
    }

    // JOINS
    public function rows(){
        return $this->hasMany('App\Models\parideModels\Docs\RowOrd', 'id_ord_tes', 'id_ord_tes');
    }

    public function client(){
        return $this->hasOne('App\Models\parideModels\Client', 'id_cli_for', 'id_cli_for');
    }

    public function payType()
    {
        return $this->hasOne('App\Models\parideModels\PaymentType', 'id_pag', 'id_pag');
    }

}
