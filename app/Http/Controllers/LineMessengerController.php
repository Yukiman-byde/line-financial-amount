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
use Exception;

class LineMessengerController extends Controller
{
    public function webhook(Request $request) {
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(config('services.line.channel_token'));
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env('LINE_MESSENGER_SECRET')]);
        $signature = $request->headers->get(HTTPHeader::LINE_SIGNATURE);

        if (!SignatureValidator::validateSignature($request->getContent(), env('LINE_MESSENGER_SECRET'), $signature)) {
            // TODO 不正アクセス
            return ;
        }
        
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(config('services.line.channel_token'));
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env('LINE_MESSENGER_SECRET')]);
    
        $events = $bot->parseEventRequest($request->getContent(), $signature);
        
        foreach($events as $event){
        //     if(strval($event->getText()) == '特定の人へ！'){
                
        //         $response = $this->replyTextMessage($bot, $event->getReplyToken(), 'どなたにチャージしますか？');
                
        //     }elseif(strval($event->getText()) == '割り勘で！'){
                
        //         $response = $this->replyTextMessage($bot, $event->getReplyToken(), '割り勘ですね！');
                
        //     } else {
                
        //         $response = $this->replyTextMessage($bot, $event->getReplyToken(), '申し訳ございません。メニューの方からの入力のみとなっておりますので、そちらからお願いします。');
        //         }
        //   }
           switch(strval($event->getText())){
               case '特定の人へ！':
                   $response = $this->replyTextMessage($bot, $event->getReplyToken(), 'どなたにチャージしますか？');
                   break;
                   
               case '割り勘で！':
                   $response = $this->replyTextMessage($bot, $event->getReplyToken(), '割り勘ですね!');
                   break;
                   
               default:
                   $response = $this->replyTextMessage($bot, $event->getReplyToken(), '申し訳ございません。メニューの方からの入力のみとなっておりますので、そちらからお願いします.');
                   break;
             }
           }
           
        echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
    }
    
     // 関数で呼び出したいけどうまく行ってないやつ  
      private function replyTextMessage($bot, $replyToken, $text){
        $message = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
        $response = $bot->replyMessage($replyToken,$message);
        
        if(!$response->isSucceeded()){
            error_log($response->getHTTPStatus. ' ' . $response->getRawBody());
          }
      }
}
