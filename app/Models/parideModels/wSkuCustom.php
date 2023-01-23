<?php

namespace App\Models\parideModels;

use App\Helpers\RedisUser;
use Awobaz\Compoships\Compoships;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class wSkuCustom extends Model
{
    use \Awobaz\Compoships\Compoships;
    
    protected $table = 'w_sku_custom';
    protected $primaryKey = ['id_art', 'id_cli_for'];
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    // protected $dates = ['data_reg'];
    protected $fillable = ['id_art', 'id_cli_for', 'sku_code'];

    // Scope that garante to find only Supplier from anagrafe
    protected static function boot()
    {
        parent::boot();

        if (Auth::check()) {
            if (in_array(RedisUser::get('role'), ['client'])) {
                static::addGlobalScope('sku_custom', function (Builder $builder) {
                    $builder->where('id_cli_for',  RedisUser::get('codcli'));
                });
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

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('id_art', '=', $this->getAttribute('id_art'))
            ->where('id_cli_for', '=', $this->getAttribute('id_cli_for'));

        return $query;
    }

    public function client()
    {
        return $this->hasOne('App\Models\parideModels\Client', 'id_cli_for', 'id_cli_for');
    }

    public function product()
    {
        return $this->hasOne('App\Models\parideModels\Product', 'id_art', 'id_art');
    }
}
