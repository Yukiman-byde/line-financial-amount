<?php
namespace App\Http\Controllers;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;
use App\User;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\SignatureValidator;
use Illuminate\Http\Request;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\TemplateMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use Exception;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use App\Group;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;

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
                   
               case '登録':
                   $response = $this->groupstore($bot, $event->getReplyToken(), $event);
                   break;
               
               case '試し':
                   $response = $this->curl_Basic($event);
                   break;
                
               case '結果を見る':
                   $response = $this->replyTextMessage($bot, $event->getReplyToken(), 'こちらが結果になります');
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
       $group_id = $event->getGroupId();
       $res = $bot->getGroupSummary($group_id);
       $data = $res->getJSONDecodedBody();
       $name = $data['groupName'];
       $pictureUrl = $data['pictureUrl'];
       $id_of_group = $data['groupId'];
       $user_id = $event->getUserId();

      $group = new Group;
      $group->store($name, $pictureUrl, $id_of_group);
      $attach_group = $group->where('groupID', $group_id)->first();
      if($attach_group){
          $user = new User;
          $attach_user = $user->where('provided_user_id', $user_id)->first();
          $attach_user->groups()->attach($attach_group->id);
      }
    }

    public function curl_Basic($event){
                $raw = file_get_contents('php://input');
                $receive = json_decode($raw, true);
         
                $reply_token  = $event->getReplyToken();
                
                $headers = array('Content-Type: application/json',
                                 'Authorization: Bearer ' . config('services.line.channel_token'));
                                 
                $template = array('type'    => 'buttons',
                  'thumbnailImageUrl' => 'https://d1f5hsy4d47upe.cloudfront.net/79/79e452da8d3a9ccaf899814db5de9b76_t.jpeg',
                  'title'   => 'タイトル最大40文字' ,
                  'text'    => 'テキストメッセージ。タイトルがないときは最大160文字、タイトルがあるときは最大60文字',
                  'actions' => array(
                                 array('type'=>'message', 'label'=>'ラベルです', 'text'=>'アクションを実行した時に送信されるメッセージ' )
                                )
                );

                $message = array('type'     => 'template',
                                 'altText'  => '代替テキスト',
                                 'template' => $template
                                );
                
                $body = json_encode(array('replyToken' => $reply_token,
                                          'messages'   => array($message)));
                                          
                $options = array(CURLOPT_URL            => 'https://api.line.me/v2/bot/message/reply',
                                 CURLOPT_CUSTOMREQUEST  => 'POST',
                                 CURLOPT_RETURNTRANSFER => true,
                                 CURLOPT_HTTPHEADER     => $headers,
                                 CURLOPT_POSTFIELDS     => $body);
                
                $curl = curl_init();
                curl_setopt_array($curl, $options);
                curl_exec($curl);
                curl_close($curl);
    }
}

