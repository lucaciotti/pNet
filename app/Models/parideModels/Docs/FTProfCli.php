<?php

namespace App\Models\parideModels\Docs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FTProfCli extends Model
{
    use HasFactory;

    protected $table = 'ord_tes';
    public $timestamps = false;
    protected $primaryKey = 'id_ord_tes';
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id_ord_tes'];
    protected $dates = ['data', 'data_eva'];

    // Scope that garante to find only the right Model
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('docCli', function (Builder $builder) {
            $builder->where('id_cli_for', 'like', 'C%')->where('tipo', '5');
        });
    }

    // APPENDS Calculated Columns


    // JOINS
    public function rows()
    {
        return $this->hasMany('App\Models\parideModels\Docs\RowOrd', 'id_ord_tes', 'id_ord_tes');
    }

    public function client()
    {
        return $this->hasOne('App\Models\parideModels\Client', 'id_cli_for', 'id_cli_for');
    }
}
