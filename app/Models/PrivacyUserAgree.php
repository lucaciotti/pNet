<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrivacyUserAgree extends Model
{
    use HasFactory;
    protected $table = 'privacyTerms_user_agree';
    protected $connection = 'pNet_SYS';

    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at'];

    //JOIN pNet
    /**
     * Get the user that owns the PrivacyUserAgree
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
