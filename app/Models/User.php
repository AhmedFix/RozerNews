<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Notifiable, LaratrustUserTrait;

    protected $fillable = ['name', 'email', 'password','profile_picture','type'];

    protected $appends = ['profile_picture_path'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //atr
    public function getNameAttribute($value)
    {
        return ucfirst($value);

    }// end of getNameAttribute

    public function getProfilePicturePathAttribute()
    {

        if ($this->profile_picture) {
            return asset('images/profile/' . $this->profile_picture);
        }

        return asset('images/profile/avatar.png');

    }// end of getProfilePicturePathAttribute

    //scope
    public function scopeWhenRoleId($query, $roleId)
    {
        return $query->when($roleId, function ($q) use ($roleId) {

            return $q->whereHas('roles', function ($qu) use ($roleId) {

                return $qu->where('id', $roleId);

            });

        });

    }// end of scopeWhenRoleId

    //rel
    public function favoriteArticales()
    {
        return $this->belongsToMany(Articale::class, 'user_favorite_articale');

    }// end of favoriteArticales

    //fun
    public function hasImage()
    {
        return $this->profile_picture != null;

    }// end of hasImage

     function isSuperAdmin() {
        if($this->type=='super_admin')
         return true;
        else return false;
      }

}//end of model
