<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
     protected $fillable = [
       'name', 'groupID', 'pictureUrl',
    ];
    
    protected $hidden = [
        'groupID',
    ];
    
    public function users(){
        return $this->belongsToMany('App\User');
    }
}
