<?php
namespace App\Http\Controllers;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;
use App\Models\User;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\Constant\HTTPHeader;

use Illuminate\Http\Request;

class LineMessengerController extends Controller
{
    public function webhook(Request $request) {
        //LINEから送られた内容を$inputsに代入
        $signature = $request->headers->get(HTTPHeader::LINE_SIGNATURE);
        
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(config('services.line.channel_token'));
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env('LINE_MESSENGER_SECRET')]);
     
        $events = $bot->parseEventRequest($request->getContent(), $signature);
        
        foreach($events as $event){
            $replyToken = $event->getReplyToken();
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('あれ？');
            $response=$bot->replyMessage('https://linetestapiwebhook.free.beeceptor.com', $textMessageBuilder);
        }
        
        echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
    }
    
    public function message(){
        $line_id = config('services.line.line_user');
        $channel_token = config('services.line.channel_token');
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($channel_token);
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env('LINE_MESSENGER_SECRET')]);
       // dd($bot);
       // $textMessageBuilder = new TextMessageBuilder('ヤッホー');
        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('ehe？');
        $response = $bot->pushMessage($line_id, $textMessageBuilder);
        
        echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
    }
}
