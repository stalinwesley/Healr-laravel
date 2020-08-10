<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as auth;


class User extends Authenticatable implements auth
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'phone_number', 'pin'
    ];
    protected $primaryKey = 'user_id';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pin'
    ];

    public function vendorPartner()
    {
        return $this->hasOne('App\VendorPartner','user_id');
    }
    public function vendorPartnerRep()
    {
        return $this->hasOne('App\vendorPartnerRep','user_id');
    }
    public function getAuthPassword()
    {
    return $this->pin;
    }
}
