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
    
    public function current_amount(){
        $c_a = $this->orderBy('amount', 'desc')->first();
        $current_amount = $c_a->amount; 
        return $current_amount;
    }
    
    
}
