<?php

namespace App\Models\parideModels\Docs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RowDoc extends Model
{
    use HasFactory;

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
    public function product()
    {
        return $this->hasOne('App\Models\parideModels\Product', 'id_art', 'id_art');
    }
}
