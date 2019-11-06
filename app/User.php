<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'nip', 'name', 'image', 'password', 'reset_password','latitude1','longitude1', 'latitude2', 'longitude2'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    public function role()
    {
        return $this->belongsTo('App\UserRole');
    }

    public function forests()
    {
        return $this->hasMany('App\Forest');
    }

    public function hasRole($roles)
    {
        $this->have_role = $this->getUserRole();

        if (is_array($roles)) {
            foreach ($roles as $need_role) {
                if ($this->cekUserRole($need_role)) {
                    return true;
                }
            }
        } else {
            return $this->cekUserRole($roles);
        }
        return false;
    }
    private function getUserRole()
    {
        return $this->role()->getResults();
    }

    private function cekUserRole($role)
    {
        return (strtolower($role) == strtolower($this->have_role->role)) ? true : false;
    }
}
