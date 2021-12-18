<?php
namespace App\Http\Controllers;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;
use App\Models\User;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

use Illuminate\Http\Request;

class LineMessengerController extends Controller
{
    public function webhook(Request $request) {
        // LINEから送られた内容を$inputsに代入
        $reply_token = $request['events']['replyToken'];
        $channel_token = config('services.line.channel_token');
        $line_id = config('services.line.line_user');
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($channel_token);
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env('LINE_MESSENGER_SECRET')]);
        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('あれ？');
        $response=$bot->replyMessage($reply_token, $textMessageBuilder);
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
