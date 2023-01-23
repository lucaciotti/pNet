<?php

namespace App\Models\parideModels\Docs;

// use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RowOrd extends Model
{
    use HasFactory;
    // use \Awobaz\Compoships\Compoships;

    protected $table = 'ord_rig';
    public $timestamps = false;
    protected $primaryKey = 'id_ord_rig';
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id_ord_rig'];
    protected $dates = ['data_eva'];

    protected $appends = ['qtarow', 'qtares'];

    // Scope that garante to find only the right Model
    protected static function boot()
    {
        parent::boot();
    }

    // APPENDS Calculated Columns
    public function getQtarowAttribute()
    {
        return round($this->qta_ord, 2);
    }
    public function getQtaresAttribute()
    {
        return round($this->qta_ord - $this->qta_eva, 2);
    }

    // JOINS
    public function product()
    {
        return $this->hasOne('App\Models\parideModels\Product', 'id_art', 'id_art');
    }

    public function tva()
    {
        return $this->hasOne('App\Models\parideModels\Iva', 'id_iva', 'id_iva');
    }

    // public function skuCustomCode()
    // {
    //     // return $this->hasOne('App\Models\parideModels\wSkuCustom', 'id_art', 'id_art')->where('id_cli_for', $this->id_cli_for);
    // }

}
