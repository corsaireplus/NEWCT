<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\TransfertPayment;
use App\Models\Paiement;
use App\Models\BranchTransaction;
use App\Models\Depense;
use App\Models\DepenseCategorie;
use App\Models\Transfert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Null_;
use Yajra\DataTables\Facades\DataTables;
use App\Models\AdminNotification;
use Carbon\Carbon;
use App\Models\TransfertProduct;
use App\Models\TransfertRef;
use DNS1D;

use App\Exports\BilanExportMapping;
use App\Exports\EncoursParisExportMapping;
use App\Exports\EncoursAbidjanExportMapping;
use Maatwebsite\Excel\Facades\Excel;


class BilanController extends Controller
{
  public function translist(Request $request){
    $pageTitle = "Mes Transactions du Jour";
    $user = Auth::user();
    $transbranchCount = BranchTransaction::where('branch_id', $user->branch_id)->where('created_by',$user->id)->count();
    
    $rdvbranchSum=Paiement::where('branch_id',$user->branch_id)->where('user_id',$user->id)->where('rdv_id','!=',NULL)->whereDate('created_at', Carbon::today())->sum('sender_payer','receiver_payer');
    $rdvbranchCount=Paiement::where('branch_id',$user->branch_id)->where('user_id',$user->id)->where('rdv_id','!=',NULL)->whereDate('created_at', Carbon::today())->count();
    DB::enableQueryLog();
      $Senderpaiment = DB::table('paiements')
        ->where('branch_id',$user->branch_id)
        ->where('sender_branch_id',$user->branch_id)
        ->where('user_id',$user->id)
        ->where('transfert_id','!=',NULL)
        ->where('deleted_at',NULL)
        ->whereDate('created_at', Carbon::today())
        ->sum('sender_payer');

        $oldReceiverpaiment = DB::table('paiements')
        ->where('branch_id',$user->branch_id)
        ->where('sender_branch_id','!=',$user->branch_id)
        ->where('user_id',$user->id)
        ->where('transfert_id','!=',NULL)
        ->where('deleted_at',NULL)
        ->whereDate('created_at', Carbon::today())
        ->sum('receiver_payer');
        
        
        $Senderpaiment =DB::table('branch_transactions')
        ->where('branch_id',$user->branch_id)
        ->where('created_by',$user->id)
        ->where('type','credit')
        ->where('transaction_payment_id','!=',null)
        ->where('type_transaction',1)
        ->where('deleted_at',NULL)
        ->whereDate('created_at', Carbon::today())
        ->sum('amount');

        $Receiverpaiment = DB::table('branch_transactions')
        ->where('branch_id',$user->branch_id)
        ->where('created_by',$user->id)
        ->where('type','credit')
        ->where('transaction_payment_id','!=',null)
        ->where('type_transaction','2')
        ->where('deleted_at',NULL)
        ->whereDate('created_at', Carbon::today())
        ->sum('amount');
      
    $transfertbranchSumReceiver=Paiement::where('branch_id',$user->branch_id)->where('user_id',$user->id)->where('transfert_id','!=',NULL)->whereDay('created_at', '=', date('d'))->sum('receiver_payer');

    $transfertbranchCount=Paiement::where('branch_id',$user->branch_id)->where('user_id',$user->id)->whereDate('created_at', Carbon::today())->count();

    $branch_transactions=Paiement::where('branch_id',$user->branch_id)->where('user_id',$user->id)->with('branch','transfert.sender','rdv.sender','agent')->whereDate('created_at', Carbon::today())->orderBy('id','DESC')->paginate(getPaginate());
    
    $emptyMessage="Aucune Transaction";
    
     // dd($branch_transactions);
    return view('staff.bilan.translist', compact('branch_transactions','pageTitle','rdvbranchSum','rdvbranchCount','transfertbranchCount','Senderpaiment','Receiverpaiment','emptyMessage'));

  }
  public function alltranslist(){
    $pageTitle = "Liste de Toutes Transactions";
    $user = Auth::user();
    $emptyMessage="Aucune Transactions en cours";

    $branch_transactions=Paiement::where('branch_id',$user->branch_id)->where('user_id',$user->id_)->where('deleted_at',NULL)->with('branch','transfert.sender','rdv.sender','agent')->orderBy('id','DESC')->paginate(getPaginate());

        return view('staff.bilan.alltranslist', compact('pageTitle','branch_transactions','emptyMessage'));


  }

  public function cash(){
      $user = Auth::user();
        $pageTitle = "Mes Bilans Journalier";
        $emptyMessage = "No data found";
        $branchSenderLists = Paiement::where('user_id', $user->id)
                    ->where('branch_id',$user->branch_id)
                    ->where('sender_branch_id',$user->branch_id)
                    ->select(DB::raw("SUM(sender_payer) as totalSenderAmount"))
                    ->orderBy('date_paiement','DESC')
                    ->groupBy('date_paiement')->paginate(getPaginate());
                    $branchReceiverLists = Paiement::where('user_id', $user->id)
                    ->where('branch_id',$user->branch_id)
                    ->Where('sender_branch_id','!=',$user->branch_id)
                    ->select(DB::raw("SUM(receiver_payer) as totalReceiverAmount"))
                    ->orderBy('date_paiement','DESC')
                    ->groupBy('date_paiement')->paginate(getPaginate());
                    //dd($branchReceiverLists);
        return view('staff.courier.cash', compact('pageTitle', 'emptyMessage', 'branchIncomeLists'));
  }
 public function depense(){
  $user = Auth::user();
  $pageTitle = "Mes Depenses Journalière";
  $emptyMessage = "No data found";
  $depenses=Depense::where('branch_id',$user->branch_id)
                ->orderBy('id','DESC')
                ->paginate(getPaginate());
                return view('staff.bilan.expense_list', compact('pageTitle', 'emptyMessage', 'depenses'));

 }
    public function create_expense(){
      $user = Auth::user();
      $pageTitle = "Ajouter une depense";
      $categorie = DepenseCategorie::where('branch_id',$user->branch_id)->get();
     // dd($categorie);
      return view('staff.bilan.expense_create', compact('pageTitle','categorie'));
    }

