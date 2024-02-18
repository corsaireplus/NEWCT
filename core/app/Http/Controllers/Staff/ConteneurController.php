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
//use Yajra\DataTables\Facades\DataTables;
use App\Models\Sender;
use App\Models\Transfert;
use App\Models\User;
use App\Models\RdvPayment;
use App\Models\RdvProduct;
use App\Models\MissionsRdvs;
use App\Models\Container;
use App\Models\TransfertRef;
use App\Models\ContainerNbcolis;
use App\Models\Paiement;
use App\Models\TransfertPayment;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\Datatables\Datatables;

use App\Http\Controllers\Staff\SmsController;


//sms infobip
use GuzzleHttp\Client;
use Infobip\Api\SendSmsApi;
use Infobip\Configuration;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;

use App\Exports\PaiementExportMapping;
use App\Exports\ContainerNbcolisExportMapping;
use App\Exports\TransactionPaymentExportMapping;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Transaction;
class ConteneurController extends Controller
{
   public function index()
   {
      $pageTitle = "Liste des Conteneurs";
      $emptyMessage = "Aucun Conteneur";
      $admin = Auth::user();
      $missions = Container::dateFilter()
                            ->searchable(['numero','armateur'])
                            ->filter(['status'])
                            ->with('destination','envois')
                            ->where('desti_id', '!=', $admin->branch_id)
                            ->where('newold','1')
                            ->orderBy('date', 'desc')->paginate(getPaginate());
      return view('staff.container.index', compact('pageTitle', 'missions', 'emptyMessage'));
   }
   public function conteneureceive()
   {
      $pageTitle = "Liste des Conteneurs";
      $emptyMessage = "Aucun Conteneur";
      $admin = Auth::user();
      $missions = Container::dateFilter()
                            ->searchable(['numero','armateur'])
                            ->filter(['status'])
                            ->with('destination','envois')
                            ->where('desti_id',$admin->branch_id)
                            ->where('newold','1')
                            ->orderBy('date', 'desc')->paginate(getPaginate());
      return view('staff.containereceive.index', compact('pageTitle', 'missions', 'emptyMessage'));
   }

   public function create()
   {
      $pageTitle = "Ajouter Nouveau Conteneur";
      $admin = Auth::user();
      $branch = Branch::where('status', 1)->where('id', '!=', $admin->branch_id)->latest()->get();
      return view('staff.container.create', compact('pageTitle', 'branch'));
   }

   public function store(Request $request){
     // dd($request);
      $admin = Auth::user();
      $mission=new Container();
      $mission->date=date("Y-m-d", strtotime($request->date));
      $mission->desti_id=$request->desti_id;
      $mission->numero=$request->numero;
      $mission->armateur=$request->armateur;
      $mission->newold = 1;
      $mission->status = 0;
      $mission->date_arrivee=date("Y-m-d", strtotime($request->date_arrivee));
      if($request->message != ''){
        $mission->observation=$request->message;
      }else{ $mission->observation='';}
     
      $mission->user_id=$admin->id;
      $mission->save();
      $notify[]=['success','Conteneur Créé avec succès'];
      return redirect()->route('staff.conteneurs.index', encrypt($mission->idcontainer))->withNotify($notify);
   }

    public function assign($id)
   {
      $emptyMessage = "Aucun Colis";
      $mission = Container::findOrFail(decrypt($id));
       $colis_dispo = Transaction::dateFilter()->searchable(['reftrans'])
                                 ->where('ship_status','=',0)
                                 ->orWhere('ship_status','=',11)
                                 ->with('sender')->with('transfertDetail', function ($query){
                                        $query->where('status',0);
                                  })->orderBy('created_at', 'DESC')->paginate(getPaginate());

      $pageTitle = "Ajouter colis au Conteneur du " . date('d-m-Y', strtotime($mission->date)) . " - N°: " . $mission->numero;
      //dd($colis_dispo);
      return view('staff.container.assign', compact('pageTitle','mission', 'emptyMessage','colis_dispo'));
   }

