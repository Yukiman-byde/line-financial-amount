<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Amount extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'amount', 'lend_provider_user_id', 'borrow_provider_user_id', 'payed'
    ];
    
    public function users(){
        return $this->belongsTo('App\User');
    }
    
    public function add_money(int $number, string $lend, string $borrow, string $content){
        $this->amount = $number;
        $this->lend_provider_user_id = $lend;
        $this->borrow_provider_user_id = $borrow;
        $this->payed = false;
        $this->content = $content;
        
        $this->save();
    }
}
