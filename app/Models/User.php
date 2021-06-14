<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Soved\Laravel\Gdpr\Portable;
use Soved\Laravel\Gdpr\Contracts\Portable as PortableContract;

class User extends Authenticatable implements PortableContract
{
    use LaratrustUserTrait;
    use HasFactory, Portable, Notifiable;


    protected $username = 'nickname';

    protected $connection = 'pNet_SYS';
    
    // GPDR Properties
    protected $gdprWith = ['client'];
    protected $gdprHidden = ['password', 'remember_token'];
    // protected $gdprVisible = ['name', 'email'];
    // protected $encrypted = ['ssnumber'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nickname', 'email', 'password', 'ditta', 'codag', 'codcli', 'codfor', 'avatar', 'lang', 'invitato_email'
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


    //JOIN pNet
    public function client()
    {
        return $this->hasOne('App\Models\parideModels\Client', 'id_cli_for', 'codcli');
    }

    public function agent()
    {
        return $this->hasOne('App\Models\parideModels\Agent', 'id_agente', 'codag');
    }
}