   public function storeone(Request $request)
   {
      $request->validate([
         'nbcolis'=>'numeric|gt:0'
      ]);
      try {
         $check=ContainerNbcolis::where('container_id',$request->idmission)->where('id_transaction',$request->idrdv)->first();
         
         if($check){
            $notify[] = ['error', 'Colis dejà Ajouté au Conteneur'];
               return back()->withNotify($notify);
         }else{
                        $rdv = Transaction::find($request->idrdv);
                        $nb=$request->nbcolis;
                     
                        $count=TransfertRef::where('transaction_id',$request->idrdv)->count();

                     // dd($count);
                        if($count >= 2){
                           $refnum=Transaction::find($request->idrdv);
                              $trans=$refnum->reftrans;
                           // dd($trans);
                              $trans_ref =TransfertRef::where('transaction_id',$request->idrdv)->where('status',0)->first();
                              $ref=$trans_ref->ref_souche_part;
                           // dd($ref);
                              $lastChar = substr($ref, -1);
                              //dd($lastChar);
                              $int_value = (int) $lastChar;
                           for($i = 0; $i < $nb;$i++){
                           
                              $refer=$trans.'-'.($int_value + $i);
                              // dd($refer);
                              $update=TransfertRef::where('ref_souche_part',$refer)->update(array('status' => '1'));
                              
                  
                           }
                           $count=TransfertRef::where('transaction_id',$request->idrdv)->where('status',0)->count();
                           if($count > 0){
                              $rdv = Transaction::find($request->idrdv);
                              //dd($rdv);
                              $rdv->ship_status = '11';
                              $rdv->save();
                           }else{
                              $rdv = Transaction::find($request->idrdv);
                              //dd($rdv);
                              $rdv->ship_status = '1';
                              $rdv->save();
                           }
                           
                        }else{
                           $rdv = Transaction::find($request->idrdv);
                           //dd($rdv);
                           $rdv->ship_status = '1';
                           $rdv->save();
                           $update=TransfertRef::where('transaction_id',$request->idrdv)->update(array('status' => '1'));
                        }
                        $newold=ContainerNbcolis::where('id_transaction',$request->idrdv)->count();

                         if($newold > 0){
                        $newold = 2;
                         }else{
                        $newold = 1;
                        }


                        $manifest=new ContainerNbcolis();
                        $manifest->container_id =$request->idmission;
                        $manifest->id_transaction =$request->idrdv;
                        $manifest->newold =$newold;
                        $manifest->nb_colis =$request->nbcolis;
                        $manifest->save();
                        // $rdv_mission = DB::INSERT("INSERT INTO `missions_rdvs`(`mission_idmission`, `rdv_idrdv`) VALUES ('$request->idmission','$request->idrdv')");
                        $notify[] = ['success', 'Colis Ajouté au Conteneur'];
                        return back()->withNotify($notify);
                     }
      } catch (Throwable $e) {
         report($e);

         return false;
      }
   }

   public function storemulti(Request $request)
   {
      
    // dd($request);
      try {
         // $i= 0;
         // $data=array();
         // $rdv=array();
         $nb = count($request->ids);

        
         for ($i = 0; $i <= $nb; $i++)
         {

            $check=ContainerNbcolis::where('container_id',$request->idmission)->where('id_transaction',$request->ids[$i])->first();
         
            if($check)
            {
               $notify[] = ['error', 'Colis dejà Ajouté au Conteneur'];
            return back()->withNotify($notify);
            }elseif(isset($request->nbcolis[$i]) && $request->nbcolis[$i] != null)
            {
               $nb=$request->nbcolis[$i];
            
               $rdv = Transaction::find($request->ids[$i]);
               //compter le nombre de colis dans la table transfertRef 
               $count=TransfertRef::where('transaction_id',$request->ids[$i])->where('status',0)->count();

                        
                     // dd($count);
                     if($count >= 2){
                        //si le nombre de colis enregistre est superieur ou egal a 2
                           $refnum=Transaction::find($request->ids[$i]);
                           $trans=$refnum->reftrans;
                           // dd($trans);
                           $trans_ref =TransfertRef::where('transaction_id',$request->ids[$i])->where('status',0)->first();
                           // dd($trans_ref);
                           $ref=$trans_ref->ref_souche_part;
                           // dd($ref);
                           $lastChar = substr($ref, -1);
                           //dd($lastChar);
                           $int_value = (int) $lastChar;
                        for($a = 0; $a < $nb;$a++){
                        
                           $refer=$trans.'-'.($int_value + $a);
                           // dd($refer);
                           $update=TransfertRef::where('ref_souche_part',$refer)->update(array('status' => '1'));
                           
               
                        }
                        // $count=TransfertRef::where('transaction_id',$request->ids[$i])->where('status',0)->count();
                        $test =$count - $nb;
                        if($test > 0){
                           $rdv = Transaction::find($request->ids[$i]);
                           //dd($rdv);
                           $rdv->ship_status = '11';
                           $rdv->save();
                        }elseif($test == 0){
                           $rdv = Transaction::find($request->ids[$i]);
                           //dd($rdv);
                           $rdv->ship_status = '1';
                           $rdv->save();
                        }
                        
                     }else{
                        //sinon il s agit d un seul colis 
                        $rdv = Transaction::find($request->ids[$i]);
                        //dd($rdv);
                        $rdv->ship_status = '1';
                        $rdv->save();
                        $update=TransfertRef::where('transaction_id',$request->ids[$i])->update(array('status' => '1'));
                     }

                       $newold=ContainerNbcolis::where('id_transaction',$request->idrdv)->count();

                        if($newold > 0){
                        $newold = 2;
                         }else{
                        $newold = 1;
                        }


                        $manifest=new ContainerNbcolis();
                        $manifest->container_id =$request->idmission;
                        $manifest->id_transaction =$request->ids[$i];
                        $manifest->nb_colis =$request->nbcolis[$i];
                        $manifest->newold =$newold;
                        $manifest->save();
          
                  }else{
                     $notify[] = ['error', 'Ajoutez nombre de colis svp !!'];
                     return back()->withNotify($notify);
                  }
                  // $i++;

                 
         }
                 $notify[] = ['success', 'Liste Colis Ajoutée'];
                  return back()->withNotify($notify);
      } catch (Throwable $e) {
         report($e);

         return false;
      }
   }