    public function store_expense(Request $request){
        $request->validate([
            'cat_id'=>'required',
            'montant'=>'numeric|gt:0'
        ]);
      $date_depense = date('Y-m-d');
      $user = Auth::user();
      $ajoutdepense= new Depense();
      $ajoutdepense->branch_id = $user->branch_id;
      $ajoutdepense->user_id =$user->id;
      $ajoutdepense->date = $date_depense;
      $ajoutdepense->montant =$request->montant;
      $ajoutdepense->description =$request->description;
      $ajoutdepense->cat_id =$request->cat_id;
      $ajoutdepense->save();

      return redirect()->route('staff.transaction.depense');


    }
    public function bilanDateSearch(Request $request){
     
      $user = Auth::user();
     
        $search = $request->date;
        if (!$search) {
            return back();
        }
        $date =date("Y-m-d", strtotime($search)); ;
  
        
      $transbranchCount = BranchTransaction::where('branch_id', $user->branch_id)->where('created_by',$user->id)->where('operation_date',$date)->count();
     // dd($transbranchCount);
      $rdvbranchSum=Paiement::where('branch_id',$user->branch_id)->where('user_id',$user->id)->where('rdv_id','!=',NULL)->where('date_paiement',$date)->sum('sender_payer','receiver_payer');
      $rdvbranchCount=Paiement::where('branch_id',$user->branch_id)->where('user_id',$user->id)->where('rdv_id','!=',NULL)->where('date_paiement',$date)->count();
     // DB::enableQueryLog();
        $Senderpaiment = DB::table('paiements')
          ->where('branch_id',$user->branch_id)
          ->where('sender_branch_id',$user->branch_id)
          ->where('user_id',$user->id)
          ->where('deleted_at',NULL)
          ->where('transfert_id','!=',NULL)
          ->where('date_paiement', '=', $date)
          ->sum('sender_payer');
  
          $oldReceiverpaiment = DB::table('paiements')
          ->where('branch_id',$user->branch_id)
          ->where('sender_branch_id','!=',$user->branch_id)
          ->where('transfert_id','!=',NULL)
          ->where('date_paiement', '=', $date)
          ->sum('receiver_payer');
          
        //   $Senderpaiment = DB::table('branch_transactions')
        //   ->where('branch_id',$user->branch_id)
        //   ->where('created_by',$user->id)
        //   ->where('type','credit')
        //   ->where('transaction_payment_id','!=',null)
        //   ->where('type_transaction','1')
        //   ->where('operation_date', '=', $date)
        //   ->sum('amount');
        // $Senderpaiment = DB::table('branch_transactions')
        // ->join('paiements','branch_transactions.transaction_payment_id','=','paiements.id')
        // ->where('branch_transactions.branch_id', $user->branch_id)
        // ->where('paiements.sender_branch_id',1)
        // ->where('paiements.branch_id',$user->branch_id)
        // ->where('created_by',$user->id)
        // ->where('type', 'credit')
        // ->where('transaction_payment_id', '!=', null)
        // ->where('type_transaction','!=',2) 
        // ->orWhereNull('type_transaction')
        // ->where('branch_transactions.deleted_at', NULL)
        // ->where('operation_date', '=', $date)
        // ->where('date_paiement', '=', $date)
        // ->sum('paiements.sender_payer');
        if($date < '2022-01-28'){
            $Chauffeur=DB::SELECT('select sum(`paiements`.`sender_payer`) as totalchauffeur  from `branch_transactions` inner join `paiements` on `branch_transactions`.`transaction_payment_id` = `paiements`.`id` where `branch_transactions`.`branch_id` = 1 and`branch_transactions`.`created_by` ="'.$user->id.'" and `paiements`.`sender_branch_id` = 1 and `type` = "credit" and `transaction_payment_id` is not null and `type_transaction` is null and `branch_transactions`.`deleted_at` is null and `paiements`.`deleted_at` is null and DATE(`branch_transactions`.`operation_date`) = "'.$date.'";');
    
            // $SenderpaimentChauffeur = DB::table('branch_transactions')
            // ->join('paiements','branch_transactions.transaction_payment_id','=','paiements.id')
            // ->where('branch_transactions.branch_id', 1)
            // ->where('paiements.sender_branch_id',1)
            // ->where('type', 'credit')
            // ->where('transaction_payment_id', '!=', null)
            // ->where('type_transaction','!=',2) 
            // ->orWhereNull('type_transaction')
            // ->where('branch_transactions.deleted_at', NULL)
            // ->where('operation_date','=',$date)
            // ->where('date_paiement','=',$date)
            // ->sum('paiements.sender_payer');
            $SenderpaimentChauffeur=$Chauffeur[0]->totalchauffeur;
          }else{
            $SenderpaimentChauffeur = DB::table('branch_transactions')
            ->where('branch_id', '1')
            ->where('created_by',$user->id)
            ->where('type', 'credit')
            ->where('transaction_payment_id', '!=', null)
            ->where('type_transaction', 1)
            ->where('deleted_at', NULL)
            ->where('operation_date','=',$date)
            ->sum('amount');
          }
  
          $Receiverpaiment = DB::table('branch_transactions')
          ->where('branch_id',$user->branch_id)
          ->where('created_by',$user->id)
          ->where('type','credit')
          ->where('transaction_payment_id','!=',null)
          ->where('type_transaction',2)
          ->where('operation_date', '=', $date)
          ->sum('amount');
         // dd(DB::getQueryLog());
  //dd($Senderpaiment);
         // ->select(DB::raw("*,SUM(receiver_payer) as totalReceiver"))
         // ->groupBy('date_paiement')
         // ->get();
       
          
  
  
      $transfertbranchSumReceiver=Paiement::where('branch_id',$user->branch_id)->where('user_id',$user->id)->where('transfert_id','!=',NULL)->where('date_paiement', '=', $date)->sum('receiver_payer');
  
      $transfertbranchCount=Paiement::where('branch_id',$user->branch_id)->where('user_id',$user->id)->where('date_paiement', '=', $date)->count();
  
      $branch_transactions=Paiement::where('branch_id',$user->branch_id)->where('user_id','=',$user->id)->with('branch','transfert.sender','rdv.sender','agent')->where('date_paiement', '=', $date)->orderBy('id','DESC')->paginate(getPaginate());
      
      $emptyMessage="Aucune Transaction";
      $pageTitle = "Mes Transactions du ".date("d-m-Y", strtotime($search));
       // dd($branch_transactions);
      return view('staff.bilan.translist', compact('branch_transactions','pageTitle','rdvbranchSum','rdvbranchCount','transfertbranchCount','Senderpaiment','Receiverpaiment','emptyMessage'));
  
    }

    public function edit($id){
      $pageTitle = "Modifier paiement ";
      $paiement=Paiement::where('refpaiement',(decrypt($id)))->first();
      //dd($paiement);
      return view('staff.bilan.edit_trans', compact('paiement','pageTitle'));

    }

