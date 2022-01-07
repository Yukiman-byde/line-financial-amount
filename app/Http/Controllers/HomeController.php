<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Group;
use App\Amount;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        return view('house');
    }
    
    
    public function auth_user(){
        $array = array();
        $group = Auth::user()->groups()->get();
        array_push($array, $group);
        $user = Auth::user();
        array_push($array, $user);

        return $array;
    }
    
   public function get_user_name($groupName, Group $group){
      return $group->content_query($groupName)->toJson();
   }
   
   public function about_amount(User $user){
       dd($user->amounts(Auth::user()));
   }
   
   public function calculate(Request $request, Amount $amount, User $user, Group $group){
       $groupName = $request->groupName;
       $groupId = $group->where('name', $groupName)->value('groupID');

       $lend_user_id = $user->provider_to_id(Auth::user()->provided_user_id);
       
       $borrow_user_id = $user->name_to_id($request->borrow_provider_user_id);
       
       $amount->amount = $request->amount;
       
       $amount->lend_provider_user_id = $lend_user_id;
       
       $amount->borrow_provider_user_id = $borrow_user_id;
       
       $amount->groupId = $groupId;
       
       $amount->payed = false;
       
       $amount->content = $request->content;
       
       $amount->save();
       //dd($request->amount);
   }
   //テーブルを表示するにはまずログインしているユーザーを持ってくる。
   //次にユーザーに紐付けられているamountのデータを持ってくる。
   //borrowを表示する形にして、他にも名前、日付（amount）、内容(amount)、金額（amount）を持ってくる
   //グループも持ってきて！
   public function results(User $user, Amount $amount, $groupName, Group $group){
   //ここから
    //  $g_users = $group->content_query($groupName);
     
    //  $amounts = [];
    //  //グループ
    //  foreach($g_users as $g_user){
    //     // $amount = $amount->where('borrow_provider_user_id', $g_user->id);
    //      $user = $g_user->amounts();
    //      dd($user->get());
    //      array_push($amounts, $amount->get());
    //  }
    // dd($amounts);
     
    // $amounts = $amounts[0];
    // $user_name = array();
    
    // foreach($amounts as $amount){
    //   $id = $amount->borrow_provider_user_id;
    //   $user_info = $user->where('id', $id)->first();
    //   array_push($user_name, $user_info);
    // }
    //ここまで
    $amount = array();
    
    $group = $group->where('name', $groupName)->first();
    $users = $group->users()->get();
    $filterd_users = $users->filter(function($value, $key){
        return $value->name !== Auth::user()->name;
    });
    
    foreach($filterd_users as $filterd_user){
      $amounts = $amount->where('lend_provider_user_id', $filterd_user->id)->get();
      array_push($amount, $amounts);
    }
    
   // dd($user_name);
    
     return response([
         'amount'    => $amount,
         'user_name' => $user_name,
         ]);
   }
   //ログインしているユーザーと同じユーザーのあマウントを持ってくる
   
   
   public function delete(Request $request){
       $id = $request->id;
       $amount = new Amount;
       $amount_content = $amount->where('id', $id)->first();
       $amount_content->delete();
       return redirect('/home');
   }
   
   public function divide($groupName, Request $request, Amount $amount){
      $selectUsers = $request->users;

     // dd($user_names);
      $setAmount = $request->amount;
      $answer = $setAmount / count($selectUsers);
      foreach($selectUsers as $selectUser){
          $user = new User;
          $user_id = $user->where('name', $selectUser['name'])->value('id');

          
          $amount->amount = $answer;
          
          $amount->lend_provider_user_id = Auth::user()->id;
          
          $amount->borrow_provider_user_id = $user_id;
          
          $amount->groupId = $groupName;
          
          $amount->payed = 0;
          
          $amount->content = "割り勘";
          
          $amount->save();
      }
   }
}
