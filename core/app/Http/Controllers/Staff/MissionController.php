<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Type;
use DNS1D;
use App\Models\CourierInfo;
use App\Models\AdminNotification;
use Carbon\Carbon;
use App\Models\CourierProduct;
use App\Models\CourierPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use App\Models\Sender;
use App\Models\Rdv;
use App\Models\User;
use App\Models\RdvPayment;
use App\Models\RdvProduct;
use App\Models\Mission;
use App\Models\MissionsRdvs;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Staff\SmsController;


//sms infobip
// //use GuzzleHttp\Client;
// use Infobip\Api\SendSmsApi;
// use Infobip\Configuration;
// use Infobip\Model\SmsAdvancedTextualRequest;
// use Infobip\Model\SmsDestination;
// use Infobip\Model\SmsTextualMessage;



class MissionController extends Controller
{
   public function index(){
      $pageTitle = "Programmes";
      $emptyMessage = "No data found";
      $user = Auth::user();
     //$missions=Mission::orderBy('created_at','DESC')->with('chauffeur','chargeur','rdvs')->paginate(getPaginate());
    $missions=Mission::orderBy('created_at', 'DESC')->with('chauffeur','chargeur','rdvs','rdvs.paymentInfo')->paginate(getPaginate());
         
        

         return view('staff.missions.index', compact('pageTitle','missions','emptyMessage'));
      }
      public function create(){
         $pageTitle = "Creer Programme Pour Chauffeur";
         $chauffeur =User::where('user_type','!=','staff')->where('user_type','!=','manager')->get();
         $chargeur =User::where('user_type','!=','staff')->where('user_type','!=','manager')->get();
         return view('staff.missions.create', compact('pageTitle','chauffeur','chargeur'));
      }
      public function edit_mission($id){
         $pageTitle = "Modifier Programme ";
         $chauffeur =User::where('user_type','!=','staff')->where('user_type','!=','manager')->get();
         $chargeur =User::where('user_type','!=','staff')->where('user_type','!=','manager')->get();
         $mission=Mission::where('idmission',decrypt($id))->first();
        // dd($mission);
         return view('staff.missions.update_mission', compact('pageTitle','chauffeur','chargeur','mission'));
      }
      public function update_mission(Request $request){
         
         $admin = Auth::user();
         $mission=Mission::where('idmission',$request->idmission)->first();
        // dd($mission);
         $mission->date=date("Y-m-d", strtotime($request->date));
         $mission->chauffeur_idchauffeur=$request->id_chauffeur;
         $mission->camion =$request->camion;
         $mission->contact=$request->contact;
         $mission->chargeur_idchargeur=$request->id_chargeur;
         if($request->message != ''){
            $mission->missioncol=$request->message;
         }else{ $mission->missioncol='';}
         
         $mission->user_id=$admin->id;
         $mission->save();

         if($mission){
            activity('Programme edité ')
            ->performedOn($mission)
            ->causedBy($admin)
            ->withProperties(['customProperty' => 'customValue'])
            ->log('Programme edité  par ' . $admin->username);
         }
         
         $notify[]=['success','Programme Modifié avec succès'];
         return redirect()->route('staff.mission.index', encrypt($mission->idmission))->withNotify($notify);
      }
      public function store(Request $request){
         $request->validate([
            'contact'=>'required|max:10',
            'id_chauffeur'=>'required',
            'id_chargeur'=>'required'
         ]);
            
         $admin = Auth::user();
         $mission=new Mission();
         $mission->date=$request->date;
         if($request->id_chauffeur != 0){
            $mission->chauffeur_idchauffeur=$request->id_chauffeur;
         }else{
            $mission->chauffeur_idchauffeur= '1';
         }
         $mission->camion =$request->camion;
         $mission->contact=$request->contact;
         if($request->id_chargeur != 0){
            $mission->chargeur_idchargeur=$request->id_chargeur;
         }else{
            $mission->chargeur_idchargeur='1';
         }
         if($request->message != ''){
            $mission->missioncol=$request->message;
         }else{ $mission->missioncol='';}
         
         $mission->user_id=$admin->id;
         $mission->save();

         if($mission){
            activity('programme')
            ->performedOn($mission)
            ->causedBy($admin)
            //->withProperties(['customProperty' => 'customValue'])
            ->log('Programme créé par ' . $admin->username);
            $notify[]=['success','Programme Créé avec succès'];
         }
        
         return redirect()->route('staff.mission.index', encrypt($mission->idmission))->withNotify($notify);
      }
      //assigner Programme a chauffeur
      public function createassigne($id){
         
         $emptyMessage = "Aucun Rdv";
         $mission=Mission::findOrFail(decrypt($id));
         /*
         $rdv_dispo=Rdv::with('rdvDetail')
              ->join('rdv_payments','rdvs.idrdv','=','rdv_payments.rdv_id')
              ->join('rdv_products','rdvs.idrdv','=','rdv_products.rdv_idrdv')
              ->join('clients','rdvs.sender_idsender','=','clients.id')
              ->join('rdv_adresse','rdvs.sender_idsender','=','rdv_adresse.client_id')
              ->select('rdvs.idrdv','rdvs.date','rdv_adresse.code_postal','rdv_adresse.adresse','clients.contact')
              ->where('rdvs.status','0')
              ->where('rdvs.deleted_at',NULL)
              ->orderBy('rdv_adresse.code_postal','desc')
              ->orderBy('rdvs.date','asc')
              ->paginate(getPaginate());
      */
      $rdv_dispo = Rdv::with(['rdvDetail', 'client', 'adresse'])
                        ->where('status', '0')
                        ->whereNull('deleted_at')
                        ->orderBy('date', 'asc')
                        ->paginate(getPaginate());

         
         // $rdv_dispo=Rdv::where('status',0)->with('paymentInfo','rdvDetail')->with('client')->with(['adresse' => function($query) {
         //    $query->orderBy('code_postal', 'desc');
         // }])->orderBy('date', 'ASC')->paginate(getPaginate());
         $pageTitle = "Assigner rdv à Programme du ".date('d-m-Y', strtotime($mission->date))."- Chauffeur : ".$mission->chauffeur->firstname;
         // dd($rdv_dispo);
         return view('staff.missions.create_mission', compact('pageTitle','rdv_dispo','mission','emptyMessage'));
         
      }
      