    public function update(Request $request){
        $request->validate([
            'montant' => 'required|numeric|gt:0',
            'refpaiement'=>'required']);
      
                $user = Auth::user();
                $date_paiement = date('Y-m-d');
                $payer =Paiement::where('refpaiement',$request->refpaiement)->firstOrFail();
                $ref_trans=$payer->transfert_id;

                $transfert = Transfert::where('id', $ref_trans)->first();
                $transfertPayment = TransfertPayment::where('transfert_id', $ref_trans)->first();
          
        
                $amount = $request->montant;
        // dd($transfertPayment);
        if ($user->branch_id == $transfert->sender_branch_id) {
            if ($user->branch->country == 'CIV') {
                $sender_payer = $request->montant;
                $receiver_payer = $request->montant / 656;
                $totpayer = DB::table('paiements')
                    ->where('transfert_id', $transfert->id)
                    ->where('deleted_at',NULL)
                    ->get(DB::raw('SUM(sender_payer) AS deja_payer'));
            } else {
                $sender_payer = $request->montant;
                $receiver_payer = $request->montant * 656;
                $totpayer = DB::table('paiements')
                    ->where('transfert_id', $transfert->id)
                    ->where('deleted_at',NULL)
                    ->get(DB::raw('SUM(sender_payer) AS deja_payer'));
            }
        } else {
            if ($user->branch->country == 'CIV') {
                $receiver_payer = $request->montant;
                $sender_payer = $request->montant / 656;
                $totpayer = DB::table('paiements')
                    ->where('transfert_id', $transfert->id)
                    ->where('deleted_at',NULL)
                    ->get(DB::raw('SUM(receiver_payer) AS deja_payer'));
            } else {
                $receiver_payer = $request->montant;
                $sender_payer = $request->montant * 656;
                $totpayer = DB::table('paiements')
                    ->where('transfert_id', $transfert->id)
                    ->where('deleted_at',NULL)
                    ->get(DB::raw('SUM(receiver_payer) AS deja_payer'));
            }
        }
        //dd($receiver_payer);
        if ($transfertPayment->status == 3) {
            $notify[] = ['error', 'Paiement dejà enregistré'];
        } else {
            DB::beginTransaction();
            try {
                $user = Auth::user();
                // $rdvmontant->status='3';
                //$rdvmontant->save();
                $payment = TransfertPayment::where('transfert_id', $transfert->id)->first();

                $date_paiement = date('Y-m-d');
                $payer =Paiement::where('refpaiement',$request->refpaiement)->firstOrFail();
                $payer->user_id = $user->id;
                $payer->sender_payer = $sender_payer;
                $payer->receiver_payer = $receiver_payer;
                $payer->mode_paiement = $request->mode;
                if ($request->montant = $payment->amount) {
                    $payer->status = '2';
                } elseif ($request->montant < $payment->amount) {
                    $payer->status = '1';
                }
                $payer->save();
                $id_paiement=$payer->id;
                $branchtransaction = BranchTransaction::where('transaction_payment_id',$id_paiement)->update(["amount" =>$amount,"created_by" =>$user->id ]);
                // $branchtransaction->amount = $request->montant;
                // $branchtransaction->created_by = $user->id;
                // $branchtransaction->save();
                //dd($branchtransaction);
                $totalpayer = DB::table('paiements')
                    ->where('transfert_id', $transfert->id)
                    ->where('deleted_at',NULL)
                    ->get(DB::raw('SUM(receiver_payer) AS deja_payer'));
                //dd($totalpayer[0]->deja_payer );
                // $status_paye='';
                if ($totalpayer[0]->deja_payer < $payment->receiver_amount) {
                    $status_paye = '1';
                    // dd($status_paye);
                } elseif ($totalpayer[0]->deja_payer   == $payment->receiver_amount) {
                    $status_paye = '2';
                    // dd($status_paye); 
                } else {
                    $notify[] = ['error', 'Montant incorrect'];
                    DB::rollback();
                    return back()->withNotify($notify);
                }

                $update = TransfertPayment::where('transfert_id', $transfert->id)->update(array('status' => $status_paye));


                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $payment->transfert_senderid;
                $adminNotification->title = 'Paiement Transfert modifié '; //. $payment->transfert->client->nom
                $adminNotification->click_url = urlPath('staff.transfert.detail', $payment->transfert_id);
                $adminNotification->save();
                DB::commit();
                // }
                $paiements= new Paiement();
                if($payer){
                    activity('Modification Paiement')
                    ->performedOn($paiements)
                    ->causedBy($user)
                    ->withProperties(['customProperty' => 'customValue'])
                    ->log('Modification Paiement de '.$sender_payer.' Euro ajouté par ' . $user->username);
    
                }
               
                $notify[] = ['success', 'Paiement modifié avec succès'];
            } catch (Exception $e) {

                DB::rollback();
            }
        }
              //   if($user->branch->country == 'FRA'){
              //     $payer->sender_payer = $request->montant;
              //     $payer->receiver_payer = $request->montant * 656;
              //   }elseif($user->branch->country == 'CIV' && $payer->sender_branch_id != $user->branch_id){
              //     $payer->sender_payer = $request->montant / 656;
              //     $payer->receiver_payer = $request->montant;
              //   }
               
              //   $payer->mode_paiement = $request->mode;
              //   $payer->date_paiement = $date_paiement; 
              //   $payer->save();
              //   $id_paiement=$payer->id;
              //   $ref_trans=$payer->transfert_id;

              //   $adminNotification = new AdminNotification();
              //   $adminNotification->user_id = $user->id;
              //   $adminNotification->title = 'Paiement Transfert modifier ' . $user->username;
              //   $adminNotification->click_url = urlPath('admin.courier.info.details', $id_paiement);
              //   $adminNotification->save();

              //   $branchtransaction = BranchTransaction::where('transaction_payment_id',$id_paiement)->firstOrFail();
              //   $branchtransaction->branch_id = $user->branch_id;
              //   $branchtransaction->amount = $request->montant;
              //   $branchtransaction->operation_date= $date_paiement;
              //   $branchtransaction->created_by = $user->id;
              //   $branchtransaction->save();

              //   $prix=Transfertpayment::where('transfert_id',$ref_trans)->get('sender_amount');
              //  // dd($prix[0]->sender_amount);
              //   $deja_payer=Paiement::where('transfert_id',$ref_trans)->where('branch_id',$user->branch_id)->sum('sender_payer');
                
             
               // dd($branchtransaction);
              

                return redirect()->route('staff.transaction.list')->withNotify($notify);
    }

