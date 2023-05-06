<?php

namespace App\Models\parideModels\Docs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wDocRow extends Model
{
    use HasFactory;
    protected $table = 'w_doc_row';
    protected $connection = 'pNet_DATA';

    // protected $fillable = ['doc_head_id', 'id_art', 'quantity'];
    protected $guarded = ['id'];

    public function head()
    {
        return $this->hasOne('App\Models\parideModels\Docs\wDocHead', 'id', 'doc_head_id');
    }

    public function product()
    {
        return $this->hasOne('App\Models\parideModels\Product', 'id_art', 'id_art');
    }

    public function skuCustomCode()
    {
        return $this->hasOne('App\Models\parideModels\wSkuCustom', 'id_art', 'id_art')->where('id_cli_for', $this->head->id_cli_for);
    }
}