      public function getCreateAssign($id)
      {
         $mission=Mission::findOrFail(decrypt($id));
         $idmission=$mission->idmission;
         $chauffeur=$mission->chauffeur_idchauffeur;
         $rdvs=Rdv::with('rdvDetail')
         ->join('rdv_payments','rdvs.idrdv','=','rdv_payments.rdv_id')
         ->join('rdv_products','rdvs.idrdv','=','rdv_products.rdv_idrdv')
         ->join('clients','rdvs.sender_idsender','=','clients.id')
         ->join('rdv_adresse','rdvs.sender_idsender','=','rdv_adresse.client_id')
         ->select('rdvs.idrdv','rdvs.date','rdv_adresse.code_postal','rdv_adresse.adresse','clients.contact')
         ->where('rdvs.status','0')
         ->where('rdvs.deleted_at',NULL);

         return Datatables::of($rdvs)
         ->addColumn('action', function ($rdv){
            return '<a href="javascript:void(0)"  class="icon-btn btn--primary ml-1 editBrach"
            data-idrdv="'.$rdv->idrdv.'}}"
          ><i class="las la-edit"></i></a>';

         });

      }
      
      public function storerdv(Request $request){
         $user = Auth::user();
         try{
            $rdv=Rdv::find($request->idrdv);
            $rdv->status='2';
            $rdv->mission_id =$request->idmission;
            $rdv->save();

            if($rdv){
               activity('assignation rdv à programme')
                  ->performedOn($rdv)
                  ->causedBy($user)
                  //->withProperties(['customProperty' => 'customValue'])
                  ->log('Rdv assigné au programme '.$request->idmission.' par ' . $user->username);
            }
            // $rdv_Programme = DB::INSERT("INSERT INTO `missions_rdvs`(`mission_idmission`, `rdv_idrdv`) VALUES ('$request->idmission','$request->idrdv')");
            $notify[] = ['success', 'Rdv Ajouté'];
            return back()->withNotify($notify);
         } catch (Throwable $e) {
            report($e);
            
            return false;
         }
      }
      public function detailmission($id){
         $pageTitle = "Details Programme Chauffeur";
         $emptyMessage = "Aucun Rdv";
         $mission=Mission::findOrFail(decrypt($id));
         //dd($mission->idmission);
         $rdv_chauf=Rdv::with('client','adresse','transfert','depot','paymentInfo')->where('mission_id',$mission->idmission)->where('status','>=','2')->orderBy('order_list','ASC')->get();
      //    $rdv_chauf=Rdv::with('rdvDetail','rdvDetail.type')
      // ->join('rdv_payments','rdvs.idrdv','=','rdv_payments.rdv_id')
      // ->join('rdv_products','rdvs.idrdv','=','rdv_products.rdv_idrdv')
      // ->join('clients','rdvs.sender_idsender','=','clients.id')
      // ->join('rdv_adresse','rdvs.sender_idsender','=','rdv_adresse.client_id')
      // ->select('rdvs.idrdv','rdvs.date','rdv_adresse.code_postal','rdv_adresse.adresse','clients.contact','clients.nom')
      // ->where('rdvs.status','2')
      // ->where('rdvs.mission_id', $mission->idmission)
      // ->where('rdvs.deleted_at',NULL)
      // ->orderBy('rdv_adresse.code_postal','desc')
      // ->paginate(getPaginate());
         $pageTitle = "Details Programme du ".date('d-m-Y', strtotime($mission->date))." - Chauffeur : ".$mission->chauffeur->firstname." - Chargeur: ".$mission->chargeur->firstname." ".$mission->contact;
         return view('staff.missions.details_mission', compact('pageTitle','rdv_chauf','mission','emptyMessage'));
         
         
      }
      public function detailmissionend($id){
         $pageTitle = "Details Programme Terminé";
         $emptyMessage = "Aucun Rdv";
         $mission=Mission::where('status',1)->findOrFail(decrypt($id));
         //dd($mission->idmission);
         $rdv_chauf=Rdv::with('client','adresse','transfert','depot','transfert.paymentInfo')->where('mission_id',$mission->idmission)->where('status','>=','2')->orderBy('date','ASC')->paginate(getPaginate());
         
         $pageTitle = "Details Programme terminé du ".date('d-m-Y', strtotime($mission->date))." - Chauffeur : ".$mission->chauffeur->firstname;
         return view('staff.missions.details_mission_end', compact('pageTitle','rdv_chauf','mission','emptyMessage'));
         
         
      }
      public function print_mission($id){
         $mission=Mission::findOrFail(decrypt($id));
      //    $rdv_chauf=Rdv::with('rdvDetail','rdvDetail.type')
      // ->join('rdv_payments','rdvs.idrdv','=','rdv_payments.rdv_id')
      // ->join('rdv_products','rdvs.idrdv','=','rdv_products.rdv_idrdv')
      // ->join('clients','rdvs.sender_idsender','=','clients.id')
      // ->join('rdv_adresse','rdvs.sender_idsender','=','rdv_adresse.client_id')
      // ->select('rdvs.idrdv','rdvs.date','rdv_adresse.code_postal','rdv_adresse.adresse','clients.contact')
      // ->where('rdvs.status','2')
      // ->where('rdvs.mission_id', $mission->idmission)
      // ->where('rdvs.deleted_at',NULL)
      // ->orderBy('rdvs.order_list','asc')
      // ->get();
         $rdv_chauf=Rdv::with('client','rdvDetail','rdvDetail.type','adresse','client.adresse')->where('mission_id',$mission->idmission)->where('status','2')->orderBy('order_list','asc')->get();
         
            return view('staff.missions.print_mission_list', compact('rdv_chauf','mission'));
         }
         public function getdetailMission(){
            
         }
         public function storerdvmulti(Request $request){
            $user = Auth::user();
            try{
               // $i= 0;
               // $data=array();
               // $rdv=array();
               for($i =0 ; $i < count($request->ids) ;$i++ )
               {
                  $rdv=Rdv::find($request->ids[$i]);
                  //$rdvs=DB::UPDATE("UPDATE `rdvs` SET `status`=1,`user_id`=[value-5],`chauf_id`=$request->idchauf WHERE `idrdv`='$request->ids[$i]'")
                  $rdv->status='2';
                  $rdv->mission_id =$request->idmission;
                  $rdv->save();
                  
                  activity('assignation rdv à programme')
                  ->performedOn($rdv)
                  ->causedBy($user)
                  //->withProperties(['customProperty' => 'customValue'])
                  ->log('Rdv assigné au programme '.$request->idmission.' par ' . $user->username);
               }
               // $i++;
               
               $notify[] = ['success', 'Rdv Liste Ajoutée'];
               return back()->withNotify($notify);
            } catch (Throwable $e) {
               report($e);
               
               return false;
            }
            
            
         }
         public function validatemission($id){
            $pageTitle = "Valider Rdv";
            $emptyMessage = "Aucun Rdv";
            $admin = Auth::user();
            $branchs = Branch::where('status', 1)->where('id','!=',$admin->branch_id)->latest()->get();
            $types = Type::where('status', 1)->with('unit')->latest()->get();
            $courierInfo=Rdv::with('client','adresse')->findOrFail(decrypt($id));
            
            //dd($courierInfo);
            return view('staff.missions.validate_mission2', compact('pageTitle','branchs','types','courierInfo','emptyMessage'));
            
         }
         //terminé mission
         public function EndMission(Request $request){
            //dd($request);
            $mission=Mission::find($request->code);
            $mission->status='1';
            $mission->save();
            $notify[] = ['success', 'Programme Terminé'];
            return back()->withNotify($notify);
            
         }
          //rouvrir mission
          public function reOpenMission(Request $request){
            //dd($request);
            $mission=Mission::find($request->code);
            $mission->status='0';
            $mission->save();
            $notify[] = ['success', 'Programme Reouvert'];
            return back()->withNotify($notify);
            
         }
         public function getAutocomplete(Request $request){
            //dd($request);
            $search = $request->search;
            if($search == ''){
               $autocomplate = Sender::orderby('nom','asc')->select('idsender','nom')->limit(5)->get();
            }else{
               $autocomplate = Sender::orderby('nom','asc')->select('idsender','nom')->where('nom', 'like', '%' .$search . '%')->limit(5)->get();
            }
            $response = array();
            foreach($autocomplate as $autocomplate){
               $response[] = array("value"=>$autocomplate->id,"label"=>$autocomplate->name);
            }
            echo json_encode($response);
            exit;
            
         }
         function fetch(Request $request)
         {
            if($request->get('query'))
            {
               $query = $request->get('query');
               $data = DB::table('client')
               ->where('nom', 'LIKE', "%{$query}%")
               ->orWhere('contact','LIKE',"%{$query}%")
               ->get();
               $output = '<ul style="display:inline; position:relative">';
               foreach($data as $row)
               {
                  $output .= '
                  <li><a href="#">'.$row->nom.' '.$row->contact.'</a></li>
                  ';
               }
               $output .= '</ul>';
               echo $output;
            }
         }
         public function autocomplete(Request $request)
         
