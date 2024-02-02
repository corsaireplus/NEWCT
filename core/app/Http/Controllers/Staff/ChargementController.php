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
use App\Exports\TransfertPaymentExportMapping;
use Maatwebsite\Excel\Facades\Excel;


class ChargementController extends Controller
{
   public function index()
   {
      $pageTitle = "Liste des Conteneurs";
      $emptyMessage = "Aucun Conteneur";
      $admin = Auth::user();
      $missions = Container::with('destination','envois')->where('desti_id', '!=', $admin->branch_id)->orderBy('date', 'desc')->paginate(getPaginate());
      return view('staff.chargement.index', compact('pageTitle', 'missions', 'emptyMessage'));
   }
   public function create()
   {
      $pageTitle = "Ajouter Conteneur";
      $admin = Auth::user();
      $branch = Branch::where('status', 1)->where('id', '!=', $admin->branch_id)->latest()->get();
      return view('staff.chargement.create', compact('pageTitle', 'branch'));
   }
   public function store_container(Request $request){
     // dd($request);
      $admin = Auth::user();
      $mission=new Container();
      $mission->date=date("Y-m-d", strtotime($request->date));
      $mission->desti_id=$request->desti_id;
      $mission->numero=$request->numero;
      $mission->armateur=$request->armateur;
      $mission->date_arrivee=date("Y-m-d", strtotime($request->date_arrivee));
      if($request->message != ''){
        $mission->observation=$request->message;
      }else{ $mission->observation='';}
     
      $mission->user_id=$admin->id;
      $mission->save();
      $notify[]=['success','Conteneur Créé avec succès'];
      return redirect()->route('staff.container.liste', encrypt($mission->idcontainer))->withNotify($notify);
   }
   public function assigne($id)
   {
      $emptyMessage = "Aucun Colis";
      $mission = Container::findOrFail(decrypt($id));
      $colis_dispo = Transfert::where('status','<',2)->with('sender')->with('transfertDetail', function ($query){
         $query->where('status',0);
     })->orderBy('created_at', 'DESC')->paginate(getPaginate());      $pageTitle = "Ajouter colis au Conteneur du " . date('d-m-Y', strtotime($mission->date)) . " - N°: " . $mission->numero;
      //dd($colis_dispo);
      return view('staff.chargement.assign', compact('pageTitle', 'colis_dispo', 'mission', 'emptyMessage'));
   }

