<?php

namespace App\Models\parideModels\Docs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NCCli extends Model
{
    use HasFactory;


    protected $table = 'doc_tes';
    public $timestamps = false;
    protected $primaryKey = 'id_doc_tes';
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id_doc_tes'];
    protected $dates = ['data', 'data_div'];

    // Scope that garante to find only the right Model
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('docCli', function (Builder $builder) {
            $builder->where('id_cli_for', 'like', 'C%')->where('tipo_doc', '5');
        });
    }

    // APPENDS Calculated Columns


    // JOINS
    public function rows()
    {
        return $this->hasMany('App\Models\parideModels\Docs\RowDoc', 'id_doc_tes', 'id_doc_tes');
    }

    public function client()
    {
        return $this->hasOne('App\Models\parideModels\Client', 'id_cli_for', 'id_cli_for');
    }
}