         {
            
            $data = Sender::select("nom","contact")
            ->where("nom","LIKE","%{$request->query}%")
            ->orWhere('contact',"%{$request->query}%")
            ->get();
            $c = Sender::leftJoin('rdvs', function($join) {
               $join->on('sender.idsender', '=', 'rdvs.sender-idsender');
            })
            ->where("sender.nom","LIKE","%{$request->query}%")
            ->orWhere('sender.contact',"LIKE","%{$request->query}%")
            ->where('rdvs.status',"0")
            ->first([
               'sender.nom',
               'sender.contact'
               ])->get();
               
               return response()->json($c);
               
            }

            public function getType(Request $request){
               $types = Type::where('status', 1)->where('cat_id',$request->id)->with('unit')->latest()->get();
               
               $output = '<option value=""> Choisir </option>';
               foreach($types as $row)
               {
                  $output .= '<option   value="'.$row->id.'"  data-price='.round($row->price,2).' > '.$row->name.'</option>';
               }
             
               return $output;
            }

            public function selectSearch(Request $request)
            {
               $types = [];

               if($request->has('q')){
                     $search = $request->q;
                     $movies =Type::select("id", "name")
                           ->where('name', 'LIKE', "%$search%")
                           ->get();
               }
               return response()->json($types);
            }
            