    public function delete_paiement (Request $request){
        $user = Auth::user();
        $paiement=Paiement::where('refpaiement',$request->refpaiement)->first();
        //dd($paiement);
        $trans_ref = $paiement->transfert_id;
        $paie_id = $paiement->id;
        $branchtransaction = BranchTransaction::where('transaction_payment_id',$paie_id)->delete();
        $paiement=Paiement::where('refpaiement',$request->refpaiement)->delete();
       
       
        //ACTIVITY LOG

       
        $test=Paiement::where('transfert_id',$trans_ref)->get();
        $payment = TransfertPayment::where('transfert_id', $trans_ref)->first();

        $status_paye ='';
        if ($test) {
            $totalpayer = DB::table('paiements')
                ->where('transfert_id',  $trans_ref)
                ->where('deleted_at', NULL)
                ->get(DB::raw('SUM(receiver_payer) AS deja_payer'));

            if ($totalpayer[0]->deja_payer > 0 && $totalpayer[0]->deja_payer < $payment->receiver_amount) {
                $status_paye = '1';
            }else{
                $status_paye = 0;
            }
            // } elseif ($totalpayer[0]->deja_payer == $payment->receiver_amount) {
            //     $status_paye = '2';
            // } else {
            //     $notify[] = ['error', 'Montant incorrect'];
            //     DB::rollback();
            //     return back()->withNotify($notify);
            // }
        } else {
            $status_paye = 0;
        }
         $update = TransfertPayment::where('transfert_id',$trans_ref)->update(array('status' => $status_paye));
        $paiements= new Paiement();
         if($paiement){
            activity('Suppression Paiement')
            ->performedOn($paiements)
            ->causedBy($user)
            ->withProperties(['customProperty' => 'customValue'])
            ->log('Paiement supprimé par' . $user->username);

        }
         
         $notify[] = ['success', 'Paiement supprimé avec succès'];
         return back()->withNotify($notify);
    }
    public function agencetranslist(Request $request)
    {
        $pageTitle = "Bilan Agence";
        $user = Auth::user();
        $transbranchCount = BranchTransaction::where('branch_id', $user->branch_id)->count();

        $rdvbranchSum = Paiement::where('branch_id', $user->branch_id)->where('rdv_id', '!=', NULL)->whereDate('created_at', Carbon::today())->sum('sender_payer', 'receiver_payer');
        $rdvbranchCount = Paiement::where('branch_id', $user->branch_id)->where('rdv_id', '!=', NULL)->whereDate('created_at', Carbon::today())->count();
        

        $oldReceiverpaiment = DB::table('paiements')
            ->where('branch_id', $user->branch_id)
            ->where('sender_branch_id', '!=', $user->branch_id)
            ->where('transfert_id', '!=', NULL)
            ->where('deleted_at', NULL)
            ->whereDate('created_at', Carbon::today())
            ->sum('receiver_payer');

        
        $Senderpaiment =  DB::table('branch_transactions')
        ->where('branch_id', $user->branch_id)
        ->where('type', 'credit')
        ->where('transaction_payment_id', '!=', null)
        ->where('type_transaction', '1')
        ->where('deleted_at', NULL)
        ->whereDate('created_at', Carbon::today())
        ->sum('amount');

        $Receiverpaiment = DB::table('branch_transactions')
            ->where('branch_id', $user->branch_id)
            ->where('type', 'credit')
            ->where('transaction_payment_id', '!=', null)
            ->where('type_transaction', '2')
            ->where('deleted_at', NULL)
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');

        $Depenses = DB::table('depenses')
            ->where('branch_id', $user->branch_id)
            ->where('deleted_at', NULL)
           // ->whereDay('date', '=', date('d')) 
            ->whereDate('created_at', Carbon::today())
            ->sum('montant');


        $transfertbranchSumReceiver = Paiement::where('branch_id', $user->branch_id)->where('transfert_id', '!=', NULL)->whereDate('created_at', Carbon::today())->sum('receiver_payer');

        $transfertbranchCount = Paiement::where('branch_id', $user->branch_id)->whereDate('created_at', Carbon::today())->count();
        $branch_transactions = Paiement::where('branch_id', $user->branch_id)->with('branch', 'transfert.sender', 'rdv.sender', 'agent')->whereDate('created_at', Carbon::today())->orderBy('id', 'DESC')->paginate(getPaginate());

        $emptyMessage = "Aucune Transaction";

        // dd($branch_transactions);
        return view('staff.bilan.agencetranslist', compact('branch_transactions', 'pageTitle', 'rdvbranchSum', 'rdvbranchCount', 'transfertbranchCount', 'Senderpaiment', 'Receiverpaiment', 'emptyMessage', 'Depenses'));
    }