   // DETAIL DU CONTENEUR CHARGE
   public function conteneurliste($id)
   {
      $pageTitle = "Details Colis du Conteneur";
      $emptyMessage = "Aucun Colis";
      $mission = Container::findOrFail(decrypt($id));
      $ct=$mission->idcontainer;

      $conteneur=ContainerNbcolis::where('container_id',decrypt($id))->where('newold',1)->with('transaction','transaction.paymentInfo','transaction.paiement')->get();

   // Initialisez les totaux
      $totalValeurColis = 0;
      $totalPaiements = 0;

     //// Parcourez chaque ContainerNbColis pour récupérer les transactions
      foreach ($conteneur as $containerNbColis) {
         // Récupérez la transaction liée à ce conteneur
         $transaction = $containerNbColis->transaction;

         // Vérifiez si la transaction existe
         if ($transaction) {
            // Ajoutez la valeur des colis de cette transaction au total
            $totalValeurColis += $transaction->paymentInfo()->sum('final_amount');

            // Ajoutez les paiements de cette transaction au total
            $totalPaiements += $transaction->paiement()->sum('sender_payer');
         }
      }
                
               $totalPartiel=0;
               
               $totalNonPaye=0;
            
               DB::enableQueryLog();
                $container_id=$ct;
               $rdv_chauf=ContainerNbcolis::where('container_id',$ct)->with('transaction','transaction','transaction.sender','transaction.transfertDetail','transaction.paymentInfo')->paginate(getPaginate());
               
               $pageTitle = "Details Conteneur du " . date('d-m-Y', strtotime($mission->date)) . " - Numero : " . $mission->numero;
      return view('staff.container.liste', compact('pageTitle', 'rdv_chauf', 'mission', 'emptyMessage','ct','totalValeurColis','totalPaiements','container_id'));
   }

