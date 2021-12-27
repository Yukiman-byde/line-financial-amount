<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Amount;

class CalculateController extends Controller
{
    public function addition(Amount $amount, Request $request){
      $dummy_request = 500;
      $amount_number = $amount->current_amount() + $dummy_request;
      $savedata = [
        'amount' => $amount_number,
        'lend_provider_user_id' => $amount->value('lend_provider_user_id'),
        'borrow_provider_user_id' => $amount->value('borrow_provider_user_id'),
        'payed'                 => false,
      ];

      $amount->fill($savedata)->save();
    }
    
    public function subtraction(Amount $amount){
      $dummy_request = 500;
      $amount_number = $amount->current_amount() - $dummy_request;
      
       $savedata = [
        'amount' => $amount_number,
        'lend_provider_user_id' => $amount->value('lend_provider_user_id'),
        'borrow_provider_user_id' => $amount->value('borrow_provider_user_id'),
        'payed'                 => false,
      ];

      $amount->fill($savedata)->save();
    }
    
    public function payedAction(){
     //payedをtrueにすると払い済みになる。
      $dummy_id = 4;
      $amount = Amount::where('id', $dummy_id)->first();
      if($amount){
        $amount->delete();
      }
    }
}