            public function store_chauffeur(Request $request){
               $manager = Auth::user();
               $request->validate([
                   'fname' => 'required|max:40',
                   'lname' => 'required|max:40',
                   //'email' => 'required|email|max:40|unique:users',
                   //'username' => 'required|max:40|unique:users',
                   'mobile' => 'required|max:40|unique:users',
                  // 'password' =>'required|confirmed|min:4',
               ]);
               $password='123456';
               $staff = new User();
               $staff->branch_id = $manager->branch_id;
               $staff->firstname = $request->fname;
               $staff->lastname = $request->lname;
               $staff->username = $request->lname;
               $staff->email = 'ch@ch.mail';
               $staff->mobile = $request->mobile;
               $staff->user_type = "chauffeur";
               $staff->password  = Hash::make($password);
               $staff->status = '1';
               $staff->save();

               if($staff){
                  $notify[] = ['success', 'Nouveau Chauffeur Ajouté!'];
                   return back()->withNotify($notify);
               }
            }
            
            public function delete_mission(Request $request){

               $mission=Mission::where('idmission',$request->idmission)->delete();
               $notify[] = ['success', 'Programme Supprimé!'];
               return back()->withNotify($notify);
            }
            public function sendProgramme(Request $request)
            {
               $request->validate([
                  'idmission' => 'required',
                  'message'=>'required|string|max:160'
                  ]);
               $user = Auth::user();
               $recipient = "";
               $nbContact = 0;
               $nbsms = 1;
               $message=$request->message;
               $messager=addslashes($request->message);

               $date = date('Y-m-d');   


               $idmission=decrypt($request->idmission);
               $rdv_id= 'R_'.$idmission;
         
               $rdv_info = RDV::where('mission_id', decrypt($request->idmission))->where('status','2')->where('deleted_at',NULL)->get();

               $envoi_sms= DB::INSERT("INSERT INTO `sms`(`date`, `rdv_cont`, `message`, `user_id`,`agence_id`) VALUES ('$date','$rdv_id','$messager','$user->id','$user->branch_id')");
              
               for ($i = 0; $i < count($rdv_info); $i++) {
                  $client = preg_replace("/[^0-9]/", "",$rdv_info[$i]->client->contact);
                 
                  if ((strlen($client) > 9) && (!preg_match("/xx/i", "$client")) && (!preg_match("/0000/i", "$client"))) {
                     $recipient ="0033" . substr($client, -9) ;
                     //$nbContact++;
                  }
                    
                  $chargeur = $request->contact;
                  $idmission=decrypt($request->idmission);
                  $idrdv=$rdv_info[$i]->code;
                  $verifier=DB::SELECT("select * from sms_envoi where rdv_id ='$idrdv' ");
/*                  if(strlen($recipient) == 13 && !$verifier && !empty($chargeur)){

 */             
                  if(strlen($recipient) == 13 ){    
                     $controller= new SmsController;
                     $controller->sendSms($recipient,$message,$idmission,$rdv_id);
                    }
                
               }
               $notify[] = ['success', 'Sms Envoyé aux clients!'];
               return back()->withNotify($notify);
            }
           
