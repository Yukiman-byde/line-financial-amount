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
use App\Group;

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
                //   $response = $this->replyTextMessage($bot, $event->getReplyToken(), 'どなたの立替を行なったか下記のボタンで指名してください');
                   $response = $this->alternative_pay_action($event);
                   break;
                   
               case '割り勘で！':
                   $response = $this->replyTextMessage($bot, $event->getReplyToken(), 'fofofofo');
                   break;
                   
               case '登録':
                   $response = $this->groupstore($bot, $event->getReplyToken(), $event);
                   break;
               
               case 'LINE登録':
                    $template = array('type'    => 'buttons',
                  'thumbnailImageUrl' => 'https://d1f5hsy4d47upe.cloudfront.net/79/79e452da8d3a9ccaf899814db5de9b76_t.jpeg',
                  'title'   => 'LINE登録' ,
                  'text'    => 'ご利用になる前に、下記のWebで登録するボタンを押してLINE登録を行ってください。',
                  'actions' => array(
                                 array('type'=>'uri', 'label'=>'Webで登録する', 'uri'=>'https://amount-money.herokuapp.com/' )
                                )
                );
                   $response = $this->curl_Basic($event, $template);
                   break;
                
               case '結果を見る':
                   $response = $this->replyTextMessage($bot, $event->getReplyToken(), 'こちらが結果になります');
                   break;
               case $event->getPostbackData() !== null:
                   $response = $this->replyTextMessage($bot, $event->getReplyToken(), 'います');
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
    
    //こちゃで送りたいためユーザーで判断。
    //ユーザーが所属しているグループを抜き出す（登録ずみ）。
    //グループを選んでもらった後ユーザーも同じ内容で選んでもらう。
    public function alternative_pay_action($event){
        // $group_id = $event->getGroupId();
        // $group = new Group;
        // $group = $group->where('groupID', $group_id)->first();
        // $members = $group->users()->get();
        // $columns = array();
        
        $user_id = $event->getUserId();
        $user = new User;
        $user = $user->where('provided_user_id', $user_id)->first();
        $members = $user->groups()->get();
        
        foreach($members as $member){
          $carousel = array('thumbnailImageUrl' => $member->avatar,
                      'title'   => $member->name,
                      'text'    => '立替した人を確認できたら下記の「指名する」ボタンを押してください。',
                      'actions' => array(array('type' => 'postback', 'label' => '指名する', 'data' => $member->provided_user_id, 'text' => '送りました')) 
                 );
        array_push($columns, $carousel);
        }
        $template = array('type'    => 'carousel',
                  'columns' => $columns,
                );
        $this->curl_Basic($event, $template);
    }

    public function curl_Basic($event, $template){
                $raw = file_get_contents('php://input');
                $receive = json_decode($raw, true);
         
                $reply_token  = $event->getReplyToken();
                
                $headers = array('Content-Type: application/json',
                                 'Authorization: Bearer ' . config('services.line.channel_token'));
                                 
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
    
    public function retrive_chars(){
        $event = 'ゆーき万　１００円';
        [$target_name, $money] = explode('　', trim($event));
        dd($money);
        
    }
    
    public function try_session_data(){
        $name = 'ゆーき万';
        $user = new User;
        $user = $user->where('name', $name)->first();
        if($user){
            session_start();
            $_SESSION['amount'] = 600;
            $_SESSION['lend_name'] = $user->name;
            $_SESSION['borrow_name'] = 'うんこ';
            $_SESSION['payed'] = false;
            $_SESSION['content'] = 'トイレ代';
        }
        echo $_SESSION['borrow_name'];
    }
    
    public function try_session_data_amount($number){
        $user = new User;
      //  $user = $user->where('name', 'ゆーき万')->first();
        $user = $user->where('name', 'ゆーき万')->first();
       $group = $user->groups()->get();
       dd($group);
        if($number){
            session_start();
            $_SESSION['amount'] = $number;
            echo $_SESSION['amount'];
            echo $_SESSION['borrow_name'];
        }
        
    }
}

