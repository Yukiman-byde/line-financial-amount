<?php
namespace App\Http\Controllers;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;
use App\Models\User;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
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
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('あれ？');
            $response=$bot->replyMessage($event->getReplyToken(), $textMessageBuilder);
           }
       // echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
    }
    
    public function message(){
        $line_id = config('services.line.line_user');
        $channel_token = config('services.line.channel_token');
     
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($channel_token);
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env('LINE_MESSENGER_SECRET')]);
        //dd($bot);
       // $textMessageBuilder = new TextMessageBuilder('ヤッホー');
        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('ehe？');
        $response = $bot->pushMessage($line_id, $textMessageBuilder);
        
        echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
      }
      
      public function richmenu(){
          $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('<channel access token>');
            $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '<channel secret>']);
            //$richMenuBuilder = new \LINE\LINEBot\RichMenuBuilder(...)
            //$response = $bot->createRichMenu($richMenuBuilder);
      }
}
