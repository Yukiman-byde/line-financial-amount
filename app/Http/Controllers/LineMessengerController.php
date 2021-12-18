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
        return "200 ok";
        $inputs=$request->all();

        // そこからtypeをとりだし、$message_typeに代入
        $message_type=$inputs['events'][0]['type'];

        // メッセージが送られた場合、$message_typeは'message'となる。その場合処理実行。
        if($message_type=='message') {
            
            // replyTokenを取得
            $reply_token=$inputs['events'][0]['replyToken'];

            // LINEBOTSDKの設定
            $http_client = new CurlHTTPClient(config('services.line.channel_token'));
            $bot = new LINEBot($http_client, ['channelSecret' => config('services.line.messenger_secret')]);

            // 送信するメッセージの設定
            $reply_message='メッセージありがとうございます';

            // ユーザーにメッセージを返す
            $reply=$bot->replyText($reply_token, $reply_message);
            
            return 'ok';
        }
    }
}
