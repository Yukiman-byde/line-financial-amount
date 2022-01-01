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
    
    public function store($name, $pictureUrl, $id_of_group){
       $group = $this->where('name', strval($name))
                   ->where('groupID', strval($id_of_group))
                   ->first();
                   
       if($group === null){
            $group = $this->create([
           //文字列化させないとはいらない。
           'name'     =>  strval($name),
           'groupID'  =>  strval($id_of_group),
           'pictureUrl'=> strval($pictureUrl),
           ]);  
       }
    }
    
    public function content_query(string $content){
       $group = $this->where('name', 'Le journal actuel en français')->first();
       $user = $group->users()->get();
       return $user;
    }
}
