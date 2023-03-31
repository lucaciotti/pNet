<?php

namespace App\Models\parideModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colli extends Model
{
    protected $table = 'colli_tab';
    public $timestamps = false;
    protected $primaryKey = ['id_doc_tes', 'num'];
    public $incrementing = false;
    protected $connection = 'pNet_DATA';

    protected $guarded = ['id_doc_tes', 'num'];
}
