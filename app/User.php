<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Group;
use App\Amount;
use Auth;

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
         
         if($group){
             $user = $this->where('provided_user_id', $user_id)->first();
             $user->groups()->attach($group->id);
         }
        }
    public function provider_to_id($query){
     return  $this->where('provided_user_id', $query)->value('id');
    }
    
    public function name_to_id($query){
     return  $this->where('name', $query)
                  ->value('id');
    }

    public function amounts(){
      return  $this->belongsTo('App\Amount', 'lend_provider_user_id');
    }
}
