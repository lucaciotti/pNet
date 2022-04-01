<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacyUserAgree extends Model
{
    use HasFactory;
    protected $table = 'privacyTerms_user_agree';
    protected $connection = 'pNet_SYS';

    protected $guarded = ['id'];

    //JOIN pNet
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

}