    public function store_categorie(Request $request)
    {
        $user = Auth::user();
        $categorie = DB::INSERT("INSERT INTO `categorie_depenses`(`branch_id`, `nom`, `description`) VALUES ('$user->branch_id','$request->nom','$request->description')");
        $notify[] = ['success', 'Categorie créé avec succès'];
        return back()->withNotify($notify);
    }
    public function update_depense(Request $request)
    {
        $request->validate([
            'cat_id'=>'required',
            'montant'=>'numeric|gt:0'
        ]);
        $date_depense = date('Y-m-d');
        $user = Auth::user();
        $ajoutdepense = Depense::where('id', $request->id)->firstOrFail();

        $ajoutdepense->user_id = $user->id;
        $ajoutdepense->date = $date_depense;
        $ajoutdepense->montant = $request->montant;
        $ajoutdepense->description = $request->description;
        $ajoutdepense->cat_id = $request->cat_id;
        $ajoutdepense->save();

                    $adminNotification = new AdminNotification();
                    $adminNotification->user_id = $user->id;
                    $adminNotification->title = 'Depense Modifiée ' . $user->username;
                    $adminNotification->click_url = urlPath('admin.courier.info.details', $request->refpaiement);
                    $adminNotification->save();
        $notify[] = ['success', 'Depense Modifié avec succès'];

        return redirect()->route('staff.transaction.depense')->withNotify($notify);
    }
    public function delete_depense(Request $request)
    {
        $user = Auth::user();
        $delete = Depense::where('id', $request->refpaiement)->delete();
        $adminNotification = new AdminNotification();
                    $adminNotification->user_id = $user->id;
                    $adminNotification->title = 'Depense Supprimé ' . $user->username;
                    $adminNotification->click_url = urlPath('admin.courier.info.details', $request->refpaiement);
                    $adminNotification->save();
        $notify[] = ['success', 'Depense supprimée avec succès'];
        return back()->withNotify($notify);
    }
    public function agencebilanDateSearch(Request $request)
    {

        $user = Auth::user();

        $search = $request->date;
        if (!$search) {
            return back();
        }
        $date = date("Y-m-d", strtotime($search));;


        $transbranchCount = BranchTransaction::where('branch_id', $user->branch_id)->where('operation_date', $date)->count();
        // dd($transbranchCount);
        $rdvbranchSum = Paiement::where('branch_id', $user->branch_id)->where('rdv_id', '!=', NULL)->where('date_paiement','=', $date)->sum('sender_payer', 'receiver_payer');
        $rdvbranchCount = Paiement::where('branch_id', $user->branch_id)->where('rdv_id', '!=', NULL)->where('date_paiement', $date)->count();
        // DB::enableQueryLog();
        // $Senderpaiment = DB::table('paiements')
        //     ->where('branch_id', $user->branch_id)
        //     ->where('sender_branch_id', $user->branch_id)
        //     ->where('transfert_id', '!=', NULL)
        //     ->where('date_paiement', '=', $date)
        //     ->sum('sender_payer');

        $oldReceiverpaiment = DB::table('paiements')
            ->where('branch_id', $user->branch_id)
            ->where('sender_branch_id', '!=', $user->branch_id)
            ->where('transfert_id', '!=', NULL)
            ->where('date_paiement', '=', $date)
            ->sum('receiver_payer');

        // $Senderpaiment = DB::table('branch_transactions')
        //     ->where('branch_id', $user->branch_id)

        //     ->where('type', 'credit')
        //     ->where('transaction_payment_id', '!=', null)
        //     ->where('type_transaction', '1')
        //     ->where('operation_date', '=', $date)
        //     ->sum('amount');
        // $Senderpaiment = DB::table('branch_transactions')
        //     ->join('paiements','branch_transactions.transaction_payment_id','=','paiements.id')
        //     ->where('branch_transactions.branch_id', $user->branch_id)
        //     ->where('paiements.sender_branch_id',1)
        //     ->where('type', 'credit')
        //     ->where('transaction_payment_id', '!=', null)
        //     ->where('type_transaction','!=',2) 
        //     ->orWhereNull('type_transaction')
        //     ->where('branch_transactions.deleted_at', NULL)
        //     ->where('date_paiement', '=', $date)
        //     ->where('operation_date', '=', $date)
        //     ->sum('paiements.sender_payer');

            if($date < '2022-01-28'){
                $Chauffeur=DB::SELECT('select sum(`paiements`.`sender_payer`) as totalchauffeur  from `branch_transactions` inner join `paiements` on `branch_transactions`.`transaction_payment_id` = `paiements`.`id` where `branch_transactions`.`branch_id` = 1 and `paiements`.`sender_branch_id` = 1 and `type` = "credit" and `transaction_payment_id` is not null and `type_transaction` is null and `branch_transactions`.`deleted_at` is null and `paiements`.`deleted_at` is null and DATE(`branch_transactions`.`operation_date`) = "'.$date.'";');
        
               
                $Senderpaiment=$Chauffeur[0]->totalchauffeur;
              }else{
                $Senderpaiment = DB::table('branch_transactions')
                ->where('branch_id', '1')
                ->where('type', 'credit')
                ->where('transaction_payment_id', '!=', null)
                ->where('type_transaction', 1)
                ->where('deleted_at', NULL)
                ->where('operation_date','=',$date)
                ->sum('amount');
              }

        $Receiverpaiment = DB::table('branch_transactions')
            ->where('branch_id', $user->branch_id)
            ->where('type', 'credit')
            ->where('transaction_payment_id', '!=', null)
            ->where('type_transaction', '2')
            ->where('operation_date', '=', $date)
            ->sum('amount');

        $Depenses = DB::table('depenses')
            ->where('branch_id', $user->branch_id)
            ->where('deleted_at', NULL)
            ->whereDate('created_at','=',Carbon::parse($date))
           // ->whereDay('date', '=', $date)
            ->sum('montant');

        $transfertbranchSumReceiver = Paiement::where('branch_id', $user->branch_id)->where('transfert_id', '!=', NULL)->where('date_paiement', '=', $date)->sum('receiver_payer');

        $transfertbranchCount = Paiement::where('branch_id', $user->branch_id)->where('date_paiement', '=', $date)->count();

        $branch_transactions = Paiement::where('branch_id', $user->branch_id)->with('branch', 'transfert.sender', 'rdv.sender', 'agent')->where('date_paiement', '=', $date)->orderBy('id', 'DESC')->paginate(getPaginate());
        $emptyMessage = "Aucune Transaction";
        $pageTitle = "Bilan du " . date("d-m-Y", strtotime($search));
        // dd($branch_transactions);
        return view('staff.bilan.agencetranslist', compact('branch_transactions', 'pageTitle', 'rdvbranchSum', 'rdvbranchCount', 'transfertbranchCount', 'Senderpaiment', 'Receiverpaiment', 'emptyMessage', 'Depenses'));
    }
    public function get_depense($id)
    {
        $user = Auth::user();
        $pageTitle = "Modifier depense";
        $depense = Depense::where('id', decrypt($id))->with('categorie')->first();
        $categorie = DepenseCategorie::where('branch_id', $user->branch_id)->get();
        // dd($categorie);
        return view('staff.bilan.expense_edit', compact('pageTitle', 'categorie', 'depense'));
    }
    public function expenseDateSearch(Request $request)
    {
        $user = Auth::user();
        $search = $request->date;
        if (!$search) {
            return back();
        }
        $date = explode('-',$search);
        $start = @$date[0];
        $end = @$date[1];
        $pattern = "/\d{2}\/\d{2}\/\d{4}/";
        if ($start && !preg_match($pattern,$start)) {
            $notify[] = ['error','Invalid date format'];
            return redirect()->route('staff.transaction.depense')->withNotify($notify);
        }
        if ($end && !preg_match($pattern,$end)) {
            $notify[] = ['error','Invalid date format'];
            return redirect()->route('staff.transaction.depense')->withNotify($notify);
        }
        $pageTitle = "Recherche Depenses";
        $dateSearch = $search;
        $emptyMessage = "Aucune Depense";
        $depenses = Depense::with('staff', 'categorie')->whereBetween('created_at', [Carbon::parse($start), Carbon::parse($end)])->orderBy('id', 'DESC')->paginate(getPaginate());

        return view('staff.bilan.expense_list', compact('pageTitle', 'emptyMessage', 'depenses'));

    }

    public function recupaiement($id)
    {
        $pageTitle = "Reçu de paiement";
       $userInfo = Auth::user();
       $paymentTransfert=Paiement::where('refpaiement',decrypt($id))->first();
       $courierInfo = Transfert::where('id', $paymentTransfert->transfert_id)->first();
       $courierProductInfos = TransfertProduct::where('transfert_id', $paymentTransfert->transfert_id)->with('type')->get();
       $courierProductRef = TransfertRef::where('transfert_id', $paymentTransfert->transfert_id)->get();
       $courierPayment = TransfertPayment::where('transfert_id', $paymentTransfert->transfert_id)->first();
       $code = '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($courierInfo->code, 'C128') . '" alt="barcode"   />' . "<br>" . $courierInfo->code;
       return view('staff.transfert.recu', compact('pageTitle', 'courierInfo', 'courierProductRef', 'courierProductInfos', 'courierPayment', 'userInfo', 'code','paymentTransfert'));
       
    }

