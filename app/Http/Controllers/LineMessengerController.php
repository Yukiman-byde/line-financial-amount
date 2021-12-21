<?php
namespace App\Http\Controllers;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;
use App\Models\User;
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
use App\Http\Controllers\Controller;


class LineMessengerController extends Controller
{
    public function webhook(Request $request, Group $group) {
         $group = Group::create([
                          'name'        => 'wahaha',
                          'groupID'     => 293259348,
                          'pictureUrl' => 'shfeoijrcuhsx',
                          ]);
          return 'ok';
        $groupId = $group->groupID;
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(config('services.line.channel_token'));
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env('LINE_MESSENGER_SECRET')]);
        $signature = $request->headers->get(HTTPHeader::LINE_SIGNATURE);

        // if (!SignatureValidator::validateSignature($request->getContent(), env('LINE_MESSENGER_SECRET'), $signature)) {
        //     // TODO 不正アクセス
        //     return ;
        // }
        
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(config('services.line.channel_token'));
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env('LINE_MESSENGER_SECRET')]);
    
        //$events = $bot->parseEventRequest($request->getContent(), $signature);

        foreach($events as $event){
         $response = $this->replyTextMessage($bot, $event->getReplyToken(), 'データ完了！');
          return ' 200,OK' ;     
            // $data = $res->getJSONDecodedBody();
            // $this->assertEquals('Group name', $data['groupName']);
            //$data = $res->getJSONDecodedBody();
            
           //実際の措置 
           switch(strval($event->getText())){
               case '特定の人へ！':
                   $response = $this->replyTextMessage($bot, $event->getReplyToken(), 'どなたの立替を行なったか下記のボタンで指名してください');
                   break;
                   
               case '割り勘で！':
                   $response = $this->replyTextMessage($bot, $event->getReplyToken(), 'fofofofo');
                   break;
                   
               case 'グループ':
                   $response = $this->fetchGroupData($bot, $event->getReplyToken(), $event);
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
      
      public function fetchGroupData($bot, $replyToken, $event){
           $group_id = $event->getGroupId();
           $res = $bot->getGroupSummary($group_id);
           $data = $res->getJSONDecodedBody();//dataにグループのデータを取得
           //$data['groupName']で出てきます。
          // $name = $data['groupName'];
           $group = Group::where('groupID', $group_id)->first();
           if($group === null){
               $response = $this->replyTextMessage($bot, $replyToken, 'データがありません');
           }
             echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
        
           }
}