            public function order_list(Request $request){
               //
           // dd($request);
               $user=Auth::user();
               $rdvs = Rdv::all();
               foreach ($rdvs as $post) {
                   foreach ($request->order as $order) {
                     // dd($order);
                       if ($order['id'] == $post->idrdv) {   
                        // $rdvs->order_list = $order['position'];
                        // $rdvs->save();
                        $position=$order['position'];
                        $rdv= DB::UPDATE("UPDATE `rdvs` SET `order_list`= $position WHERE `idrdv` = $post->idrdv");   
                        
                       
                       }
                   }
               }
             
               return response('Update Successfully.', 200);
       
            }


//    function sendSms($client, $message,$idmission,$idrdv){
//       $BASE_URL = "https://gygyrw.api.infobip.com";
//       $API_KEY = "53ac56146d9ddda8f3396fb303fe5101-27968279-6a9d-4962-83a2-562d37ac649c";

// $SENDER = "CHALLENGE TRANSIT";
// $RECIPIENT =$client;
// $MESSAGE_TEXT = $message;
 
// $configuration = (new Configuration())
//     ->setHost($BASE_URL)
//     ->setApiKeyPrefix('Authorization', 'App')
//     ->setApiKey('Authorization', $API_KEY);
 
// $client = new Client();
 
// $sendSmsApi = new SendSMSApi($client, $configuration);
// $destination = (new SmsDestination())->setTo($RECIPIENT);
// $message = (new SmsTextualMessage())
//     ->setFrom($SENDER)
//     ->setText($MESSAGE_TEXT)
//     ->setDestinations([$destination]);
 
// $request = (new SmsAdvancedTextualRequest())->setMessages([$message]);
 
// try {
//     $smsResponse = $sendSmsApi->sendSmsMessage($request);

//     //echo ("Response body: " . $smsResponse);
// } catch (Throwable $apiException) {
//    // echo("HTTP Code: " . $apiException->getCode() . "\n");
//    }
//    return;
//    }


         }