   public function decharge()
   {
      $pageTitle = "Liste des Conteneurs";
      $emptyMessage = "Aucun Conteneur";
      $admin = Auth::user();
      $missions = Container::where('desti_id', '=', $admin->branch_id)->orderBy('date', 'desc')->with('destination','envois')->orderBy('date', 'desc')->paginate(getPaginate());

      // dd($missions);
      return view('staff.dechargement.index', compact('pageTitle', 'missions', 'emptyMessage'));
   }
   public function storecolis(Request $request)
   {
      $request->validate([
         'nbcolis'=>'numeric|gt:0'
      ]);
      try {
         $check=ContainerNbcolis::where('container_id',$request->idmission)->where('id_colis',$request->idrdv)->first();
         
         if($check){
            $notify[] = ['error', 'Colis dejà Ajouté au Conteneur'];
         return back()->withNotify($notify);
         }else{
                        $rdv = Transfert::find($request->idrdv);
                        $nb=$request->nbcolis;
                     
                        $count=TransfertRef::where('transfert_id',$request->idrdv)->count();

                     // dd($count);
                        if($count >= 2){
                           $refnum=Transfert::find($request->idrdv);
                              $trans=$refnum->reference_souche;
                           // dd($trans);
                              $trans_ref =TransfertRef::where('transfert_id',$request->idrdv)->where('status',0)->first();
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
                           $count=TransfertRef::where('transfert_id',$request->idrdv)->where('status',0)->count();
                           if($count > 0){
                              $rdv = Transfert::find($request->idrdv);
                              //dd($rdv);
                              $rdv->status = '1';
                              $rdv->save();
                           }else{
                              $rdv = Transfert::find($request->idrdv);
                              //dd($rdv);
                              $rdv->status = '2';
                              $rdv->save();
                           }
                           
                        }else{
                           $rdv = Transfert::find($request->idrdv);
                           //dd($rdv);
                           $rdv->status = '2';
                           $rdv->save();
                           $update=TransfertRef::where('transfert_id',$request->idrdv)->update(array('status' => '1'));
                        }
                        

                        $manifest=new ContainerNbcolis();
                        $manifest->container_id =$request->idmission;
                        $manifest->id_colis =$request->idrdv;
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
   public function storecolismulti(Request $request)
   {
      
    // dd($request);
      try {
         // $i= 0;
         // $data=array();
         // $rdv=array();
         for ($i = 0; $i < count($request->ids); $i++) {
            $check=ContainerNbcolis::where('container_id',$request->idmission)->where('id_colis',$request->ids[$i])->first();
         
            if($check){
               $notify[] = ['error', 'Colis dejà Ajouté au Conteneur'];
            return back()->withNotify($notify);
            }elseif(isset($request->nbcolis[$i]) && $request->nbcolis[$i] != null){
            $nb=$request->nbcolis[$i];
          
            $rdv = Transfert::find($request->ids[$i]);
           //compter le nombre de colis dans la table transfertRef 
            $count=TransfertRef::where('transfert_id',$request->ids[$i])->where('status',0)->count();

            
            // dd($count);
             if($count >= 2){
               //si le nombre de colis enregistre est superieur ou egal a 2
                  $refnum=Transfert::find($request->ids[$i]);
                   $trans=$refnum->reference_souche;
                  // dd($trans);
                   $trans_ref =TransfertRef::where('transfert_id',$request->ids[$i])->where('status',0)->first();
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
               // $count=TransfertRef::where('transfert_id',$request->ids[$i])->where('status',0)->count();
                $test =$count - $nb;
                if($test > 0){
                   $rdv = Transfert::find($request->ids[$i]);
                   //dd($rdv);
                   $rdv->status = '1';
                   $rdv->save();
                }elseif($test == 0){
                   $rdv = Transfert::find($request->ids[$i]);
                    //dd($rdv);
                    $rdv->status = '2';
                    $rdv->save();
                }
                
             }else{
               //sinon il s agit d un seul colis 
                $rdv = Transfert::find($request->ids[$i]);
                //dd($rdv);
                $rdv->status = '2';
                $rdv->save();
                $update=TransfertRef::where('transfert_id',$request->ids[$i])->update(array('status' => '1'));
             }

             $manifest=new ContainerNbcolis();
             $manifest->container_id =$request->idmission;
             $manifest->id_colis =$request->ids[$i];
             $manifest->nb_colis =$request->nbcolis[$i];
              $manifest->save();
            // $id=$request->ids[$i];
            // $data = DB::INSERT("INSERT INTO `mission_rdv`(`mission_idmission`, `rdv_idrdv`) VALUES ('$request->idmission','$id')");
         }else{
            $notify[] = ['error', 'Ajoutez nombre de colis svp !!'];
            return back()->withNotify($notify);
         }
         // $i++;

         $notify[] = ['success', 'Liste Colis Ajoutée'];
         return back()->withNotify($notify);
       }
      } catch (Throwable $e) {
         report($e);

         return false;
      }
   }


   // DETAIL DU CONTENEUR CHARGE
   public function detailcontainer($id)
   {
      $pageTitle = "Details Colis du Conteneur";
      $emptyMessage = "Aucun Colis";
      $mission = Container::findOrFail(decrypt($id));
      $ct=$mission->idcontainer;
    //   $totalPaye=Paiement::where('branch_id','1')->where('sender_branch_id','1')->whereHas('container_nbcolis', function ($q) use ($ct) {
    //      $q->where('container_id', $ct);
    //   })->sum('paiements.sender_payer');
    
    // Obtenez les ID de colis du conteneur C1 qui n'existent pas dans d'autres conteneurs
   $uniqueColisIdsInC = ContainerNbcolis::select('id_colis')
    ->where('container_id', $ct) // $ct est l'ID du conteneur C1
    ->whereNotIn('id_colis', function ($query) use ($ct) {
        // Sous-requête pour sélectionner les colis qui existent dans d'autres conteneurs
        $query->select('id_colis')
              ->from('conatainer_nbcolis')
              ->where('container_id', '<>', $ct);
    })
    ->pluck('id_colis');
   $totalValeur = TransfertPayment::whereIn('transfert_id', $uniqueColisIdsInC)
    ->sum('sender_amount');
    
    
    // Premièrement, obtenons les IDs de colis qui sont uniquement dans le conteneur spécifié et qui n'existent pas dans d'autres conteneurs.
    $uniqueColisIdsInC1 = ContainerNbcolis::select('id_colis')
        ->where('container_id', $ct)
        ->whereNotIn('id_colis', function ($query) use ($ct) {
            $query->select('id_colis')
                  ->from('conatainer_nbcolis')
                  ->where('container_id', '<>', $ct);
        })
        ->pluck('id_colis');
    
    // Ensuite, utilisons cette liste de IDs de colis pour obtenir la somme des paiements.
    $totalPaye = Paiement::where('branch_id', 1)
        ->where('sender_branch_id', 1)
        ->whereIn('transfert_id', $uniqueColisIdsInC1)
        ->sum('sender_payer');


   /* 
    $totalPaye = Paiement::where('branch_id', '1')
    ->where('sender_branch_id', '1')
    ->whereIn('transfert_id', function ($query) use ($ct) {
        $query->select('id_colis')
            ->from('conatainer_nbcolis')
            ->where('container_id', $ct)
            ->groupBy('id_colis')
            ->havingRaw('COUNT(*) = 1');
    })->sum('sender_payer');
        */
      
       
       $colisIds = ContainerNbcolis::where('container_id', $ct)
    ->groupBy('id_colis')
    ->havingRaw('COUNT(*) = 1')
    ->pluck('id_colis');

    // $totalValeur = TransfertPayment::whereIn('transfert_id', $colisIds)
  //  ->sum('sender_amount');

    //   $totalValeur=TransfertPayment::whereHas('container_nbcolis',function($q) use ($ct){
    //      $q->where('container_id', $ct);
    //   })->sum('transfert_payments.sender_amount');
//$totalPaye=ContainerNbcolis::with('payments','transfert_payments')->where('container_id',$ct)->withSum('payments as totalPaye','sender_payer')->first();
   //    $totalPaye= DB::table('paiements')
   // ->join('transfert_payments','paiements.transfert_id','=','transfert_payments.transfert_id')
   // ->join('conatainer_nbcolis','paiements.transfert_id','=','conatainer_nbcolis.id_colis')
   // ->where('conatainer_nbcolis.container_id',$ct)
   // ->where('conatainer_nbcolis.deleted_at',NULL)
   // ->where('transfert_payments.status',2)
   // ->where('paiements.branch_id', 1)
   // ->where('paiements.sender_branch_id', 1)
   // ->where('paiements.transfert_id', '!=', NULL)
   // ->where('paiements.deleted_at',NULL)
   // ->sum('sender_payer');
   $totalPartiel=0;
   // $totalPartiel= DB::table('paiements')
   // ->join('transfert_payments','paiements.transfert_id','=','transfert_payments.transfert_id')
   // ->join('conatainer_nbcolis','paiements.transfert_id','=','conatainer_nbcolis.id_colis')
   // ->where('conatainer_nbcolis.container_id',$ct)
   // ->where('conatainer_nbcolis.deleted_at',NULL)
   // ->where('transfert_payments.status',1)
   // ->where('paiements.branch_id', 1)
   // ->where('paiements.sender_branch_id', 1)
   // ->where('paiements.transfert_id', '!=', NULL)
   // ->where('paiements.deleted_at',NULL)
   // ->sum('sender_payer');
   $totalNonPaye=0;
   // $totalNonPaye= DB::table('transfert_payments')
   // ->join('conatainer_nbcolis','transfert_payments.transfert_id','=','conatainer_nbcolis.id_colis')
   // ->where('conatainer_nbcolis.container_id',$ct)
   // ->where('conatainer_nbcolis.deleted_at',NULL)
   // ->where('transfert_payments.status',0)
   // ->where('transfert_payments.deleted_at',NULL)
   // ->sum('sender_amount');
  // $totalValeur=0;
   // $totalValeur=DB::table('transfert_payments')
   // ->join('conatainer_nbcolis','transfert_payments.transfert_id','=','conatainer_nbcolis.id_colis')
   // ->where('conatainer_nbcolis.container_id',$ct)
   // ->where('conatainer_nbcolis.deleted_at',NULL)
   // ->where('transfert_payments.deleted_at',NULL)
   // ->sum('sender_amount');
   DB::enableQueryLog();
      $rdv_chauf=ContainerNbcolis::where('container_id',$ct)->with('colis','colis.sender','colis.transfertDetail','colis.paymentInfo')->paginate(getPaginate());
      // dd(DB::getQueryLog());
      //dd($rdv_chauf);
      $pageTitle = "Details Conteneur du " . date('d-m-Y', strtotime($mission->date)) . " - Numero : " . $mission->numero;
      return view('staff.chargement.detail', compact('pageTitle', 'rdv_chauf', 'mission', 'emptyMessage','totalValeur','totalNonPaye','totalPartiel','totalPaye','ct'));
   }

   public function getContainerData(Request $request,$id){
      $containers=ContainerNbcolis::where('container_id',$id)->with('colis','colis.sender','colis.transfertDetail','colis.paymentInfo');

      return DataTables::of($containers)
      ->editColumn('created_at', function ($container) {
         return $container->colis->created_at ? with(new Carbon($container->colis->created_at))->format('d/m/Y') : '';
     })
     ->editColumn('nb_charge', function ($container) {
      return $container->colis->transfertDetail->count();
      })
      ->editColumn('frais', function ($container) {
         return $container->colis->paymentInfo->sender_amount;
         })
     ->editColumn('action', function($container){
      if($container->colis->paymentInfo->status == 0 )
                   return '<span class="badge badge--danger">Non Payé</span>';
                                    elseif($container->colis->paymentInfo->status == 1 )
                                return '<span class="badge badge--warning">Partiel</span>';
                                    elseif($container->colis->paymentInfo->status == 2)
                                 return '<span class="badge badge--success">Payé</span>';
                                    
     }) 
     ->make(true);
     
   }

   // DETAIL DU CONTENEUR DECHARGE
   public function detaildecharge($id)
   {
      $pageTitle = "Details Colis du Conteneur";
      $emptyMessage = "Aucun Colis";
      $mission = Container::findOrFail(decrypt($id));
      $ct=$mission->idcontainer;
      
      // Supposons que $ct soit l'ID du conteneur pour lequel vous voulez trouver les nouveaux colis
        // et que vous avez une colonne `created_at` pour la date de création du conteneur.
        
        // D'abord, obtenons la date de création du conteneur C1.
        $containerCreationDate = Container::where('idcontainer', $ct)->value('created_at');
        
        // Ensuite, trouvons les colis qui n'apparaissent que dans ce conteneur et dans aucun autre créé avant.
        $newColisInContainer = ContainerNbcolis::where('container_id', $ct)
            ->whereNotExists(function ($query) use ($containerCreationDate) {
                $query->select(DB::raw(1))
                      ->from('conatainer_nbcolis as cnb')
                      ->join('containers as c', 'c.idcontainer', '=', 'cnb.container_id')
              ->where('cnb.id_colis', DB::raw('conatainer_nbcolis.id_colis'))
              ->where('c.created_at', '<', $containerCreationDate);
        })
        ->pluck('id_colis');
        
       // dd($newColisInContainer);

// Maintenant, vous pouvez utiliser $newColisInContainer pour obtenir les détails nécessaires ou effectuer d'autres calculs.

      
      $uniqueColisIdsInC = ContainerNbcolis::select('id_colis')
    ->where('container_id', $ct) // $ct est l'ID du conteneur C1
    ->whereNotIn('id_colis', function ($query) use ($ct) {
        // Sous-requête pour sélectionner les colis qui existent dans d'autres conteneurs
        $query->select('id_colis')
              ->from('conatainer_nbcolis')
              ->where('container_id', '<>', $ct);
    })
    ->pluck('id_colis');
   // dd($uniqueColisIdsInC);
   $totalValeur = TransfertPayment::whereIn('transfert_id', $newColisInContainer)
    ->sum('receiver_amount');
    
    
    // Premièrement, obtenons les IDs de colis qui sont uniquement dans le conteneur spécifié et qui n'existent pas dans d'autres conteneurs.
    $uniqueColisIdsInC1 = ContainerNbcolis::select('id_colis')
        ->where('container_id', $ct)
        ->whereNotIn('id_colis', function ($query) use ($ct) {
            $query->select('id_colis')
                  ->from('conatainer_nbcolis')
                  ->where('container_id', '<>', $ct);
        })
        ->pluck('id_colis');
        
    $totalPaye = Paiement::where('sender_branch_id', 1)
        ->whereIn('transfert_id', $newColisInContainer)
        ->sum('receiver_payer');
        
    // Ensuite, utilisons cette liste de IDs de colis pour obtenir la somme des paiements.
    $totalPartiel = Paiement::where('branch_id', 2)
        ->where('sender_branch_id', 1)
        ->whereIn('transfert_id', $newColisInContainer)
        ->sum('receiver_payer');
        
       // dd('valeur '.$totalValeur.' payer a abidjan '.$totalPartiel.' total payer '.$totalPaye.' reste à payer '.($totalValeur-$totalPaye));
      // "valeur 18926256.00 payer a abidjan 1432624.00 total payer 15052496.00 reste à payer 3873760"
        
        // $totalPartiel=Paiement::where('branch_id','2')->where('sender_branch_id','1')->whereHas('container_nbcolis', function ($q) use ($ct) {
        // $q->where('container_id', $ct);
       //})->sum('paiements.receiver_payer');
       // $totalValeur=TransfertPayment::whereHas('container_nbcolis',function($q) use ($ct){
        // $q->where('container_id', $ct);
       //})->sum('transfert_payments.receiver_amount');
      
      // $totalPaye= DB::table('paiements')
      // ->join('transfert_payments','paiements.transfert_id','=','transfert_payments.transfert_id')
      // ->join('conatainer_nbcolis','paiements.transfert_id','=','conatainer_nbcolis.id_colis')
      // ->where('conatainer_nbcolis.container_id',$ct)
      // ->where('conatainer_nbcolis.deleted_at',NULL)
      // ->where('transfert_payments.status',2)
      // ->where('paiements.sender_branch_id', 1)
      // ->where('paiements.transfert_id', '!=', NULL)
      // ->where('paiements.deleted_at',NULL)
      // ->sum('receiver_payer');
     // $totalPaye=Paiement::where('sender_branch_id','1')->whereHas('container_nbcolis', function ($q) use ($ct) {
     //    $q->where('container_id', $ct);
     //  })->sum('paiements.receiver_payer');
      // $totalPartiel=0;
      
      // $totalPartiel= DB::table('paiements')
      // ->join('transfert_payments','paiements.transfert_id','=','transfert_payments.transfert_id')
      // ->join('conatainer_nbcolis','paiements.transfert_id','=','conatainer_nbcolis.id_colis')
      // ->where('conatainer_nbcolis.container_id',$ct)
      // ->where('conatainer_nbcolis.deleted_at',NULL)
      // ->where('transfert_payments.status',1)
      // ->where('paiements.sender_branch_id', 1)
      // ->where('paiements.transfert_id', '!=', NULL)
      // ->where('paiements.deleted_at',NULL)
      // ->sum('receiver_payer');
      $totalNonPaye=0;
      // $totalNonPaye= DB::table('transfert_payments')
      // ->join('conatainer_nbcolis','transfert_payments.transfert_id','=','conatainer_nbcolis.id_colis')
      // ->where('conatainer_nbcolis.container_id',$ct)
      // ->where('conatainer_nbcolis.deleted_at',NULL)
      // ->where('transfert_payments.status',0)
      // ->where('transfert_payments.deleted_at',NULL)
      // ->sum('receiver_amount');
     
      // $totalValeur=DB::table('transfert_payments')
      // ->join('conatainer_nbcolis','transfert_payments.transfert_id','=','conatainer_nbcolis.id_colis')
      // ->where('conatainer_nbcolis.container_id',$ct)
      // ->where('conatainer_nbcolis.deleted_at',NULL)
      // ->where('transfert_payments.deleted_at',NULL)
      // ->sum('receiver_amount');
   
         $rdv_chauf=ContainerNbcolis::where('container_id',$ct)->with('colis','colis.sender','colis.transfertDetail')->with(['colis.paymentInfo' => function ($q){
            $q->orderBy('status', 'ASC'); }])->paginate(getPaginate());
         //dd($rdv_chauf);
      
      $pageTitle = "Details Conteneur du " . date('d-m-Y', strtotime($mission->date)) . " - Numero : " . $mission->numero;
      return view('staff.chargement.detail_decharge', compact('pageTitle', 'rdv_chauf', 'mission', 'emptyMessage','totalValeur','totalNonPaye','totalPartiel','totalPaye'));
   }


     // RETIRER COLIS DU CONTENEUR 
     public function colis_containercancel($idcolis,$idcontenaire){
    
      $ncolis=ContainerNbcolis::where('id_colis',decrypt($idcolis))->where('container_id',decrypt($idcontenaire))->where('deleted_at',NULL)->first();
     //voir si existe pour supprimer  
      if($ncolis){
            
              $nb=$ncolis->nb_colis;
               $count=TransfertRef::where('transfert_id',decrypt($idcolis))->count();
  
               if($count >= 2){
                  $refnum=Transfert::find(decrypt($idcolis));
                     $trans=$refnum->reference_souche;
                     // dd($trans);
                     $trans_ref =TransfertRef::where('transfert_id',decrypt($idcolis))->where('status',1)->first();
                     $ref=$trans_ref->ref_souche_part;
                     // dd($ref);
                     $lastChar = substr($ref, -1);
                     //dd($lastChar);
                     $int_value = (int) $lastChar;
                  for($i = 0; $i < $nb;$i++){
                  
                        $refer=$trans.'-'.($int_value + $i);
                     // dd($refer);
                        $update=TransfertRef::where('ref_souche_part',$refer)->update(array('status' => '0'));  

                  }
               }else{
                  $refnum=Transfert::find(decrypt($idcolis));
                  $trans=$refnum->reference_souche;
                  // dd($trans);
                  $trans_ref =TransfertRef::where('transfert_id',decrypt($idcolis))->where('status',1)->first();
                  $ref=$trans_ref->ref_souche_part;
                  // dd($ref);
                  $lastChar = substr($ref, -1);
                  $refer=$trans;
                  $update=TransfertRef::where('ref_souche_part',$refer)->update(array('status' => '0'));  

                }
                  $count_trans=TransfertRef::where('transfert_id',decrypt($idcolis))->where('status',1)->count();
                  if($count_trans > 0){
                     $rdv = Transfert::where('id',decrypt($idcolis))->update(array('status' => '1'));
                     
                  }else{
                     $rdv = Transfert::where('id',decrypt($idcolis))->update(array('status' => '0'));
               
                  }
               $upcolis=ContainerNbcolis::where('id_colis',decrypt($idcolis))->where('container_id',decrypt($idcontenaire))->delete();

            }else{
               $update=TransfertRef::where('transfert_id',decrypt($idcolis))->update(array('status' => '0'));  
               $rdv = Transfert::where('id',decrypt($idcolis))->update(array('status' => '0'));

               }

        $notify[]=['success','Colis Retiré'];
        return back()->withNotify($notify);
  }
   public function EndContainer(Request $request){
      //dd($request);
      $mission=Container::find($request->code);
      //status 1 onteneur chargé status 2 conteneur reçu
      $mission->status='1';
      $mission->save();
      $notify[] = ['success', 'Conteneur Chargé '];
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
      //status 1 onteneur chargé status 2 conteneur reçu
      $mission->status='2';
      $mission->save();
      $notify[] = ['success', 'Conteneur DeChargé '];
      return back()->withNotify($notify);

   }
   //RECHEREHCEHR COLIS A AJOUTER AU CONTENEUR
   public function SearchColis(Request $request){
      $emptyMessage = "Aucun Colis";
      $search = $request->search;
      $id=$request->id;
      $mission = Container::findOrFail(decrypt($id));
      if($search !=''){
         $colis_dispo = Transfert::where('status','<',2)->where('reference_souche','like', '%'.$search.'%')->with('sender')->with('transfertDetail', function ($query){
            $query->where('status',0);
        })->orderBy('created_at', 'ASC')->paginate(getPaginate());

      }else{
         $colis_dispo = Transfert::where('container_id', NULL)->where('status', 0)->with('sender')->with('transfertDetail', function ($query){
            $query->where('status',0);
        })->orderBy('created_at', 'ASC')->paginate(getPaginate());

      }
      $pageTitle = "Ajouter colis au Conteneur du " . date('d-m-Y', strtotime($mission->date)) . " - N°: " . $mission->numero;
     // dd($colis_dispo);
      return view('staff.chargement.assign', compact('pageTitle', 'colis_dispo', 'mission', 'emptyMessage'));
   }

   // Rechercher colis dans la liste du conteneur
   public function SearchDetailColis(Request $request){
      $search = $request->search;
      $id=$request->id;
      $pageTitle = "Details Colis du Conteneur";
      $emptyMessage = "Aucun Colis";
      $mission = Container::findOrFail(decrypt($id));
      $ct=$mission->idcontainer;
      $totalPaye=Paiement::where('branch_id','1')->where('sender_branch_id','1')->whereHas('container_nbcolis', function ($q) use ($ct) {
         $q->where('container_id', $ct);
       })->sum('paiements.sender_payer');

       $totalValeur=TransfertPayment::whereHas('container_nbcolis',function($q) use ($ct){
         $q->where('container_id', $ct);
       })->sum('transfert_payments.sender_amount');
//$totalPaye=ContainerNbcolis::with('payments','transfert_payments')->where('container_id',$ct)->withSum('payments as totalPaye','sender_payer')->first();
   //    $totalPaye= DB::table('paiements')
   // ->join('transfert_payments','paiements.transfert_id','=','transfert_payments.transfert_id')
   // ->join('conatainer_nbcolis','paiements.transfert_id','=','conatainer_nbcolis.id_colis')
   // ->where('conatainer_nbcolis.container_id',$ct)
   // ->where('conatainer_nbcolis.deleted_at',NULL)
   // ->where('transfert_payments.status',2)
   // ->where('paiements.branch_id', 1)
   // ->where('paiements.sender_branch_id', 1)
   // ->where('paiements.transfert_id', '!=', NULL)
   // ->where('paiements.deleted_at',NULL)
   // ->sum('sender_payer');
   $totalPartiel=0;
   // $totalPartiel= DB::table('paiements')
   // ->join('transfert_payments','paiements.transfert_id','=','transfert_payments.transfert_id')
   // ->join('conatainer_nbcolis','paiements.transfert_id','=','conatainer_nbcolis.id_colis')
   // ->where('conatainer_nbcolis.container_id',$ct)
   // ->where('conatainer_nbcolis.deleted_at',NULL)
   // ->where('transfert_payments.status',1)
   // ->where('paiements.branch_id', 1)
   // ->where('paiements.sender_branch_id', 1)
   // ->where('paiements.transfert_id', '!=', NULL)
   // ->where('paiements.deleted_at',NULL)
   // ->sum('sender_payer');
   $totalNonPaye=0;
   // $totalNonPaye= DB::table('transfert_payments')
   // ->join('conatainer_nbcolis','transfert_payments.transfert_id','=','conatainer_nbcolis.id_colis')
   // ->where('conatainer_nbcolis.container_id',$ct)
   // ->where('conatainer_nbcolis.deleted_at',NULL)
   // ->where('transfert_payments.status',0)
   // ->where('transfert_payments.deleted_at',NULL)
   // ->sum('sender_amount');
  // $totalValeur=0;
   // $totalValeur=DB::table('transfert_payments')
   // ->join('conatainer_nbcolis','transfert_payments.transfert_id','=','conatainer_nbcolis.id_colis')
   // ->where('conatainer_nbcolis.container_id',$ct)
   // ->where('conatainer_nbcolis.deleted_at',NULL)
   // ->where('transfert_payments.deleted_at',NULL)
   // ->sum('sender_amount');
   DB::enableQueryLog();
      $rdv_chauf=ContainerNbcolis::where('container_id',$ct)->with('colis','colis.sender','colis.transfertDetail','colis.paymentInfo')->with('colis',function($b) use ($search){ $b->where('reference_souche','like', '%'.$search.'%');})->paginate(getPaginate());
      // dd(DB::getQueryLog());
      //dd($rdv_chauf);
      $pageTitle = "Details Conteneur du " . date('d-m-Y', strtotime($mission->date)) . " - Numero : " . $mission->numero;
      return view('staff.chargement.detail', compact('pageTitle', 'rdv_chauf', 'mission', 'emptyMessage','totalValeur','totalNonPaye','totalPartiel','totalPaye','ct'));
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
    $rdv_chauf=ContainerNbcolis::where('container_id',$ct)->with('colis','colis.sender','colis.transfertDetail','colis.paymentInfo','colis.courierDetail','colis.receiver','colis.paiement')->withSum('payments as paye','receiver_payer')->get();

      $pageTitle = "Details Conteneur du " . date('d-m-Y', strtotime($mission->date)) . " - Numero : " . $mission->numero;
      return view('staff.chargement.printcharge', compact('pageTitle', 'rdv_chauf', 'mission', 'emptyMessage','userInfo'));
   }
   public function printdecharge($id)
   {

      $pageTitle = "Details Colis du Conteneur";
      $emptyMessage = "Aucun Colis";
      $userInfo = Auth::user();
      $mission = Container::findOrFail(decrypt($id));
     $ct=$mission->idcontainer;
   //    $rdv_chauf = Transfert::with('receiver','courierDetail','nbcolis','transfertDetail')->with('nbcolis', function ($query) use($ct){
   //       $query->where('container_id',$ct);
   //   })->where('status', '>', '0')->get();
   /*ancien 
    $rdv_chauf=ContainerNbcolis::where('container_id',$ct)->where('date_livraison',NULL)->with('colis.sender','colis.transfertDetail','colis.courierDetail','colis.receiver','colis.paiement','colis.paymentInfo')->withSum('payments as paye','receiver_payer')->with(['colis'=> function ($q){
      $q->orderBy('reference_souche','ASC');}])->get();
      */
      
      $rdv_chauf = ContainerNbcolis::where('container_id', $ct)
    ->where('date_livraison', NULL)
     ->withSum('payments as paye', 'receiver_payer')
    ->with(['colis' => function ($query) use ($ct) {
        $query->orderBy('reference_souche', 'ASC')
              ->with('sender', 'transfertDetail', 'courierDetail', 'receiver', 'paiement', 'paymentInfo')
             
              // Ajouter une sous-requête pour vérifier si le colis était dans un autre conteneur avant la date de création du conteneur actuel
              ->addSelect(['previously_in_container' => ContainerNbcolis::select(DB::raw('COUNT(*)'))
                ->whereColumn('id_colis', 'transferts.id')
                ->where('container_id', '<>', $ct)
                ->whereRaw('container_id IS NOT NULL')
                // Comparer la date de création du colis avec la date de création du conteneur actuel
                ->where('created_at', '<', function($query) use ($ct) {
                    $query->from('conatainer_nbcolis')
                          ->select('created_at')
                          ->where('container_id', $ct)
                          ->limit(1);
                })
                ->limit(1)
              ]);
    }])
    ->get();
    
   // dd($rdv_chauf);

// Maintenant, "previously_in_container" va tenir compte de la date de création du conteneur actuel.


      $pageTitle = "Details Conteneur du " . date('d-m-Y', strtotime($mission->date)) . " - Numero : " . $mission->numero;
      return view('staff.chargement.printdecharge', compact('pageTitle', 'rdv_chauf', 'mission', 'emptyMessage','userInfo'));
   }
   public function smsContainer(Request $request)
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
         $rdv_info=ContainerNbcolis::where('container_id',$container_id)->where('deleted_at',NULL)->with('colis.sender')->get();
         //dd($rdv_info[1]->colis);
      }else{
         $rdv_info=ContainerNbcolis::where('container_id',$container_id)->where('deleted_at',NULL)->with('colis.receiver')->get();

      }

     // dd($rdv_info[0]->colis);
      for ($i = 0; $i < count($rdv_info); $i++) {
         if($userInfo->branch->country == 'FRA'){
           
               $client = preg_replace("/[^0-9]/", "",$rdv_info[$i]->colis->sender->contact);
              
            if ((strlen($client) > 9) && (!preg_match("/xx/i", "$client")) && (!preg_match("/0000/i", "$client")) && ($client !='0619645428')) {
               $recipient ="0033" . substr($client, -9) ;
               //$nbContact++;
            }
            $idmission=decrypt($request->container_id);
            $idrdv=$rdv_info[$i]->colis->code;
           // $verifier=DB::SELECT("select * from sms_envoi where rdv_id ='$idrdv' ");
           if(strlen($recipient) == 13 && $recipient !='0033619645428'){
            $controller= new SmsController;
            $controller->sendSms($recipient,$message,$idmission,$rdv_id);
           }else{
            $notify[] = ['success', 'Sms dejà Envoyé aux clients!'];
            return back()->withNotify($notify);
           }
         }elseif($userInfo->branch->country == 'CIV'){
            $client = preg_replace("/[^0-9]/", "",$rdv_info[$i]->colis->receiver->contact);
            if ((strlen($client) > 9) && (!preg_match("/xx/i", "$client")) && (!preg_match("/0000/i", "$client"))) {
               $recipient ="00225" . substr($client, -10) ;
               //$nbContact++;
            }
            $idmission=decrypt($request->container_id);
            $idrdv=$rdv_info[$i]->colis->code;
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
   function oldsendSms($client, $message,$idmission,$idrdv)
   { 
    
      $curl = curl_init();
   
     /*TEST*/
     // $BASE_URL = "https://5v4p6j.api.infobip.com";
     // $API_KEY = "App 884683fde796d3d9d7afb4bb355daa1b-ac7d401b-ad12-4bbe-b34e-1c8891c85f15";
      /** */
   $BASE_URL= "https://gygyrw.api.infobip.com";
   $API_KEY = "App 53ac56146d9ddda8f3396fb303fe5101-27968279-6a9d-4962-83a2-562d37ac649c";
     

      $SENDER = "CHALLENGE TRANSIT";
      $RECIPIENT = $client;
     // $MESSAGE_TEXT ="CHALLENGE T PASSERA CHEZ VOUS AUJOURDHUI MERCI DE CONFIRMER VOTRE RDV AVEC LE CHAUFFEUR AU ".$chargeur;
      $MESSAGE_TEXT=$message;
      $MEDIA_TYPE = "application/json";

      curl_setopt_array($curl, array(
         CURLOPT_URL => $BASE_URL . '/sms/2/text/advanced',
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => '',
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => 'POST',

         CURLOPT_HTTPHEADER => array(
            'Authorization: ' . $API_KEY,
            'Content-Type: ' . $MEDIA_TYPE,
            'Accept: ' . $MEDIA_TYPE
         ),

         CURLOPT_POSTFIELDS => '{"messages":[{"from":"' . $SENDER . '","destinations":[{"to":"' . $RECIPIENT . '"}],"text":"' . $MESSAGE_TEXT . '"}]}',
      ));

      $response = curl_exec($curl);
      $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    

      $res=json_decode($response);
      //dd($res);
     // $date = date('Y-m-d'); 
     // $idmessage = "0000".$RECIPIENT;
      //$checkerror=DB::INSERT(" INSERT INTO `sms_envoi`(`date`, `idmission`, `rdv_id`, `contact`, `status`, `messageid`) VALUES ('$date','$idmission','$idrdv','$client','200','$response') ");
      if(isset($res->messages[0]) && $res->messages[0]->status->groupId == 1 ){
         $idmessage=$res->messages[0]->messageId;
      }
      else{
         $idmessage = "0000".$RECIPIENT;
      }
     // $idmessage=$res;
      $code=json_decode(($httpcode));
      //dd($code);
      curl_close($curl);
      if($code == 200 && $idmessage){
         $date = date('Y-m-d');   
         $sauvegarde=DB::INSERT(" INSERT INTO `sms_envoi`(`date`, `idmission`, `rdv_id`, `contact`, `status`, `messageid`) VALUES ('$date','$idmission','$idrdv','$client','200','$idmessage') ");
         return;
      }
      

   

      // HTTP code: 200 Response body: {"messages":
         // [{"to":"2250759393911",
         // "status":{"groupId":1,"groupName":"PENDING","id":26,"name":"PENDING_ACCEPTED","description":"Message sent to next instance"},
         // "messageId":"34175105815303572542"}]}
   }

   function sendSms($client, $message,$idmission,$idrdv){
      $BASE_URL = "https://gygyrw.api.infobip.com";
      $API_KEY = "53ac56146d9ddda8f3396fb303fe5101-27968279-6a9d-4962-83a2-562d37ac649c";
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

public function getContainerPayer(Request $request,$id){
   $pageTitle = "Details Colis deja payer";
   $emptyMessage = "Aucun Colis";
   $userInfo = Auth::user();
   $mission = Container::findOrFail(decrypt($id));
  $ct=$mission->idcontainer;
//    $rdv_chauf = Transfert::with('receiver','courierDetail','nbcolis','transfertDetail')->with('nbcolis', function ($query) use($ct){
//       $query->where('container_id',$ct);
//   })->where('status', '>', '0')->get();
//->Has(['payments' => function($q){ $q->where('branch_id','2');}])
//->with(['transfert_payments' =>function($b){$b->where('status','!=','0');}])
 //$rdv_chauf=ContainerNbcolis::where('container_id',$ct)->whereHas(['payments' => function($q){ $q->where('branch_id','2');}])->paginate(getPaginate());
 $rdv_chauf=Paiement::where('branch_id','2')->where('sender_branch_id','1')->whereHas('container_nbcolis', function ($q) use ($ct) {
   $q->where('container_id', $ct);
 })->with('transfert','transfert.paymentInfo','transfert.transfertDetail','transfert.receiver')->paginate(getPaginate());
//dd($rdv_chauf);
   $pageTitle = "Details colis payer Conteneur du " . date('d-m-Y', strtotime($mission->date)) . " - Numero : " . $mission->numero;
   return view('staff.dechargement.dejapayer', compact('pageTitle', 'rdv_chauf', 'mission', 'emptyMessage','userInfo','ct'));

}

public function getContainerRestaPayer(Request $request,$id){
   $pageTitle = "Details Colis restant a payer";
   $emptyMessage = "Aucun Colis";
   $userInfo = Auth::user();
   $mission = Container::findOrFail(decrypt($id));
  $ct=$mission->idcontainer;
//    $rdv_chauf = Transfert::with('receiver','courierDetail','nbcolis','transfertDetail')->with('nbcolis', function ($query) use($ct){
//       $query->where('container_id',$ct);
//   })->where('status', '>', '0')->get();
//->Has(['payments' => function($q){ $q->where('branch_id','2');}])
//->with(['transfert_payments' =>function($b){$b->where('status','!=','0');}])
 //$rdv_chauf=ContainerNbcolis::where('container_id',$ct)->whereHas(['payments' => function($q){ $q->where('branch_id','2');}])->paginate(getPaginate());
//  $rdv_chauf=Paiement::where('branch_id','!=','2')->where('sender_branch_id','1')->whereHas('container_nbcolis', function ($q) use ($ct) {
//    $q->where('container_id', $ct);
//  })->with('transfert','transfert.paymentInfo','transfert.transfertDetail','transfert.receiver')->paginate(getPaginate());
/*
$rdv_chauf = ContainerNbcolis::where('container_id', $ct)
    ->where('date_livraison', null)
    // Utilisez whereNotIn pour filtrer uniquement les colis qui sont exclusivement dans ce conteneur
    ->whereNotIn('id_colis', function ($query) use ($ct) {
        $query->select('id_colis')
              ->from('conatainer_nbcolis')
              ->where('container_id', '<>', $ct);
    })
    ->with([
        'colis' => function ($query) {
            $query->with(['receiver', 'transfertDetail', 'courierDetail','paymentInfo'])
                  ->with(['paiement' => function ($query) {
                      $query->where('status', '<>', '2');
                  }])
                  ->selectRaw('transferts.*, (SELECT SUM(receiver_payer) FROM paiements WHERE paiements.transfert_id = transferts.id AND paiements.status <> 2) as paye');
        }
    ])
   // ->withSum('payments as paye', 'receiver_payer')
    ->paginate(getPaginate());
*/

$containerCreationDate = Container::where('idcontainer', $ct)->value('created_at');

$rdv_chauf = ContainerNbcolis::where('container_id', $ct)
    ->where('date_livraison', null)
    ->whereNotExists(function ($query) use ($containerCreationDate) {
        $query->select(DB::raw(1))
              ->from('conatainer_nbcolis as cnb')
              ->join('containers as c', 'cnb.container_id', '=', 'c.idcontainer')
              ->whereRaw('cnb.id_colis = conatainer_nbcolis.id_colis')
              ->where('c.created_at', '<', $containerCreationDate);
    })
    ->with([
        'colis' => function ($query) {
            $query->with(['receiver', 'transfertDetail', 'courierDetail','paymentInfo'])
                  ->with(['paiement' => function ($query) {
                      $query->where('status', '<>', '2');
                  }]);
                 // ->selectRaw('transferts.*, (SELECT SUM(receiver_payer) FROM paiements WHERE paiements.transfert_id = transferts.id) as paye');
        }
    ])
    ->withSum('payments as paye','receiver_payer')
    ->paginate(100);
  //  dd($rdv_chauf);


// $rdv_chauf=ContainerNbcolis::where('container_id',$ct)->where('date_livraison',NULL)->with('colis','colis.receiver','colis.transfertDetail','colis.courierDetail','colis.paiement')->withSum('payments as paye','receiver_payer')->with(['transfert_payments'=> function ($q){
 //  $q->where('status','!=','2');}])->paginate(getPaginate());

   $pageTitle = "Details colis restant a payer Conteneur du " . date('d-m-Y', strtotime($mission->date)) . " - Numero : " . $mission->numero;
   return view('staff.dechargement.restapayer', compact('pageTitle', 'rdv_chauf', 'mission', 'emptyMessage','userInfo','ct'));

}
public function export_dejapayer(Request $request,$id) {
   $mission = Container::findOrFail(decrypt($id));
   $ct=$mission->idcontainer;
   return Excel::download( new PaiementExportMapping($ct), 'dejapayer.xlsx') ;

}

public function export_restapayer(Request $request,$id) {
   $mission = Container::findOrFail(decrypt($id));
   $ct=$mission->idcontainer;
   return Excel::download( new TransfertPaymentExportMapping($ct), 'restapayer.xlsx') ;

}

}

// "bulkId" => null
// "messages" => array:1 [▼
//   0 => Infobip\Model\SmsResponseDetails {#1868 ▼
//     #container: array:3 [▼
//       "messageId" => "35789225716705282483"
//       "status" => Infobip\Model\SmsStatus {#1847 ▼
//         #container: array:6 [▼
//           "action" => null
//           "description" => "Message sent to next instance"
//           "groupId" => 1
//           "groupName" => "PENDING"
//           "id" => 26
//           "name" => "PENDING_ACCEPTED"
//         ]
//       }
//       "to" => "0022559393911"
//     ]
//   }
// ]
// ]