    public function agenceDateSearch(Request $request)
    {

        $user = Auth::user();
        $search = $request->date;
        if (!$search) {
            return back();
        }
        $date = explode('-',$search);
        $start = @$date[0];
        $end = @$date[1];
        $pattern = "/\d{2}\/\d{2}\/\d{4}/";
        if ($start && !preg_match($pattern,$start)) {
            $notify[] = ['error','Invalid date format'];
            return redirect()->route('admin.courier.info.index')->withNotify($notify);
        }
        if ($end && !preg_match($pattern,$end)) {
            $notify[] = ['error','Invalid date format'];
            return redirect()->route('staff.transaction.depense')->withNotify($notify);
        }

        // $search = $request->date;
        // if (!$search) {
        //     return back();
        // }
        // $date = date("Y-m-d", strtotime($search));;


        $transbranchCount = BranchTransaction::where('branch_id', $user->branch_id)->where('operation_date', $date)->count();
        // dd($transbranchCount);
        $rdvbranchSum = Paiement::where('branch_id', $user->branch_id)->where('rdv_id', '!=', NULL)->where('date_paiement','=', $date)->sum('sender_payer', 'receiver_payer');
        $rdvbranchCount = Paiement::where('branch_id', $user->branch_id)->where('rdv_id', '!=', NULL)->where('date_paiement', $date)->count();
        // DB::enableQueryLog();
        // $Senderpaiment = DB::table('paiements')
        //     ->where('branch_id', $user->branch_id)
        //     ->where('sender_branch_id', $user->branch_id)
        //     ->where('transfert_id', '!=', NULL)
        //     ->where('date_paiement', '=', $date)
        //     ->sum('sender_payer');

        $oldReceiverpaiment = DB::table('paiements')
            ->where('branch_id', $user->branch_id)
            ->where('sender_branch_id', '!=', $user->branch_id)
            ->where('transfert_id', '!=', NULL)
            ->where('date_paiement', '=', $date)
            ->sum('receiver_payer');

        // $Senderpaiment = DB::table('branch_transactions')
        //     ->where('branch_id', $user->branch_id)

        //     ->where('type', 'credit')
        //     ->where('transaction_payment_id', '!=', null)
        //     ->where('type_transaction', '1')
        //     ->where('operation_date', '=', $date)
        //     ->sum('amount');
        // $Senderpaiment = DB::table('branch_transactions')
        //     ->join('paiements','branch_transactions.transaction_payment_id','=','paiements.id')
        //     ->where('branch_transactions.branch_id', $user->branch_id)
        //     ->where('paiements.sender_branch_id',1)
        //     ->where('type', 'credit')
        //     ->where('transaction_payment_id', '!=', null)
        //     ->where('type_transaction','!=',2) 
        //     ->orWhereNull('type_transaction')
        //     ->where('branch_transactions.deleted_at', NULL)
        //     ->where('date_paiement', '=', $date)
        //     ->where('operation_date', '=', $date)
        //     ->sum('paiements.sender_payer');

            if($date < '2022-01-28'){
                $Chauffeur=DB::SELECT('select sum(`paiements`.`sender_payer`) as totalchauffeur  from `branch_transactions` inner join `paiements` on `branch_transactions`.`transaction_payment_id` = `paiements`.`id` where `branch_transactions`.`branch_id` = 1 and `paiements`.`sender_branch_id` = 1 and `type` = "credit" and `transaction_payment_id` is not null and `type_transaction` is null and `branch_transactions`.`deleted_at` is null and `paiements`.`deleted_at` is null and DATE(`branch_transactions`.`operation_date`) = "'.$date.'";');
        
               
                $Senderpaiment=$Chauffeur[0]->totalchauffeur;
              }else{
                $Senderpaiment = DB::table('branch_transactions')
                ->where('branch_id', '1')
                ->where('type', 'credit')
                ->where('transaction_payment_id', '!=', null)
                ->where('type_transaction', 1)
                ->where('deleted_at', NULL)
                ->where('operation_date','=',$date)
                ->sum('amount');
              }

        $Receiverpaiment = DB::table('branch_transactions')
            ->where('branch_id', $user->branch_id)
            ->where('type', 'credit')
            ->where('transaction_payment_id', '!=', null)
            ->where('type_transaction', '2')
            ->where('operation_date', '=', $date)
            ->sum('amount');

        $Depenses = DB::table('depenses')
            ->where('branch_id', $user->branch_id)
            ->where('deleted_at', NULL)
            ->whereDay('date', '=', $date)
            ->sum('montant');

        $transfertbranchSumReceiver = Paiement::where('branch_id', $user->branch_id)->where('transfert_id', '!=', NULL)->where('date_paiement', '=', $date)->sum('receiver_payer');

        $transfertbranchCount = Paiement::where('branch_id', $user->branch_id)->where('date_paiement', '=', $date)->count();

        $branch_transactions = Paiement::where('branch_id', $user->branch_id)->with('branch', 'transfert.sender', 'rdv.sender', 'agent')->where('date_paiement', '=', $date)->orderBy('id', 'DESC')->paginate(getPaginate());
        $emptyMessage = "Aucune Transaction";
        $pageTitle = "Bilan du " . date("d-m-Y", strtotime($search));
        // dd($branch_transactions);
        return view('staff.bilan.agencetranslist', compact('branch_transactions', 'pageTitle', 'rdvbranchSum', 'rdvbranchCount', 'transfertbranchCount', 'Senderpaiment', 'Receiverpaiment', 'emptyMessage', 'Depenses'));
    }