    public function listereceive($id)
   {
      $pageTitle = "Details Colis du Conteneur";
      $emptyMessage = "Aucun Colis";
      $mission = Container::findOrFail(decrypt($id));
      $ct=$mission->idcontainer;

      $conteneur=ContainerNbcolis::where('container_id',decrypt($id))->where('newold',1)->with('transaction','transaction.paymentInfo','transaction.paiement')->get();

   // Initialisez les totaux
      $totalValeurColis = 0;
      $totalPaiements = 0;
      $totalAbidjan =0;

     //// Parcourez chaque ContainerNbColis pour récupérer les transactions
      foreach ($conteneur as $containerNbColis) {
         // Récupérez la transaction liée à ce conteneur
         $transaction = $containerNbColis->transaction;

         // Vérifiez si la transaction existe
         if ($transaction) {
            // Ajoutez la valeur des colis de cette transaction au total
            $totalValeurColis += $transaction->paymentInfo()->sum('receiver_amount');

            // Ajoutez les paiements de cette transaction au total
            $totalPaiements += $transaction->paiement()->sum('receiver_payer');
         }
      } 

             $Newconteneur=ContainerNbcolis::where('container_id',decrypt($id))->where('newold',1)->with('transaction','transaction.paymentInfo','transaction.paiement')->pluck('id_transaction');
              $totalAbidjan = Paiement::where('branch_id', 2)
               ->where('sender_branch_id', 1)
               ->whereIn('transaction_id', $Newconteneur)
               ->sum('receiver_payer');
                
               $totalPartiel=0;
               
               $totalNonPaye=0;
            
               DB::enableQueryLog();
                $container_id=$ct;
               $rdv_chauf=ContainerNbcolis::where('container_id',$ct)->with('transaction','transaction','transaction.sender','transaction.transfertDetail','transaction.paymentInfo')->paginate(getPaginate());
               
               $pageTitle = "Details Conteneur du " . date('d-m-Y', strtotime($mission->date)) . " - Numero : " . $mission->numero;
      return view('staff.container.listereceive', compact('pageTitle', 'rdv_chauf', 'mission', 'emptyMessage','ct','totalValeurColis','totalPaiements','container_id','totalAbidjan'));
   }
   // DETAIL DU CONTENEUR CHARGE
   public function listenonpaye($id)
   {
     
      $pageTitle = "Details Colis Non payé du Conteneur";
      $emptyMessage = "Aucun Colis";
      $mission = Container::findOrFail(decrypt($id));
      $ct=$mission->idcontainer;

      $container_id=$id;

      $rdv_chauf=ContainerNbcolis::where('container_id',$ct)->with('transaction','transaction','transaction.sender','transaction.transfertDetail','transaction.paymentInfo')->withSum('paiements as payer','sender_payer')->paginate(getPaginate());

  
      return view('staff.container.listenonpaye', compact('pageTitle', 'rdv_chauf', 'mission', 'emptyMessage','ct','container_id'));



   }
   public function listereceivenonpaye($id)
   {
     
      $pageTitle = "Details Colis Non payé du Conteneur";
      $emptyMessage = "Aucun Colis";
      $mission = Container::findOrFail(decrypt($id));
      $ct=$mission->idcontainer;

      $container_id=$id;

      $rdv_chauf=ContainerNbcolis::where('container_id',$ct)->with('transaction','transaction','transaction.sender','transaction.transfertDetail','transaction.paymentInfo')->withSum('paiements as payer','receiver_payer')->paginate(getPaginate());

  
      return view('staff.container.listereceivenonpaye', compact('pageTitle', 'rdv_chauf', 'mission', 'emptyMessage','ct','container_id'));


   }

    // RETIRER COLIS DU CONTENEUR 
     public function coliscancel($idcolis,$idcontenaire)
     {
    
      $ncolis=ContainerNbcolis::where('id_transaction',decrypt($idcolis))->where('container_id',decrypt($idcontenaire))->where('deleted_at',NULL)->first();
        // dd($ncolis); 
     //voir si existe pour supprimer  
      if($ncolis)
      {


        
               $nb=$ncolis->nb_colis;
               $count=TransfertRef::where('transaction_id',decrypt($idcolis))->count();
  
               if($count >= 2)
               {
                  $refnum=Transaction::find(decrypt($idcolis));
                     $trans=$refnum->reftrans;
                     // dd($trans);
                     $trans_ref =TransfertRef::where('transaction_id',decrypt($idcolis))->where('status',1)->first();
                     $ref=$trans_ref->ref_souche_part;
                     // dd($ref);
                     $lastChar = substr($ref, -1);
                     //dd($lastChar);
                     $int_value = (int) $lastChar;
                  for($i = 0; $i < $nb;$i++){
                        $refer=$trans.'-'.($int_value + $i);
                        $update=TransfertRef::where('ref_souche_part',$refer)->update(array('status' => '0'));
                  }
               }else{
                  $refnum=Transaction::find(decrypt($idcolis));
                  $trans=$refnum->reftrans;
                  // dd($trans);
                  $trans_ref =TransfertRef::where('transaction_id',decrypt($idcolis))->where('status',1)->first();
                  $ref=$trans_ref->ref_souche_part;
                  // dd($ref);
                  $lastChar = substr($ref, -1);
                  $refer=$trans;
                  $update=TransfertRef::where('ref_souche_part',$refer)->update(array('status' => '0'));  

               }

               $count_trans=TransfertRef::where('transaction_id',decrypt($idcolis))->where('status',1)->count();
                     if($count_trans > 0)
                     {
                        $rdv = Transaction::where('id',decrypt($idcolis))->update(array('ship_status' => '11'));
                     }else{
                        $rdv = Transaction::where('id',decrypt($idcolis))->update(array('ship_status' => '0'));
                     }
               
               $upcolis=ContainerNbcolis::where('id_transaction',decrypt($idcolis))->where('container_id',decrypt($idcontenaire))->delete();

            }else{
               $update=TransfertRef::where('transaction_id',decrypt($idcolis))->update(array('status' => '0'));  
               $rdv = Transaction::where('id',decrypt($idcolis))->update(array('ship_status' => '0'));

            }

        $notify[]=['success','Colis Retiré'];
        return back()->withNotify($notify);
     }

