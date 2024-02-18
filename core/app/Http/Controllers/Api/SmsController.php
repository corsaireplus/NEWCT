<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch;
use App\Models\Sms;
use App\Models\SmsBip;
use App\Models\User; 

//sms infobip
use GuzzleHttp\Client;
use Infobip\Api\SendSmsApi;
use Infobip\Configuration;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;

class SmsController extends Controller{
    
    public function sendSms($client, $message,$idmission,$idrdv){
   $BASE_URL = "https://gygyrw.api.infobip.com";
  // $API_KEY = "53ac56146d9ddda8f3396fb303fe5101-27968279-6a9d-4962-83a2-562d37ac649c";
  
   $API_KEY="a1ddecc681d29d599a90064d618059e7-307e461c-ca90-43c8-8bc9-134da46039ab";
   $userInfo = User::where('id',$idrdv)->first();
            $client = "002250506703212";
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
         
}