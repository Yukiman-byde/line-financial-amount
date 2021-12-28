<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
    
    public function store($event, $group_id){
         $user_id = $event->getUserId();
         $res = $bot->getGroupMemberProfile($group_id, $user_id);
         $data = $res->getJSONDecodedBody();
         $user_name = $data['displayName'];
         $user_picture = $data['pictureUrl'];
         
         $user = $this->where('name', $user_name)->where('provided_user_id')->first();
        if($user === null){
            $user = $this->create([
                'name' => strval($user_name),
                'provider' => 'line',
                'provided_user_id' => strval($user_id),
                'avatar' => strval($user_picture),
                ]);
            //$user->groups()->attach($group_user_id);
        }
    }
}
