<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Group;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'name', 'provider', 'provided_user_id', 'avatar', 'groupId',
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
    
    public function groups(){
        return $this->belongsToMany('App\Group');
    }
    
    public function attach($user_id, $group_id){
         $group = Group::where('groupID', $group_id)->first();
         
         if(isset($group)){
             $user = $this->where('provided_user_id', $user_id)->first();
             $user->groups()->attach($group->id);
         }
        }
}
