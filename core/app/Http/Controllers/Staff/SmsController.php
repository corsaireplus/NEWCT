<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch;
use App\Models\Sms;
use App\Models\SmsBip;

//sms infobip
use GuzzleHttp\Client;
use Infobip\Api\SendSmsApi;
use Infobip\Configuration;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;

class SmsController extends Controller{


public function index(Request $request){
    $pageTitle = "Sms rapport";
    $userInfo = Auth::user();
    $emptyMessage="Aucun Message";
    $sms=Sms::with('details','user')->orderBy('date','desc')->paginate(getPaginate());
    $smsrdv=DB::SELECT("SELECT COUNT(`sms_id`) as smsrdv FROM `sms_bip` WHERE `rd_ct` LIKE '%R%' AND MONTH(created_at) = MONTH(now()) AND YEAR(created_at) = YEAR(now())");
    $smscont=DB::SELECT("SELECT COUNT(`sms_id`) as smscont FROM `sms_bip` WHERE `rd_ct` LIKE '%C_%' AND `agence_id`= '1' AND MONTH(created_at) = MONTH(now()) AND YEAR(created_at) = YEAR(now())");
    $smscontAbj=DB::SELECT("SELECT COUNT(`sms_id`) as smsabj FROM `sms_bip` WHERE `rd_ct`  LIKE '%C_%' AND `agence_id`= '2' AND MONTH(created_at) = MONTH(now()) AND YEAR(created_at) = YEAR(now())");

   // dd($smsrdv);
    
    return view('staff.sms.index', compact('pageTitle','sms','smsrdv','smscont','smscontAbj', 'emptyMessage'));


}
 public function smsdashboard(Request $request){
   $smsrdv=SmsBip::count('sms_id')->where('rd_ct','LIKE','%R_%')->whereMonth('created_at', Carbon::now()->month)->get();
 }

public function details(Request $request){

}
function sendSms($client, $message,$idmission,$idrdv){
   $BASE_URL = "https://gygyrw.api.infobip.com";
  // $API_KEY = "53ac56146d9ddda8f3396fb303fe5101-27968279-6a9d-4962-83a2-562d37ac649c";
   $API_KEY="a1ddecc681d29d599a90064d618059e7-307e461c-ca90-43c8-8bc9-134da46039ab";
   $userInfo = Auth::user();

               $SENDER = "CHALLENGE TRANSIT";
               $RECIPIENT =$client;
               $MESSAGE_TEXT = $message;
               
               $configuration = (new Configuration())
                  ->setHost($BASE_URL)
                  ->setApiKeyPrefix('Authorization', 'App')
                  ->setApiKey('Authorization', $API_KEY);
               
               $client = new Client();
               
               $sendSmsApi = new SendSMSApi($client, $configuration);
               $destination = (new SmsDestination())->setTo($RECIPIENT);
               $message = (new SmsTextualMessage())
                  ->setFrom($SENDER)
                  ->setText($MESSAGE_TEXT)
                  ->setDestinations([$destination]);
               
               $request = (new SmsAdvancedTextualRequest())->setMessages([$message]);
               
               try {
                  $smsResponse = $sendSmsApi->sendSmsMessage($request);
                
                  if($smsResponse['messages'][0]['status']['name']){
                  $name=$smsResponse['messages'][0]['status']['name'];
                  $groupId=$smsResponse['messages'][0]['status']['groupId'];
                  $groupName=$smsResponse['messages'][0]['status']['groupName'];
                  $ids=$smsResponse['messages'][0]['status']['id'];
                  $sms_id=$smsResponse['messages'][0]['messageId'];
                  $rd_ct=$idrdv;
                  $agence_id=$userInfo->branch_id;
                  $numero=$smsResponse['messages'][0]['to'];
                  $sms_bip=DB::INSERT("INSERT INTO `sms_bip`(`numero`,`groupId`, `ids`, `groupName`, `name`, `sms_id`, `rd_ct`,`agence_id`) VALUES ('$numero','$groupId','$ids','$groupName','$name','$sms_id','$rd_ct','$agence_id')");
                 }
                  

                 // echo ("Response body: " . $smsResponse);
               } catch (Throwable $apiException) {
                  // echo("HTTP Code: " . $apiException->getCode() . "\n");
                  }
                return;
         }

         public function NewsendSms($client, $message,$idmission,$idrdv){

            

            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api-public-2.mtarget.fr/messages",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => "username=innoving&password=Mw80bTxWezDa&msisdn=002250759393911&msg=Message%20simple&sender=INFO",
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);
            
            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
              echo $response;
            // dd($response);
            }
            //"{"results": [{ "msisdn" :"002250759393911","smscount" :"1","code" :"0","reason" :"ACCEPTED","ticket" :"43d63160-2ee6-11ed-ad11-00000a148c01"}]}"
       }

 

}