     public function EndConteneur(Request $request){
      //dd($request);
      $mission=Container::find($request->code);
      //status 1 onteneur chargé status 2 conteneur reçu
      $mission->status='1';
      $mission->save();
      $notify[] = ['success', 'Conteneur Chargé '];
      return back()->withNotify($notify);

   }

   //IMPRIMER LISTE COLIS DU CONTENEUR
   public function printcharge($id)
   {

      $pageTitle = "Details Colis du Conteneur";
      $emptyMessage = "Aucun Colis";
      $userInfo = Auth::user();
      $mission = Container::findOrFail(decrypt($id));
     $ct=$mission->idcontainer;
   //    $rdv_chauf = Transfert::with('receiver','courierDetail','nbcolis','transfertDetail')->with('nbcolis', function ($query) use($ct){
   //       $query->where('container_id',$ct);
   //   })->where('status', '>', '0')->get();
    $rdv_chauf=ContainerNbcolis::where('container_id',$ct)->with('transaction','transaction.sender','transaction.transfertDetail','transaction.paymentInfo','transaction.courierDetail','transaction.receiver','transaction.paiement')->withSum('payments as paye','receiver_payer')->get();

      $pageTitle = "Details Conteneur du " . date('d-m-Y', strtotime($mission->date)) . " - Numero : " . $mission->numero;
      return view('staff.container.printcharge', compact('pageTitle', 'rdv_chauf', 'mission', 'emptyMessage','userInfo'));
   }

    public function printnonpaye($id)
   {

      $pageTitle = "Details Colis du Conteneur";
      $emptyMessage = "Aucun Colis";
      $userInfo = Auth::user();
      $mission = Container::findOrFail(decrypt($id));
     $ct=$mission->idcontainer;
 
   // $rdv_chauf=ContainerNbcolis::where('container_id',$ct)->with('transaction','transaction.sender','transaction.transfertDetail','transaction.paymentInfo','transaction.courierDetail','transaction.receiver','transaction.paiement')->withSum('payments as paye','receiver_payer')->get();
   $rdv_chauf = ContainerNbcolis::where('container_id', $ct)
    ->with('transaction', 'transaction.sender', 'transaction.transfertDetail', 'transaction.paymentInfo', 'transaction.courierDetail', 'transaction.receiver', 'transaction.paiement')
    ->withSum('payments as paye', 'receiver_payer')
    ->whereHas('transaction', function ($query) {
        $query->where('status', '!=', 2);
    })
    ->get();

      $pageTitle = "Details Conteneur du " . date('d-m-Y', strtotime($mission->date)) . " - Numero : " . $mission->numero;
      return view('staff.container.printnonpaye', compact('pageTitle', 'rdv_chauf', 'mission', 'emptyMessage','userInfo'));
   }

   public function export_nonpayer(Request $request,$id) {
   $mission = Container::findOrFail(decrypt($id));
   $ct=$mission->idcontainer;
   return Excel::download( new TransactionPaymentExportMapping($ct), 'transnonpayer.xlsx') ;

}