    public function agencebilanDateSearchTwo(Request $request)
    {

        $user = Auth::user();
        $search = $request->date;
        if (!$search) {
            return back();
        }
        $date = explode('-',$search);
        $start = @$date[0];
        $end = @$date[1];
        $pattern = "/\d{2}\/\d{2}\/\d{4}/";
        if ($start && !preg_match($pattern,$start)) {
            $notify[] = ['error','Invalid date format'];
            return redirect()->route('staff.bilan.agencetranslist')->withNotify($notify);
        }
        if ($end && !preg_match($pattern,$end)) {
            $notify[] = ['error','Invalid date format'];
            return redirect()->route('staff.bilan.agencetranslist')->withNotify($notify);
        }

        // $search = $request->date;
        // if (!$search) {
        //     return back();
        // }
        // $date = date("Y-m-d", strtotime($search));;


        $transbranchCount = BranchTransaction::where('branch_id', $user->branch_id)->whereBetween('created_at', [Carbon::parse($start), Carbon::parse($end)])->count();
        // dd($transbranchCount);
        $rdvbranchSum = Paiement::where('branch_id', $user->branch_id)->where('rdv_id', '!=', NULL)->whereBetween('created_at', [Carbon::parse($start), Carbon::parse($end)])->sum('sender_payer', 'receiver_payer');
        $rdvbranchCount = Paiement::where('branch_id', $user->branch_id)->where('rdv_id', '!=', NULL)->whereBetween('created_at', [Carbon::parse($start), Carbon::parse($end)])->count();
        // DB::enableQueryLog();
        // $Senderpaiment = DB::table('paiements')
        //     ->where('branch_id', $user->branch_id)
        //     ->where('sender_branch_id', $user->branch_id)
        //     ->where('transfert_id', '!=', NULL)
        //     ->where('date_paiement', '=', $date)
        //     ->sum('sender_payer');

        $oldReceiverpaiment = DB::table('paiements')
            ->where('branch_id', $user->branch_id)
            ->where('sender_branch_id', '!=', $user->branch_id)
            ->where('transfert_id', '!=', NULL)
            ->whereDate('created_at','>=',Carbon::parse($start))
            ->whereDate('created_at','<=',Carbon::parse($end))
            ->sum('receiver_payer');

        // $Senderpaiment = DB::table('branch_transactions')
        //     ->where('branch_id', $user->branch_id)

        //     ->where('type', 'credit')
        //     ->where('transaction_payment_id', '!=', null)
        //     ->where('type_transaction', '1')
        //     ->where('operation_date', '=', $date)
        //     ->sum('amount');
        // $Senderpaiment = DB::table('branch_transactions')
        //     ->join('paiements','branch_transactions.transaction_payment_id','=','paiements.id')
        //     ->where('branch_transactions.branch_id', $user->branch_id)
        //     ->where('paiements.sender_branch_id',1)
        //     ->where('type', 'credit')
        //     ->where('transaction_payment_id', '!=', null)
        //     ->where('type_transaction','!=',2) 
        //     ->orWhereNull('type_transaction')
        //     ->where('branch_transactions.deleted_at', NULL)
        //     ->where('date_paiement', '=', $date)
        //     ->where('operation_date', '=', $date)
        //     ->sum('paiements.sender_payer');

            if($date < '2022-01-28'){
                $Chauffeur=DB::SELECT('select sum(`paiements`.`sender_payer`) as totalchauffeur  from `branch_transactions` inner join `paiements` on `branch_transactions`.`transaction_payment_id` = `paiements`.`id` where `branch_transactions`.`branch_id` = 1 and `paiements`.`sender_branch_id` = 1 and `type` = "credit" and `transaction_payment_id` is not null and `type_transaction` is null and `branch_transactions`.`deleted_at` is null and `paiements`.`deleted_at` is null and DATE(`branch_transactions`.`operation_date`) = "'.$date.'";');
        
               
                $Senderpaiment=$Chauffeur[0]->totalchauffeur;
              }else{
                $Senderpaiment = DB::table('branch_transactions')
                ->where('branch_id', '1')
                ->where('type', 'credit')
                ->where('transaction_payment_id', '!=', null)
                ->where('type_transaction', 1)
                ->where('deleted_at', NULL)
                ->whereDate('created_at','>=',Carbon::parse($start))
                ->whereDate('created_at','<=',Carbon::parse($end))
                ->sum('amount');
              }

        $Receiverpaiment = DB::table('branch_transactions')
            ->where('branch_id', $user->branch_id)
            ->where('type', 'credit')
            ->where('transaction_payment_id', '!=', null)
            ->where('type_transaction', '2')
            ->whereDate('created_at','>=',Carbon::parse($start))
            ->whereDate('created_at','<=',Carbon::parse($end))
            ->sum('amount');

        $Depenses = DB::table('depenses')
            ->where('branch_id', $user->branch_id)
            ->where('deleted_at', NULL)
            ->whereDate('created_at','>=',Carbon::parse($start))
            ->whereDate('created_at','<=',Carbon::parse($end))
            ->sum('montant');

        $transfertbranchSumReceiver = Paiement::where('branch_id', $user->branch_id)->where('transfert_id', '!=', NULL)->whereBetween('created_at', [Carbon::parse($start), Carbon::parse($end)])->sum('receiver_payer');

        $transfertbranchCount = Paiement::where('branch_id', $user->branch_id)->whereBetween('created_at', [Carbon::parse($start), Carbon::parse($end)])->count();

        $branch_transactions = Paiement::where('branch_id', $user->branch_id)->with('branch', 'transfert.sender', 'rdv.sender', 'agent')->whereBetween('created_at', [Carbon::parse($start), Carbon::parse($end)])->orderBy('id', 'DESC')->paginate(getPaginate());
        $emptyMessage = "Aucune Transaction";
        $pageTitle = 'Bilan du ' . date("d-m-Y", strtotime($start)).' au '.date("d-m-Y", strtotime($end));
        // dd($branch_transactions);
        return view('staff.bilan.agencetranslist', compact('branch_transactions', 'pageTitle', 'rdvbranchSum', 'rdvbranchCount', 'transfertbranchCount', 'Senderpaiment', 'Receiverpaiment', 'emptyMessage', 'Depenses'));
    }
    
    public function export_list(Request $request) {
    $user = Auth::user();
   $branch_id=$user->branch_id;
   $year= $request->year;
   $type=$request->type;
   
   return Excel::download( new BilanExportMapping($branch_id,$year,$type), 'listbilan.xlsx') ;
   
    }
        public function encoursAbidjan(){
           $emptyMessage = "No data found";
            $monthStart = Carbon::now()->startOfMonth();
            $monthEnd = Carbon::now()->endOfMonth();
        
                     $encours=TransfertPayment::select(
                    'transfert_payments.transfert_id as transfert_id',
                    'transfert_payments.receiver_amount as prix','transfert_payments.created_at as date','transfert_payments.status as infopaiement',
                    DB::raw('SUM(paiements.receiver_payer) as montant_total_paye'),
                    DB::raw('(transfert_payments.receiver_amount - COALESCE(SUM(paiements.receiver_payer), 0)) as reste_a_payer'),
                    'clients.nom as client','clients.contact as contact','transferts.reference_souche as reference')
                    ->leftJoin('paiements', 'transfert_payments.transfert_id', '=', 'paiements.transfert_id')
                    ->leftJoin('clients', 'transfert_payments.transfert_receiverid', '=', 'clients.id') // Joindre la table "clients"
                    ->leftJoin('transferts', 'transfert_payments.transfert_id', '=', 'transferts.id') // Joindre la table "clients"
                    ->whereNull('transfert_payments.deleted_at')
                    ->whereIn('transfert_payments.status', [0, 1])  // Condition modifiée ici
                    ->whereIn('transferts.status',[1,2])
                    ->whereBetween('transfert_payments.created_at', [$monthStart, $monthEnd])
                    ->groupBy('transfert_payments.transfert_id', 'transfert_payments.receiver_amount')
                    ->orderBy('reste_a_payer','DESC')
                    ->paginate(getPaginate());
                    $totalResteAPayer = $encours->sum('reste_a_payer');
                   // dd($encours);
                         $pageTitle = "Encours du mois en cours " ;
                         return view('staff.bilan.encoursabidjan', compact('pageTitle','emptyMessage','encours','totalResteAPayer'));
                
                   // dd($encours);
         }
        
        public function encoursParis(){
                       $emptyMessage = "No data found";
                        $monthStart = Carbon::now()->startOfMonth();
                        $monthEnd = Carbon::now()->endOfMonth();
        
                            $encours=TransfertPayment::select(
                            'transfert_payments.transfert_id as transfert_id',
                            'transfert_payments.sender_amount as prix','transfert_payments.created_at as date','transfert_payments.status as infopaiement',
                            DB::raw('SUM(paiements.sender_payer) as montant_total_paye'),
                            DB::raw('(transfert_payments.sender_amount - COALESCE(SUM(paiements.sender_payer), 0)) as reste_a_payer'),
                            'clients.nom as client','clients.contact as contact','transferts.reference_souche as reference')
                            ->leftJoin('paiements', 'transfert_payments.transfert_id', '=', 'paiements.transfert_id')
                            ->leftJoin('clients', 'transfert_payments.transfert_receiverid', '=', 'clients.id') // Joindre la table "clients"
                            ->leftJoin('transferts', 'transfert_payments.transfert_id', '=', 'transferts.id') // Joindre la table "clients"
                            ->whereNull('transfert_payments.deleted_at')
                            ->whereIn('transfert_payments.status', [0, 1])  // Condition modifiée ici
                            ->whereIn('transferts.status',[1,2])
                            ->whereBetween('transfert_payments.created_at', [$monthStart, $monthEnd])
                            ->groupBy('transfert_payments.transfert_id', 'transfert_payments.sender_amount')
                            ->orderBy('reste_a_payer','DESC')
                            ->paginate(getPaginate());
                            $totalResteAPayer = $encours->sum('reste_a_payer');
                           // dd($encours);
                                 $pageTitle = "Encours du mois en cours " ;
                                 return view('staff.bilan.encoursparis', compact('pageTitle','emptyMessage','encours','totalResteAPayer'));

        }
        
