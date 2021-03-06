<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{

    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','user_types_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function Payment(){
        return $this->hasMany('App\Payment');

    }

    public function paymentCreatedBy(){
        return $this->hasMany('App\Payment','created_by');

    }

    public function paymentApprovedBy(){
        return $this->hasMany('App\Payment','approved_by');
    }

    public function paymentDisbursedBy(){
        return $this->hasMany('App\Payment','disbursed_by');
    }

    public function paymentVerifiedBy(){
        return $this->hasMany('App\Payment','verified_by');
    }

    public function UserType(){

        return $this->hasMany('App\UserType');


    }
    public function UserProfile(){

        return $this->hasOne('App\UserProfile');

    }

    public  function projects(){

        return $this->belongsToMany('App\Project')->withTrashed();
    }

    public function vocher(){

       return $this->hasMany('App\Vocher');

    }

}
