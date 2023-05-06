<?php

namespace App\Models\parideModels\Docs;

use App\Helpers\RedisUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;
use DB;

class wDocHead extends Model
{
    use HasFactory;
    use \Awobaz\Compoships\Compoships;
    
    protected $table = 'w_doc_head';
    protected $connection = 'pNet_DATA';

    // protected $fillable = ['tipo_doc', 'id_cli_for', 'id_dest_pro', 'processed' , 'id_ord_tes'];
    protected $guarded = ['id'];
    protected $dates = ['data', 'data_eva'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('docCli', function (Builder $builder) {
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

    public static function getNextID() 
    {
        $statement = DB::select("SELECT * FROM pNet_DATA.w_doc_head ORDER BY id DESC LIMIT 0, 1");
        return $statement!=null ? $statement[0]->id+1 : 1;
    }

    public function client()
    {
        return $this->hasOne('App\Models\parideModels\Client', 'id_cli_for', 'id_cli_for');
    }
    
    public function rows()
    {
        return $this->hasMany('App\Models\parideModels\Docs\wDocRow', 'doc_head_id', 'id');
    }

    public function destinazioni()
    {
        return $this->hasOne('App\Models\parideModels\Destinazioni', ['id_dest_pro', 'id_cli_for'], ['id_dest_pro', 'id_cli_for']);
    }

    public function payType()
    {
        return $this->hasOne('App\Models\parideModels\PaymentType', 'id_pag', 'id_pag');
    }
}