      public function smsConteneur(Request $request)
   {
      $request->validate([
         'container_id' => 'required',
         'message'=>'required|string|max:160'
         ]);
      $userInfo = Auth::user();
      $recipient = "";
      $nbContact = 0;
      $nbsms = 1;
      $messager=addslashes($request->message);
      $message=$request->message;
      $date = date('Y-m-d');  
      $user = Auth::user();
      $container_id=decrypt($request->container_id);
      $rdv_id= 'C_'.$container_id;

      $envoi_sms= DB::INSERT("INSERT INTO `sms`(`date`, `rdv_cont`, `message`, `user_id`,`agence_id`) VALUES ('$date','$rdv_id','$messager','$user->id','$user->branch_id')");

      
     // dd($container_id);
      if($userInfo->branch->country == 'FRA'){
         $rdv_info=ContainerNbcolis::where('container_id',$container_id)->where('deleted_at',NULL)->with('transaction.sender')->get();
         //dd($rdv_info[1]->colis);
      }else{
         $rdv_info=ContainerNbcolis::where('container_id',$container_id)->where('deleted_at',NULL)->with('transaction.receiver')->get();

      }

     // dd($rdv_info[0]->colis);
      for ($i = 0; $i < count($rdv_info); $i++) {
         if($userInfo->branch->country == 'FRA'){
           
               $client = preg_replace("/[^0-9]/", "",$rdv_info[$i]->transaction->sender->contact);
              
            if ((strlen($client) > 9) && (!preg_match("/xx/i", "$client")) && (!preg_match("/0000/i", "$client")) && ($client !='0619645428')) {
               $recipient ="0033" . substr($client, -9) ;
               //$nbContact++;
            }
            $idmission=decrypt($request->container_id);
            $idrdv=$rdv_info[$i]->transaction->code;
           // $verifier=DB::SELECT("select * from sms_envoi where rdv_id ='$idrdv' ");
           if(strlen($recipient) == 13 && $recipient !='0033619645428'){
            $controller= new SmsController;
            $controller->sendSms($recipient,$message,$idmission,$rdv_id);
           }else{
            $notify[] = ['success', 'Sms dejà Envoyé aux clients!'];
            return back()->withNotify($notify);
           }
         }elseif($userInfo->branch->country == 'CIV'){
            $client = preg_replace("/[^0-9]/", "",$rdv_info[$i]->transaction->receiver->contact);
            if ((strlen($client) > 9) && (!preg_match("/xx/i", "$client")) && (!preg_match("/0000/i", "$client"))) {
               $recipient ="00225" . substr($client, -10) ;
               //$nbContact++;
            }
            $idmission=decrypt($request->container_id);
            $idrdv=$rdv_info[$i]->transaction->code;
           // $verifier=DB::SELECT("select * from sms_envoi where rdv_id ='$idrdv' ");
           // && count($verifier) < 4
           if(strlen($recipient) > 13 ){
            $controller= new SmsController;
            $controller->sendSms($recipient,$message,$idmission,$rdv_id);
           }
         }
        
           
      //    $idmission=decrypt($request->container_id);
      //    $idrdv=$rdv_info[$i]->colis->code;
      //    $verifier=DB::SELECT("select * from sms_envoi where rdv_id ='$idrdv' ");
      //   if(strlen($recipient) == 13 && !$verifier){
      //    $this->sendSms($recipient,$message,$idmission,$idrdv);
      //   }
       
      }
      $notify[] = ['success', 'Sms Envoyé aux clients!'];
      return back()->withNotify($notify);
   }

   public function reopencontainer(Request $request){
      //dd($request);
      $mission=Container::find($request->code);
      //status 1 onteneur chargé status 2 conteneur reçu
      $mission->status='0';
      $mission->save();
      $notify[] = ['success', 'Conteneur Reouvert '];
      return back()->withNotify($notify);

   }
   public function DechargeContainer(Request $request){
      //dd($request);
      $mission=Container::find($request->code);
      $container_id=$mission->id;
      //status 1 onteneur chargé status 2 conteneur reçu
      $mission->status='2';
      $mission->save();

      $rdv_info=ContainerNbcolis::where('container_id',$request->code)->where('deleted_at',NULL)->with('transaction')->get();
    
       for ($i = 0; $i < count($rdv_info); $i++) {

          $count_trans=TransfertRef::where('transaction_id',$rdv_info[$i]->transaction->id)->where('status',1)->count();
                     if($count_trans > 0)
                     {
                        $rdv = Transaction::where('id',$rdv_info[$i]->transaction->id)->update(array('ship_status' => '22'));
                     }else{
                        $rdv = Transaction::where('id',$rdv_info[$i]->transaction->id)->update(array('ship_status' => '2'));
                     }
         
       }
      $notify[] = ['success', 'Conteneur DeChargé '];
      return back()->withNotify($notify);

   }





}