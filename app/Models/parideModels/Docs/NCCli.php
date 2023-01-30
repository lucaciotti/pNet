<?php

namespace App\Models\parideModels\Docs;

use App\Helpers\RedisUser;
use Awobaz\Compoships\Compoships;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NCCli extends Model
{
    use HasFactory;
    use \Awobaz\Compoships\Compoships;


    protected $table = 'doc_tes';
    public $timestamps = false;
    protected $primaryKey = 'id_doc_tes';
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id_doc_tes'];
    protected $dates = ['data', 'data_div'];
    protected $appends = ['id_doc'];

    // Scope that garante to find only the right Model
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('docCli', function (Builder $builder) {
            $builder->where('id_cli_for', 'like', 'C%')->where('tipo_doc', '5');
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

    // APPENDS Calculated Columns
    public function getIdDocAttribute()
    {
        return $this->attributes['id_doc_tes'];
    }

    public function getDescrTipodocAttribute()
    {
        return 'Nota di Accredito';
    }

    public function getTipoDocAttribute()
    {
        return 'NC';
    }

    public function getTipomoduloAttribute()
    {
        return 'N';
    }

    public function getEvaso(){
        return $this->attributes['fatturato'];
    }

    // JOINS
    public function rows()
    {
        return $this->hasMany('App\Models\parideModels\Docs\RowDoc', 'id_doc_tes', 'id_doc_tes');
    }

    public function client()
    {
        return $this->hasOne('App\Models\parideModels\Client', 'id_cli_for', 'id_cli_for');
    }

    public function payType()
    {
        return $this->hasOne('App\Models\parideModels\PaymentType', 'id_pag', 'id_pag');
    }

    public function docSent()
    {
        return $this->hasOne('App\Models\parideModels\Docs\wDocSent', 'id_doc', 'id_doc_tes');
    }

    public function destinazioni()
    {
        return $this->hasOne('App\Models\parideModels\Destinazioni', ['id_dest_pro', 'id_cli_for'], ['id_dest', 'id_cli_for']);
    }
}