        public function encoursDateSearchAbidjan(Request $request){
                        $search = $request->date;
                        if (!$search) {
                            return back();
                        }
                        $date = explode('-',$search);
                        $start = @$date[0];
                        $end = @$date[1];
                        $pattern = "/\d{2}\/\d{2}\/\d{4}/";
                        if ($start && !preg_match($pattern,$start)) {
                            $notify[] = ['error','Invalid date format'];
                            return redirect()->route('admin.boss.encours')->withNotify($notify);
                        }
                        if ($end && !preg_match($pattern,$end)) {
                            $notify[] = ['error','Invalid date format'];
                            return redirect()->route('staff.bilan.encoursabidjan')->withNotify($notify);
                        }
                       
                        $pageTitle = "liste des Encours du ".date("d-m-Y", strtotime($start))." au ".date("d-m-Y", strtotime($end));
                        $emptyMessage = "No data found";
                     $encours=TransfertPayment::select(
                        'transfert_payments.transfert_id as transfert_id',
                        'transfert_payments.receiver_amount as prix','transfert_payments.created_at as date','transfert_payments.status as infopaiement',
                        DB::raw('SUM(paiements.receiver_payer) as montant_total_paye'),
                        DB::raw('(transfert_payments.receiver_amount - COALESCE(SUM(paiements.receiver_payer), 0)) as reste_a_payer'),
                    'clients.nom as client','clients.contact as contact','transferts.reference_souche as reference')
                    ->leftJoin('paiements', 'transfert_payments.transfert_id', '=', 'paiements.transfert_id')
                    ->leftJoin('clients', 'transfert_payments.transfert_receiverid', '=', 'clients.id') // Joindre la table "clients"
                    ->leftJoin('transferts', 'transfert_payments.transfert_id', '=', 'transferts.id') // Joindre la table "clients"
                    ->whereNull('transfert_payments.deleted_at')
                    ->whereIn('transfert_payments.status', [0, 1])  // Condition modifiée ici
                    ->whereIn('transferts.status',[1,2])
                    ->whereBetween('transfert_payments.created_at', [Carbon::parse($start), Carbon::parse($end)])
                    ->groupBy('transfert_payments.transfert_id', 'transfert_payments.receiver_amount')
                    ->orderBy('reste_a_payer','DESC')
                    ->paginate(getPaginate());
                    $totalResteAPayer = $encours->sum('reste_a_payer');
                     return view('staff.bilan.encoursabidjan', compact('pageTitle','emptyMessage','encours','totalResteAPayer'));
        
        }
        
        public function encoursDateSearchParis(Request $request){
                        $search = $request->date;
                        if (!$search) {
                            return back();
                        }
                        $date = explode('-',$search);
                        $start = @$date[0];
                        $end = @$date[1];
                        $pattern = "/\d{2}\/\d{2}\/\d{4}/";
                        if ($start && !preg_match($pattern,$start)) {
                            $notify[] = ['error','Invalid date format'];
                            return redirect()->route('staff.bilan.encoursparis')->withNotify($notify);
                        }
                        if ($end && !preg_match($pattern,$end)) {
                            $notify[] = ['error','Invalid date format'];
                            return redirect()->route('staff.bilan.encoursparis')->withNotify($notify);
                        }
                       
                        $pageTitle = "liste des Encours du ".date("d-m-Y", strtotime($start))." au ".date("d-m-Y", strtotime($end));
                        $emptyMessage = "No data found";
                        $encours=TransfertPayment::select(
                    'transfert_payments.transfert_id as transfert_id',
                    'transfert_payments.sender_amount as prix','transfert_payments.created_at as date','transfert_payments.status as infopaiement',
                    DB::raw('SUM(paiements.sender_payer) as montant_total_paye'),
                    DB::raw('(transfert_payments.sender_amount - COALESCE(SUM(paiements.sender_payer), 0)) as reste_a_payer'),
                    'clients.nom as client','clients.contact as contact','transferts.reference_souche as reference')
                    ->leftJoin('paiements', 'transfert_payments.transfert_id', '=', 'paiements.transfert_id')
                    ->leftJoin('clients', 'transfert_payments.transfert_receiverid', '=', 'clients.id') // Joindre la table "clients"
                    ->leftJoin('transferts', 'transfert_payments.transfert_id', '=', 'transferts.id') // Joindre la table "clients"
                    ->whereNull('transfert_payments.deleted_at')
                    ->whereIn('transfert_payments.status', [0, 1])  // Condition modifiée ici
                     ->whereIn('transferts.status',[1,2])
                    ->whereBetween('transfert_payments.created_at', [Carbon::parse($start), Carbon::parse($end)])
                    ->groupBy('transfert_payments.transfert_id', 'transfert_payments.sender_amount')
                    ->orderBy('reste_a_payer','DESC')
                    ->paginate(getPaginate());
                    $totalResteAPayer = $encours->sum('reste_a_payer');
                    return view('staff.bilan.encoursparis', compact('pageTitle','emptyMessage','encours','totalResteAPayer'));
        
        }
        
         public function export_encoursparis(Request $request) {
                $user = Auth::user();
                $branch_id=$user->branch_id;
               
                    $search = $request->date;
                    if (!$search) {
                        return back();
                    }
                    $date = explode('-',$search);
                    $start = @$date[0];
                    $end = @$date[1];
                    $pattern = "/\d{2}\/\d{2}\/\d{4}/";
                    if ($start && !preg_match($pattern,$start)) {
                        $notify[] = ['error','Invalid date format'];
                        return redirect()->route('staff.bilan.encoursparis')->withNotify($notify);
                    }
                    if ($end && !preg_match($pattern,$end)) {
                        $notify[] = ['error','Invalid date format'];
                        return redirect()->route('staff.bilan.encoursparis')->withNotify($notify);
                    }

   
   return Excel::download( new EncoursParisExportMapping($start,$end), ('encoursparis.xlsx')) ;
        
    }
    
     public function export_encoursabidjan(Request $request) {
    $user = Auth::user();
   $branch_id=$user->branch_id;
  
        $search = $request->date;
        if (!$search) {
            return back();
        }
        $date = explode('-',$search);
        $start = @$date[0];
        $end = @$date[1];
        $pattern = "/\d{2}\/\d{2}\/\d{4}/";
        if ($start && !preg_match($pattern,$start)) {
            $notify[] = ['error','Invalid date format'];
            return redirect()->route('staff.bilan.encoursabidjan')->withNotify($notify);
        }
        if ($end && !preg_match($pattern,$end)) {
            $notify[] = ['error','Invalid date format'];
            return redirect()->route('staff.bilan.encoursabidjan')->withNotify($notify);
        }

   
   return Excel::download( new EncoursAbidjanExportMapping($start,$end), ('encoursabidjan.xlsx')) ;
        
    }

}