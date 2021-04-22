<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasFactory, Notifiable;


    protected $username = 'nickname';

    protected $connection = 'pNet_SYS';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nickname', 'email', 'password', 'ditta', 'codag', 'codcli', 'codfor', 'avatar', 'lang'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['role_name'];

    public function getRoleNameAttribute()
    {
        return $this->roles()->first()->name;
    }

    public function adminlte_image()
    {   
        return '/assets/img/'.$this->avatar;
    }

    public function adminlte_desc()
    {
        return "Admin User";
    }

    public function adminlte_profile_url() {
        return route('user::users.show', $this->id);
    }
}
