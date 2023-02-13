<?php

namespace App\Models\parideModels\Docs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class RowDoc extends Model
{
    use HasFactory;
    use \Awobaz\Compoships\Compoships;

    protected $table = 'doc_rig';
    public $timestamps = false;
    protected $primaryKey = 'id_doc_rig';
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id_doc_rig'];
    protected $dates = ['ddt_data'];

    protected $appends = ['qtarow', 'qtares'];

    // Scope that garante to find only the right Model
    protected static function boot()
    {
        parent::boot();
    }

    // APPENDS Calculated Columns
    public function getQtarowAttribute()
    {
        return round($this->qta, 2);
    }
    public function getQtaresAttribute()
    {
        return round($this->qta,2);
    }


    // JOINS
    public function FDHead()
    {
        return $this->hasOne('App\Models\parideModels\Docs\FDCli', 'id_doc_tes', 'id_doc_tes');
    }

    public function DDTHead()
    {
        return $this->hasOne('App\Models\parideModels\Docs\DDTCli', 'id_doc_tes', 'id_doc_tes');
    }

    public function FPHead()
    {
        return $this->hasOne('App\Models\parideModels\Docs\FPCli', 'id_ord_tes', 'id_ord_tes');
    }

    public function FTHead()
    {
        return $this->hasOne('App\Models\parideModels\Docs\FTCli', 'id_doc_tes', 'id_doc_tes');
    }

    public function NCHead()
    {
        return $this->hasOne('App\Models\parideModels\Docs\NCCli', 'id_doc_tes', 'id_doc_tes');
    }

    public function OrdHead()
    {
        return $this->hasOne('App\Models\parideModels\Docs\OrdCli', 'id_ord_tes', 'id_ord_tes');
    }

    public function QuoteHead()
    {
        return $this->hasOne('App\Models\parideModels\Docs\QuoteCli', 'id_ord_tes', 'id_ord_tes');
    }


    public function head()
    {
        if ($this->FDHead!=null) {
            return $this->FDHead();
        }
        if ($this->DDTHead!=null) {
            return $this->DDTHead();
        }
        if ($this->FPHead!=null) {
            return $this->FPHead();
        }
        if ($this->NCHead!=null) {
            return $this->NCHead();
        }
        if ($this->OrdHead!=null) {
            return $this->OrdHead();
        }
        if ($this->QuoteHead!=null) {
            return $this->QuoteHead();
        }
        if ($this->FTHead!=null) {
            return $this->FTHead();
        }
    }



    public function product()
    {
        return $this->hasOne('App\Models\parideModels\Product', 'id_art', 'id_art');
    }

    public function tva()
    {
        return $this->hasOne('App\Models\parideModels\Iva', 'id_iva', 'id_iva');
    }

    public function skuCustomCode()
    {
        return $this->hasOne('App\Models\parideModels\wSkuCustom', 'id_art', 'id_art')->where('id_cli_for', $this->head->id_cli_for);
    }
}
