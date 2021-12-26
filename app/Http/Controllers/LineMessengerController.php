<?php
namespace App\Http\Controllers;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;
use LINE\LINEBot\Event\MessageEvent\MentioneeInfo;
use App\User;
use App\Http\Controllers\PDO;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\SignatureValidator;
use Illuminate\Http\Request;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\TemplateMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use Exception;
use App\Group;
use App\Http\Controllers\Calculate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class LineMessengerController extends Controller
{
    public function webhook(Request $request) {
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(config('services.line.channel_token'));
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env('LINE_MESSENGER_SECRET')]);
        $signature = $request->headers->get(HTTPHeader::LINE_SIGNATURE);

        if (!SignatureValidator::validateSignature($request->getContent(), env('LINE_MESSENGER_SECRET'), $signature)) {
            // 不正アクセス
            return ;
        }
    
        $events = $bot->parseEventRequest($request->getContent(), $signature);

        foreach($events as $event){
           //実際の措置 
           switch(strval($event->getText())){
               case '特定の人へ！':
                   $response = $this->replyTextMessage($bot, $event->getReplyToken(), 'どなたの立替を行なったか下記のボタンで指名してください');
                   break;
                   
               case '割り勘で！':
                   $response = $this->replyTextMessage($bot, $event->getReplyToken(), 'fofofofo');
                   break;
                   
               case 'グループ':
                   $response = $this->groupstore($bot, $event->getReplyToken(),$event);
                   break;
                   
               case '結果を見る':
                   $response = $this->replyTextMessage($bot, $event->getReplyToken(), 'こちらが結果になります');
                   break;
                   
               case $mentioneeInfo['userId']:
                   $response = $this->replyTextMessage($bot, $event->getReplyToken(), '成功したよ〜ん');
                   break;
                   
               default:
                   $response = $this->replyTextMessage($bot, $event->getReplyToken(), '申し訳ございません。メニューの方からの入力のみとなっておりますので、そちらからお願いします.');
                   break;
             }
           }
           
        echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
    }
    
     // シングルメッセージ 
      private function replyTextMessage($bot, $replyToken, $text){
          
        $message = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
        $response = $bot->replyMessage($replyToken,$message);
        
        if(!$response->isSucceeded()){
            error_log($response->getHTTPStatus. ' ' . $response->getRawBody());
          }
      }
           
    public function groupstore($bot, $replyToken, $event){
      //返信はビルダー通らなきゃだめ.
      //グループのデータはグループから送らないと返事がない
      //一つ一つのデータを変数に入れていく。
       $group_id = $event->getGroupId();
       $res = $bot->getGroupSummary($group_id);
       $data = $res->getJSONDecodedBody();
       $name = $data['groupName'];
       $pictureUrl = $data['pictureUrl'];
       $id_of_group = $data['groupId'];
       //どこで止まってるかがわからない
       //ビルダーに入れてLineチャットでも使えるようにしていく。
       //データ登録（グループ）
       $feedback = $this->dbStoreGroup($name, $pictureUrl, $id_of_group);
       //データ登録（ユーザー）
       $second_feedback = $this->storeUser($event, $bot, $group_id);
       //グループがなかったら新しく作る
    }
    
    public function dbStoreGroup($name, $pictureUrl, $id_of_group){
         $group = Group::where('name', strval($name))
                   ->where('groupID', strval($id_of_group))
                   ->first();
       if($group === null){
            $group = Group::create([
           //文字列化させないとはいらない。
           'name'     =>  strval($name),
           'groupID'  =>  strval($id_of_group),
           'pictureUrl'=> strval($pictureUrl),
           ]);  
       }
    }
    
    public function storeUser($event, $bot, $group_id){
         $user_id = $event->getUserId();
         $res = $bot->getGroupMemberProfile($group_id, $user_id);
         $data = $res->getJSONDecodedBody();
         $user_name = $data['displayName'];
         $user_picture = $data['pictureUrl'];
         $user = User::where('name', $user_name)->where('provided_user_id')->first();
         $message = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('すでに登録が完了しています');
        if($user === null){
            $user = User::create([
                'name' => strval($user_name),
                'provider' => 'line',
                'provided_user_id' => strval($user_id),
                'avatar' => strval($user_picture),
                'groupId' => strval($group_id),
                ]);
           $message = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('登録が完了されました');
           $response = $bot->replyMessage($replyToken, $message);
        }elseif($user){
            $response = $bot->replyMessage($replyToken, $message);
        }
    }
}

