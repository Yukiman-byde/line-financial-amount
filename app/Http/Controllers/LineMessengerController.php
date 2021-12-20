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
           switch(strval($event->getText())){
               case '特定の人へ！':
                   $response = $this->replyMultiMessage(
                        $bot, 
                        $event->getReplyToken(), 
                        '立替 - どなたの立替を行なったか下記のボタンで指名してください',
                        '立替',
                        'どなたの立替を行なったか下記のボタンで指名してください',
                        new MessageTemplateActionBuilder('まっさん', 'まっさん'),
                        new UriTemplateActionBuilder('Webで見る', 'https://www.youtube.com/results?search_query=messege+api+line+laravel'),
                        );
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
      
      private function replyMultiMessage($bot, $replyToken, $alternativeText, $title, $text, ...$actions){
          $actionArray = array();
          foreach($actions as $action){
              array_push($actionArray, $action);
          }
          $builder = new TemplateMessageBuilder(
              $alternativeText,
              new ButtonTemplateBuilder($title, $text),
              );
          
          $response = replyMessage($replyToken, $builder, $actio);
      }
}
