<?php

namespace App\Models\parideModels;

use App\Helpers\RedisUser;
use Awobaz\Compoships\Compoships;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Jackiedo\Cart\Contracts\UseCartable; // Interface
use Jackiedo\Cart\Traits\CanUseCart;     // Trait


class Product extends Model implements UseCartable
{
    use \Awobaz\Compoships\Compoships;
    use CanUseCart;
    
    protected $table = 'articoli';
    public $timestamps = false;
    protected $primaryKey = 'id_art';
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id_art'];
    protected $dates = ['data_reg'];
    // protected $appends = ['master_grup'];
    
    // CartProperties
    protected $cartTitleField = 'descr';        // Your correctly field for product's title
    protected $cartPriceField = 'prezzo_1';  // Your correctly field for product's price

    // Scope that garante to find only Supplier from anagrafe
    protected static function boot()
    {
        parent::boot();

        if (Auth::check()) {
            if (in_array(RedisUser::get('role'), ['client', 'agent'])) {
                static::addGlobalScope('Attivo', function (Builder $builder) {
                    $builder->where('non_attivo', '0');
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

    // //Accessors
    // public function getMasterClasAttribute()
    // {
    //     return substr($this->attributes['classe'], 0, 3);
    // }

    public function getMasterGrupAttribute()
    {
        return substr($this->attributes['id_fam'], 0, 2);
    }

    
    public function livewireKey()
    {
        return md5("$this->id_art.$this->updated_at");
    }

    // public function getTipoProdAttribute()
    // {
    //     if (substr($this->attributes['gruppo'], 0, 3) == "B06") {
    //         $tipo = "Kubica";
    //     } elseif (substr($this->attributes['gruppo'], 0, 1) == "B") {
    //         $tipo = "Koblenz";
    //     } elseif (substr($this->attributes['gruppo'], 0, 1) == "A") {
    //         $tipo = "Krona";
    //     } elseif (substr($this->attributes['gruppo'], 0, 1) == "C") {
    //         $tipo = "Grass";
    //     } elseif (substr($this->attributes['gruppo'], 0, 1) == "2") {
    //         $tipo = "Campioni";
    //     } else {
    //         $tipo = "KK";
    //     }
    //     return $tipo;
    // }

    // public function getListinoAttribute()
    // {
    //     if (RedisUser::get('ditta_DB') == "kNet_it") {
    //         if (substr($this->attributes['gruppo'], 0, 1) == 'B') {
    //             $listino = $this->attributes['listino6'];
    //         } else {
    //             $listino = $this->attributes['listino1'];
    //         }
    //     } else {
    //         $listino = $this->attributes['listino1'];
    //     }
    //     return $listino;
    // }

    // JOIN Tables
    // public function docrow()
    // {
    //     return $this->hasMany('knet\ArcaModels\DocRow', 'codicearti', 'codice');
    // }

    // public function masterClas()
    // {
    //     return $this->hasOne('knet\ArcaModels\ClasProd', 'codice', 'master_clas');
    // }

    // public function clasProd()
    // {
    //     return $this->hasOne('knet\ArcaModels\SubClasProd', 'codice', 'classe');
    // }

    public function masterGrpProd()
    {
        return $this->hasOne('App\Models\parideModels\GrpProd', 'id_fam', 'master_grup');
    }
    
    public function grpProd()
    {
        return $this->hasOne('App\Models\parideModels\SubGrpProd', 'id_fam', 'id_fam');
    }

    public function supplier()
    {
        return $this->hasOne('App\Models\parideModels\Supplier', 'id_cli_for', 'id_cli_for');
    }

    public function magGiac()
    {
        return $this->hasOne('App\Models\parideModels\MagGiac', 'id_art', 'id_art');
    }

    public function marche()
    {
        return $this->hasOne('App\Models\parideModels\Marche', 'id_mar', 'id_mar');
    }

    public function barcodes()
    {
        return $this->hasMany('App\Models\parideModels\Barcodes', 'id_art', 'id_art');
    }

    public function supplierCodes()
    {
        // return $this->hasMany('App\Models\parideModels\ProdSupCod', 'id_art', 'id_art')->where('id_cli_for', $this->id_cli_for);
        return $this->hasMany('App\Models\parideModels\ProdSupCod', ['id_art', 'id_cli_for'], ['id_art', 'id_cli_for']);
    }

    public function tva()
    {
        return $this->hasOne('App\Models\parideModels\Iva', 'id_iva', 'id_iva');
    }

    public function skuCustomCode()
    {
        return $this->hasMany('App\Models\parideModels\wSkuCustom', 'id_art', 'id_art');
    }


    // public function descrLang(String $lang)
    // {
    //     return $this->hasOne('knet\ArcaModels\ProdLang', 'codicearti', 'codice')->where('codlingua', strtoupper($lang));
    // }

    //Multator
    // public function getDescrizionAttribute($value)
    // {
    //     return ucfirst(strtolower($value));
    // }
}
