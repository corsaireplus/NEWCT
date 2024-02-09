<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use DNS1D;
use App\Models\CourierInfo;
use App\Models\AdminNotification;
use Carbon\Carbon;
use App\Models\CourierProduct;
use App\Models\CourierPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Sender;
use App\Models\Rdv;
use App\Models\User;
use App\Models\Paiement;
use App\Models\RdvProduct;
use App\Models\Mission;
use App\Models\BranchTransaction;
use App\Models\Receiver;
use App\Models\Transfert;
use App\Models\TransfertProduct;
use App\Models\TransfertPayment;
use App\Models\TransfertRef;
use App\Models\Client;
use App\Models\RdvAdresse;
use App\Models\RdvPayment;
use App\Models\ContainerNbcolis;
use App\Models\Livraison;
use App\Models\PrixModif;
use App\Models\GeneralSetting;
//Tables transaction 
use App\Models\Transaction;
use App\Models\TransactionFacture;
use App\Models\TransactionProduct;
use Str;
use App\Constants\Status;
use App\Models\Type;

class TransactionController extends Controller
{
    public function index(){
        $user         = auth()->user();
        $pageTitle    = 'Toutes Les Transactions';

        $courierLists = Transaction::where('branch_id', $user->branch_id)
                       // ->orWhere('receiver_branch_id', $user->branch_id)
                        ->with('sender', 'receiver', 'paymentInfo','senderBranch','senderStaff')
                        ->withSum('paiement as payer','sender_payer')
                        ->dateFilter()
                        ->searchable(['trans_id','reftrans','code', 'receiverBranch:name', 'senderBranch:name', 'sender:contact', 'receiver:contact','sender:nom','receiver:nom'])
                        ->filter(['ship_status','status','receiver_branch_id','branch_id'])
                        // ->where(function ($q) {
                        //     $q->OrWhereHas('payment', function ($myQuery) {
                        //         if(request()->payment_status != null){
                        //             $myQuery->where('status',request()->payment_status);
                        //         }
                        //     });
                        // })
                        ->orderBy('id', 'DESC')
                        ->paginate(getPaginate());
        return view('staff.transactions.index', compact('pageTitle', 'courierLists'));
       
    }

    public static function generateUniqueInvoiceId()
    {
        
        $invoiceCount = Transaction::count();

        do {
            $ref = $invoiceCount + 1;
            $invoiceId = 'CT' . str_pad($ref, 5, '0', STR_PAD_LEFT);
            $invoiceExist = Transaction::where('reftrans', $invoiceId)->exists();

            if (!$invoiceExist) {
                // Si l'ID de facture n'existe pas dans la base de données, on sort de la boucle
                break;
            }

            $invoiceCount++;
        } while ($invoiceExist);

        return $invoiceId;
    }
    //ENREGISTREMENT TRANSACTION SOUCHE CHAUFFEUR
    public function transactionStore(Request $request)
    {

   
        $request->validate([
            'branch' => 'required|exists:branches,id',
            'receiver_name' => 'max:100',
            //'receiver_email' => 'email|max:40',
            'receiver_phone' => 'max:22',
            'receiver_address' => 'max:255',
            'reference' => 'max:20',
           // 'courierName.*' => 'required_with:quantity|exists:types,id',
            //'quantity.*' => 'required_with:courierName|integer|gt:0',
            //'amount' => 'required|array',
            //'amount.*' => 'numeric|gt:0',
            'total_payer' => 'numeric|gt:0',
            'montant_payer' => 'numeric',
            'mode' => 'numeric',
            'message' => 'max:1024',
            'refrdv' => 'max:100'
        ]);
     

    try {
            DB::beginTransaction();
            // INITILISATION DES VARIABLES
            $user = Auth::user();
            $totalAmount=0;
            $totalRecupAmount = 0;
            $totalDepotAmount = 0;

            $date_paiement = date('Y-m-d');
            $rdv = Rdv::where('code', $request->refrdv)->first();
            $mission = Mission::where('idmission',$rdv->mission_id)->first();
            $date_mission = date('Y-m-d h:i:s', strtotime($mission->date));

            //SUPPRIMER ELEMENT RDV POUR METTRE A JOUR 
            $delete_product =RdvProduct::where('rdv_idrdv',$rdv->idrdv)->delete();

            $data = [];
            foreach ($request->items as $item) {
                $courierType = Type::where('id', $item['courierName'])->first();
                if (!$courierType) {
                    continue;
                }
                $price = $courierType->price * $item['quantity'];
                

                 if ($item['rdvName'] == 2) {
                    $totalDepotAmount += $item['amount']; 
                       
                } else {
                    $totalRecupAmount += $item['amount'];
                }
                
                $totalAmount += $item['amount'];

                  if ($item['rdvName'] == 2){
                    $description='3';
                   }else{
                    $description=0;
                   }
    
                $data[] = [
                    'rdv_idrdv'  => $rdv->idrdv,
                    'rdv_type_id' => $item['rdvName'],
                    'rdv_product_id' => $courierType->id,
                    'qty'             => $item['quantity'],
                    'fee'             => $price,
                    'created_at'      => $date_mission,
                    'description'    => $description,
                    
                ];
            }
    
            RdvProduct::insert($data);

             // MISE A JOUR MONTANT RDV 
             $montant=$totalAmount;
             $rdv_update=Rdv::where('idrdv',$rdv->idrdv)->update(array('sender_idsender' => $request->sender_id,'montant'=>$montant));
             $rdv_update_paiement=RdvPayment::where('rdv_id',$rdv->idrdv)->update(array('rdv_senderid' => $request->sender_id,'amount'=>$totalDepotAmount,'recup_amount'=>$totalRecupAmount));
             
             //ENREGISTREMENT TRANSACTION 
                 if($request->reference != null || $totalRecupAmount > 0 ){
                 
                        if($request->receiver_phone == null ){
                            $notify[]=['error','Ajouter  télephone Destinataire'];
                            return back()->withNotify($notify);
                        }else{
                        $receiver_user = Client::where('contact', $request->receiver_phone)->first();
                                if (!isset($receiver_user)) {
                                    $receiver = new Client();
                                    $receiver->nom = strtoupper($request->receiver_name);
                                    $receiver->contact = $request->receiver_phone;
                                    $receiver->email = $request->receiver_email;
                                    $receiver->country_id = 2;
                                // $receiver->adresse = $request->receiver_adresse;
                                    $receiver->save();
                                    $receive_id = $receiver->id;
                                } else {
                                    $receive_id = $receiver_user->id;
                                }
                        }
                }
                // Créez une nouvelle instance de Transaction
                $transaction = new Transaction();

                // Attribuez les valeurs individuellement
                $transaction->code = getTrx();
                $transaction->trans_id = $this->generateUniqueInvoiceId();
                $transaction->rdv_id = $rdv->idrdv;
                if($request->reference)
                {
                $transaction->reftrans = $request->reference;
                }
                $transaction->branch_id = $user->branch_id;
                $transaction->user_id =  $user->id;
                $transaction->sender_id = $request->sender_id;
                if(isset($receive_id) && $receive_id != null){
                $transaction->receiver_id = $receive_id;
                $transaction->receiver_branch_id = $request->branch; 
                }
                if ($request->message != null) 
                {
                $transaction->Observation = $request->message;
                }
                $transaction->status = 0;
                $transaction->type_envoi = 1;
                if($request->reference)
                {
                $transaction->ship_status = 0;
                }else{
                    $transaction->ship_status = -1; 
                }
                // Sauvegardez la nouvelle transaction dans la base de données
                $transaction->save();

                //ENREGISTRER ACTIVITE
                if($transaction){
                    activity('New transaction')
                    ->performedOn($transaction)
                    ->causedBy($user)
                    ->withProperties(['customProperty' => 'customValue'])
                    ->log('Transaction '.$transaction->trans_id.' créé par ' . $user->username);
                }
                $id = $transaction->id;
                //ENREGISTRER ADRESSE
                if(isset($receive_id) && $receive_id != null)
                {
                    $adresse= new RdvAdresse();
                    $adresse->client_id =$receive_id;
                    $adresse->rdv_id =$request->reference;
                    $adresse->adresse =$request->receiver_address;
                   // $adresse->code_postal=$request->sender_code_postal;
                    $adresse->save();
                }
                // ENREGISTRER LISTE PRODUIT A ENVOYER
                $totalRdvAmount = 0;

                $data = [];
                
               foreach ($request->items as $item) {
                $courierType = Type::where('id', $item['courierName'])->first();
                if (!$courierType) {
                    continue;
                }
                $price = $courierType->price * $item['quantity'];
               

                 if ($item['rdvName'] == 2) {
                    $totalDepotAmount += $item['amount']; 
                       
                } else {
                    $totalRecupAmount += $item['amount'];
                }
                
                $totalRdvAmount += $item['amount'];

                  if ($item['rdvName'] == 2){
                    $description='3';
                   }else{
                    $description=0;
                   }
    
                $data[] = [
                    'transaction_id' => $transaction->id,
                    'transaction_type_id' => $courierType->id,
                    'type_cat_id'     => $item['rdvName'] ,
                    'qty'             => $item['quantity'],
                    'fee'             => $price,
                    'created_at'       => now(),
                ];
             }
             TransactionProduct::insert($data);

                // Créez une nouvelle instance de TransactionFacture
                $transactionFacture = new TransactionFacture();
                // Attribuez les valeurs individuellement
                $transactionFacture->transaction_id = $transaction->id;
                $transactionFacture->amount = $totalRdvAmount;
                $transactionFacture->discount = 0 ;
                $transactionFacture->final_amount = $totalRdvAmount;
                $transactionFacture->sender_amount = $totalRdvAmount;
                $transactionFacture->receiver_amount = $totalRdvAmount * 656;
                $transactionFacture->user_id =  $user->id;
                // Sauvegardez la nouvelle transaction facture dans la base de données
                $transactionFacture->save();


                if($totalRecupAmount > 0){

              
                $q = DB::table('transaction_product')->where('transaction_id', $transaction->id)->where('type_cat_id',1)->sum('qty');
                if ($q == 1) {
                    $transfertRef = new TransfertRef();
                    $transfertRef->transaction_id = $transaction->id;
                    $transfertRef->ref_souche_part = $request->reference;
                    $transfertRef->status = 0;
                    $transfertRef->save();
                } else {
                    for ($i = 0; $i < $q; $i++) {
                        $refsouch = $i+1;
                        $transfertRef = new TransfertRef();
                        $transfertRef->transaction_id = $transaction->id;
                        $transfertRef->ref_souche_part = $request->reference . '-'.$refsouch.'/'.$q;
                        $transfertRef->status = 0;
                        $transfertRef->save();
                    }
                 }
                }
                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $user->id;
                $adminNotification->title = 'New Transaction Enregistrée ' . $user->username;
                $adminNotification->click_url = urlPath('admin.courier.info.details', $id);
                $adminNotification->save();
               // dd($totalRdvAmount);
            // enregistrement paiement en une seule fois avec branche transaction
            if($request->montant_payer > 0){
                if($request->montant_payer > $totalRdvAmount){
                    $notify[]=['error','Montant Superieur Veuillez Corriger'];
                    return back()->withNotify($notify);
                }
                $rdv = Rdv::where('code', $request->refrdv)->first();
                $payment = RdvPayment::where('rdv_id', $rdv->idrdv)->first();

                
                  
                $payer = new Paiement();
                $payer->user_id = $user->id;
                $payer->branch_id = $user->branch_id;
                $payer->rdv_id = $rdv->idrdv;  
                $payer->sender_payer = $request->montant_payer;
                $payer->receiver_payer = $request->montant_payer * 656;
                $payer->date_paiement = $date_paiement;
                $payer->refpaiement = getTrx();
                $payer->transaction_id = $transaction->id;
                $payer->mode_paiement = $request->mode;
                $payer->save();


                if($request->montant_payer < $totalRdvAmount){
                    $trans_status = 1 ;
                }elseif( $request->montant_payer == $totalRdvAmount ){
                    $trans_status = 2 ;
                }
                $transaction_update = Transaction::where('id', $transaction->id)->update(array('status' => $trans_status));

                $branchtransaction = new BranchTransaction();
                $branchtransaction->branch_id = $user->branch_id;
                $branchtransaction->type = 'credit';
                $branchtransaction->amount = $request->montant_payer;
                $branchtransaction->reff_no = getTrx();
                $branchtransaction->created_by = $user->id;
                $branchtransaction->transaction_id = $payment->refrdv;
                $branchtransaction->transaction_payment_id = $payer->id;
                $branchtransaction->operation_date= $date_paiement;
                $branchtransaction->type_transaction ='1';
                $branchtransaction->save();
                

            }
            $rdv_update = Rdv::where('code', $request->refrdv)->update(array('status' => '3','encaisse' =>$request->montant_payer));

            DB::commit();
            $rdv=Rdv::where('code',$request->refrdv)->first();
            $notify[] = ['success', 'Transfert enregistré avec succès'];
            return redirect()->route('staff.mission.detailmission', encrypt($rdv->mission_id))->withNotify($notify);

        } catch (Exception $e) {

            DB::rollback();
        }
      
       
    }
    public function update(Request $request){
    
        $request->validate([
            'branch' => 'required|exists:branches,id',
            'sender_name' => 'required|max:40',
             'reference' =>'required|max:20',
            'sender_phone' => 'string|max:40',
            'sender_address' => 'max:255',
            'receiver_name' => 'required|max:40',
            //'receiver_email' => 'email|max:40',
            'receiver_phone' => 'required|string|max:40',
            'receiver_address' => 'max:255',
            'deja_payer'=>'numeric',
            // 'reference'=>'required',
            'courierName.*' => 'required_with:quantity|exists:types,id',
            'quantity.*' => 'required_with:courierName|integer|gt:0',
            'amount' => 'required|array',
            'amount.*' => 'numeric|gt:0',
        ]);

        DB::beginTransaction();
        try {
            $user = Auth::user();
            $date_paiement = date('Y-m-d');
            $sender_user = Client::where('contact', $request->sender_phone)->where('country_id',1)->first();
           // dd($sender_user);
            $id_sender = $sender_user->id;
            //modifier nom expediteur
             $sender = Client::where('id', $id_sender)->firstOrFail();
             $sender->nom=strtoupper($request->sender_name);
             $sender->save();
             $sende_id = $sender_user->id;
             //modifier expediteur complet nom et numero
             $receiver_user = Client::where('contact', $request->receiver_phone)->first();
             if(!isset($receiver_user))
             {
                $receiver = new Client();
                $receiver->nom = strtoupper($request->receiver_name);
                $receiver->contact = $request->receiver_phone;
                if ($request->receiver_email) {
                    $receiver->email = $request->receiver_email;
                }
                $receiver->save();
                $receive_id = $receiver->id;
             }else{
                 $receiver = Client::where('id',$receiver_user->id)->firstOrFail();
                 $receiver->nom =strtoupper($request->receiver_name);
                 $receiver->save();
                 $receive_id = $receiver_user->id;
             }
             
            
             //mise à jour transfert 
            $courier = Transaction::where('id',$request->transfert_id)->firstOrFail();
            $old_user= $courier->user_id ;

            $courier->reftrans = $request->reference;
            $courier->branch_id = $user->branch_id;
            $courier->user_id = $user->id;
            $courier->sender_id = $sende_id;
            $courier->receiver_id = $receive_id;
            $courier->receiver_branch_id = $request->branch;
            //$courier->status = 0;
            $courier->type_envoi=$request->envoi;//1 maritime 2 Aerien
            $courier->save();
            $id = $courier->id;
           
            //ENREGISTRER ACTIVITE
            if($courier){
                activity('Modificetion transaction')
                ->performedOn($courier)
                ->causedBy($user)
                //->withProperties(['customProperty' => 'customValue'])
                ->log('Modification Transaction '.$request->reference.' créé par ' . $user->username);
            }
           
            //mise à jour adresse destinataire
            $delete_adresse= RdvAdresse::where('rdv_id',$request->transfert_id)->delete();
            $receiver_adresse= new RdvAdresse();
            $receiver_adresse->client_id =$receive_id;
            $receiver_adresse->rdv_id =$id;
            $receiver_adresse->adresse =$request->receiver_address;
            $receiver_adresse->save();
            
            $totalAmount = 0;
            $delete_product =TransactionProduct::where('transaction_id',$request->transfert_id)->delete();
           // dd( $request->courierName[0]);
           $courierType = Type::where('id', $request->courierName[0])->where('status', 1)->firstOrFail();
         /// dd( $courierType);

            for ($i = 0; $i < count($request->courierName); $i++) {

                $courierType = Type::where('id', $request->courierName[$i])->where('status', 1)->firstOrFail();
              
                if ($user->branch->country == 'CIV') {
                    $totalAmount += ($request->quantity[$i] * $courierType->price) * 656;
                } else {
                    $totalAmount += $request->quantity[$i] * $courierType->price;
                }
                    $courierProduct = new TransactionProduct();
                    $courierProduct->transaction_id = $courier->id;
                    $courierProduct->transaction_type_id = $courierType->id;
                    $courierProduct->type_cat_id = $courierType->cat_id;
                    $courierProduct->qty = $request->quantity[$i];
                    $courierProduct->fee = $request->amount[$i];
                    $courierProduct->save();
                
                
            }

           // dd($user->branch->country);
            $courierPayment =TransactionFacture::where('transaction_id',$request->transfert_id)->firstOrFail();
           
            //SMS MODIFICATION 
            if($courierPayment->sender_amount != $request->total_payer ){
                $old_amount = $courierPayment->sender_amount ;
                $new_amount = $request->total_payer;
                
                $prix_modif= new PrixModif();
                $prix_modif->old_amount=$old_amount;
                $prix_modif->new_amount=$new_amount;
                $prix_modif->old_user=$old_user;
                $prix_modif->new_user=$user->id;
                $prix_modif->branch_id=$user->branch_id;
                $prix_modif->transfert_id=$request->transfert_id;
                $prix_modif->save();
                //ENREGISTRER ACTIVITE
                if($prix_modif){
                    activity('Modification montant transfert')
                    ->performedOn($prix_modif)
                    ->causedBy($user)
                    ->withProperties(['customProperty' => 'customValue'])
                    ->log('Modification Montant Tranfert '.$request->reference.' par ' . $user->username);
                }
                $message="Modification Montant Transfert ".$request->reference." Ancien montant : ".$old_amount." Nouveau : ".$new_amount." par : ".$user->firstname." ".$user->lastname;

               // $this->sendSms($message);
                /// envoie email modification
                $general = GeneralSetting::first();
                $config = $general->mail_config;
                $receiver_name = "Administrateur";
                $subject = 'Modification Montant Transaction '.$request->reference;
                $message = 'Le Montant de la transaction de Reference '.$request->reference.' a été modifié ce jour par '.$user->firstname.' '.$user->lastname.' Ancien Montant: '.$old_amount.' Nouveau Montant: '.$new_amount;   ;

                try {
                   // sendGeneralEmail('lbagate@yahoo.fr', $subject, $message, $receiver_name);
                } catch (\Exception $exp) {
                    // $notify[] = ['error', 'Invalid credential'];
                    // return back()->withNotify($notify);
                }

                $transactionFacture = TransactionFacture::where('transaction_id',$request->transfert_id)->firstOrFail();
                $update = TransactionFacture::where('transaction_id', $request->transfert_id)->update(array('amount' => $request->total_payer,'final_amount' =>$request->total_payer,'sender_amount'=>$request->total_payer,'receiver_amount'=>$request->total_payer * 656));
               
            }

          
            //FIN ALERTE
            $courierPayment->amount= $request->total_payer;  
                if ($user->branch->country == 'CIV') {
                $courierPayment->sender_amount = $totalAmount;
                $courierPayment->receiver_amount = $totalAmount / 656;
            } else {
                $courierPayment->sender_amount = $request->total_payer;
                $courierPayment->receiver_amount = $request->total_payer * 656;
            }
           

            $courierPayment->save();

            $delete_trans_ref=TransfertRef::where('transaction_id',$request->transfert_id)->delete();
            $q = DB::table('transaction_product')->where('transaction_id', $courier->id)->where('type_cat_id',1)->sum('qty');
            if ($q == 1) {
                $transfertRef = new TransfertRef();
                $transfertRef->transfert_id = $courier->id;
                $transfertRef->ref_souche_part = $courier->reference_souche;
                $transfertRef->status = 0;
                $transfertRef->save();
            } else {
                for ($i = 0; $i < $q; $i++) {
                    $transfertRef = new TransfertRef();
                    $transfertRef->transfert_id = $courier->id;
                    $transfertRef->ref_souche_part = $courier->reference_souche . '-' . $i;
                    $transfertRef->status = 0;
                    $transfertRef->save();
                }
            }

                      //AJOUTER PAIEMENT
                      if($request->montant_payer > 0)
                      {
                          $date_paiement = date('Y-m-d');
                          $status_payer= $request->total_payer - ($request->montant_payer + $request->deja_payer) ;
                          if($status_payer < 0)
                          {
                              $notify[] = ['error', 'Montant payé incorrect'];
                              return back()->withNotify($notify);
                          }
                          
                          $payer = new Paiement();
                          $payer->user_id = $user->id;
                          $payer->branch_id = $user->branch_id;
                          $payer->sender_branch_id = $user->branch_id;
                          $payer->transaction_id = $courierPayment->id;
                          $payer->refpaiement = getTrx();
                          $payer->sender_payer = $request->montant_payer;
                          $payer->receiver_payer = $request->montant_payer * 656;
                          $payer->mode_paiement = $request->mode;
                          $payer->date_paiement = $date_paiement;
                          $payer->save();

                          $sommeMontantsPayes = Paiement::where('transaction_id', 1)->sum('sender_payer');

                          if($sommeMontantsPayes <  $request->total_payer)
                          {
                           $statusTrans = 1;
                          }elseif($sommeMontantsPayes == $request->total_payer){
                            $statusTrans = 2;
                          }
                          $transaction_update = Transaction::where('id', $transaction->id)->update(array('status' => $statusTrans));


                         // $update = TransfertPaym::where('transfert_id', $courierPayment->id)->update(array('status' => $payer->status));
          
                          $adminNotification = new AdminNotification();
                          $adminNotification->user_id = $user->id;
                          $adminNotification->title = 'Paiement Frais Transaction ' . $user->username;
                          $adminNotification->click_url = urlPath('admin.courier.info.details', $id);
                          $adminNotification->save();
          
                          $branchtransaction = new BranchTransaction();
                          $branchtransaction->branch_id = $user->branch_id;
                          $branchtransaction->type = 'credit';
                          $branchtransaction->amount = $request->montant_payer;
                          $branchtransaction->reff_no = getTrx();
                          $branchtransaction->operation_date= $date_paiement;
                          $branchtransaction->type_transaction ='2';
                          //$branchtransaction->rdv_id=$payment->rdv_id;
                          $branchtransaction->created_by = $user->id;
                          $branchtransaction->transaction_id = $request->refrdv;
                          $branchtransaction->transaction_payment_id = $payer->id;
                          
                          $branchtransaction->save();
                     }
                    $adminNotification = new AdminNotification();
                    $adminNotification->user_id = $user->id;
                    $adminNotification->title = 'Transaction Modifié ' . $user->username;
                    $adminNotification->click_url = urlPath('admin.courier.info.details', $id);
                    $adminNotification->save();
                    DB::commit();
        
                    $notify[] = ['success', 'Transaction modifiée avec succès'];
                    return redirect()->route('staff.transactions.index')->withNotify($notify);

        }catch (Exception $e) {

            DB::rollback();
        }
        //dd('ok');
      

    }


    public function edit($id)
    {
        $courierInfo = Transaction::where('id', decrypt($id))->with('receiver_adresse')->first();
        $admin = Auth::user();
        $courierProductInfos = TransactionProduct::where('transaction_id', $courierInfo->id)->with('type','type.unit')->get();
        $courierProductRef = TransfertRef::where('transaction_id', $courierInfo->id)->get();
        $courierPayment = TransactionFacture::where('transaction_id', $courierInfo->id)->first();
        $branchs = Branch::where('status', 1)->where('id', '!=', $admin->branch_id)->latest()->get();
        $types = Type::where('status', 1)->where('cat_id','<',2)->with('unit')->latest()->get();
        $deja_payer=Paiement::where('transaction_id',decrypt($id))->where('branch_id',$admin->branch_id)->sum('sender_payer');
       
        
        $pageTitle   = 'Modifier Transaction';
        
        return view('staff.transactions.edit', compact('pageTitle', 'courierInfo', 'courierProductRef', 'courierProductInfos', 'courierPayment','branchs','types','deja_payer'));
    }

    public function details($id)
    {
        $pageTitle   = 'Details Transaction';
        $userInfo = Auth::user();
        $courierInfo = Transaction::with('products.type.unit','products','sender', 'receiver','paymentInfo','paiement','paiement.agent','paiement.modepayer')->findOrFail(decrypt($id));
        $staff = auth()->user();
        $deja_payer_receiver=Paiement::where('transaction_id',decrypt($id))->where('branch_id',1)->sum('receiver_payer');
        $deja_payer_sender=Paiement::where('transaction_id',decrypt($id))->where('branch_id',1)->sum('sender_payer');

        return view('staff.transactions.details', compact('pageTitle', 'courierInfo', 'staff','userInfo','deja_payer_receiver','deja_payer_sender'));
    }

    public function invoice($id)
    {
        $pageTitle = 'Facture';
        $courierInfo = Transaction::with('products.type.unit', 'paiement', 'sender', 'receiver','paymentInfo')->findOrFail(decrypt($id));
        return view('staff.transactions.invoice', compact('pageTitle', 'courierInfo'));
    }
    public function payment(Request $request)
    {
        //dd($request);
        $user = Auth::user();
        $transfert = Transaction::where('trans_id', $request->code)->first();
        $transfertPayment = TransactionFacture::where('transaction_id', $transfert->id)->first();
        $amount = $request->montant_payer;
        // dd($transfertPayment);
        if ($user->branch_id == $transfert->branch_id) {

            if ($user->branch->country == 'CIV') {
                $sender_payer = $request->montant_payer;
                $receiver_payer = $request->montant_payer / 656;
                $totpayer = DB::table('paiements')
                    ->where('transaction_id', $transfert->id)
                    ->get(DB::raw('SUM(sender_payer) AS deja_payer'));
            } else {
                $sender_payer = $request->montant_payer;
                $receiver_payer = $request->montant_payer * 656;
                $totpayer = DB::table('paiements')
                    ->where('transaction_id', $transfert->id)
                    ->get(DB::raw('SUM(sender_payer) AS deja_payer'));
                $total_amount = $totpayer;

            }
        } else {
            if ($user->branch->country == 'CIV') {
                $receiver_payer = $request->montant_payer;
                $sender_payer = $request->montant_payer / 656;
                $totpayer = DB::table('paiements')
                    ->where('transaction_id', $transfert->id)
                    ->get(DB::raw('SUM(receiver_payer) AS deja_payer'));
            } else {
                $receiver_payer = $request->montant_payer;
                $sender_payer = $request->montant_payer * 656;
                $totpayer = DB::table('paiements')
                    ->where('transaction_id', $transfert->id)
                    ->get(DB::raw('SUM(receiver_payer) AS deja_payer'));
            }
        }
        if ($transfertPayment->final_amount ==  $total_amount) {
            $notify[] = ['error', 'Paiement dejà enregistré'];
        } else {
            DB::beginTransaction();
            try {
                $user = Auth::user();
                // $rdvmontant->status='3';
                //$rdvmontant->save();
                $payment = TransactionFacture::where('transaction_id', $transfert->id)->first();

                $date_paiement = date('Y-m-d');
                $payer = new Paiement();
                $payer->user_id = $user->id;
                $payer->branch_id = $user->branch_id;
                $payer->sender_branch_id = $payment->transaction->branch_id;
                $payer->transaction_id = $payment->transaction_id;
                $payer->refpaiement = getTrx();
                $payer->sender_payer = $sender_payer;
                $payer->receiver_payer = $receiver_payer;
                $payer->mode_paiement = $request->mode;
                $payer->date_paiement = $date_paiement;
                $payer->status = 0;
                $payer->save();

                if($payer){
                    activity('Nouveau Paiement')
                    ->performedOn($payer)
                    ->causedBy($user)
                    ->withProperties(['customProperty' => 'customValue'])
                    ->log('Paiement de '.$sender_payer.' Euro ajouté par ' . $user->username);
    
                }
                //$payment->chauffeur_id=
                //  $payment->status= $payer->status;
                //  $payment->save();

                $branchtransaction = new BranchTransaction();
                $branchtransaction->branch_id = $user->branch_id;
                $branchtransaction->type = 'credit';
                $branchtransaction->amount = $amount;
                $branchtransaction->reff_no = getTrx();
                $branchtransaction->operation_date = $date_paiement;
                //$branchtransaction->rdv_id=$payment->rdv_id;
                $branchtransaction->created_by = $user->id;
                $branchtransaction->transaction_id = $payment->refrdv;
                $branchtransaction->transaction_payment_id = $payer->id;
                $branchtransaction->type_transaction = '2';
                $branchtransaction->save();

                $totalpayer = DB::table('paiements')
                    ->where('transaction_id', $transfert->id)
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

                $update = Transaction::where('id', $transfert->id)->update(array('status' => $status_paye));


                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $payment->transaction->sender_id;
                $adminNotification->title = 'Paiement Frais Envoi '; //. $payment->transfert->client->nom
                $adminNotification->click_url = urlPath('staff.transactions.details', $payment->transaction_id);
                $adminNotification->save();
                DB::commit();
                // }
                $notify[] = ['success', 'Paiement validé '];
            } catch (Exception $e) {

                DB::rollback();
            }
        }
        return back()->withNotify($notify);
    }

     public function delete(Request $request)
     {
                 $user = Auth::user();

     try {

              DB::beginTransaction();
                 $rdv_code = Transaction::where('trans_id',$request->refpaiement)->first(); 
                 $rdv_restore=Rdv::where('idrdv',$rdv_code->rdv_id)->first();

            //VERIFICATION COLIS EXISTE DANS CONTENEUR
            $conteneur=ContainerNbcolis::where('id_colis',$rdv_code->id)->first();
            if($conteneur){
                $notify[] = ['danger', 'Impossible de Supprimer le colis dans un conteneur'];

                activity('Echec Suppression de transfert colis')
                ->performedOn($rdv_code)
                ->causedBy($user)
                //->withProperties(['customProperty' => 'customValue'])
                ->log('Echec de suppression Tranfert par ' . $user->username);
            return back()->withNotify($notify);
            }else{
                if($rdv_restore){
                        $rdv_restore->status ='2';
                        $rdv_restore->save();
                        $rdv_payment=RdvPayment::where('rdv_id',$rdv_code->rdv_id)->firstOrFail();
                        $rdv_payment->status='1';
                        
                        $rdv_payment->save();
                        $paiementrdv=Paiement::where('rdv_id',$rdv_restore->idrdv)->first();
                        if($paiementrdv)
                          {
                                $branchtransaction=BranchTransaction::where('transaction_payment_id',$paiementrdv->id)->delete();
                                $paiementrdv->delete();

                                activity('Suppression de paiement pour depot RDV')
                                ->performedOn($paiementrdv)
                                ->causedBy($user)
                                //->withProperties(['customProperty' => 'customValue'])
                                ->log('Suppression de paiement pour depot de rdv  par ' . $user->username);
            
                                $adminNotification = new AdminNotification();
                                $adminNotification->user_id = $user->id;
                                $adminNotification->title = 'Rdv restoré paiement supprimé ' . $user->username;
                                $adminNotification->click_url = urlPath('admin.courier.info.details', $rdv_code->facture_idfacture);
                                $adminNotification->save();
                             }
                      }
           
                        $trans = Transaction::where('trans_id',$request->refpaiement)->first();
                        $courier = Transaction::where('trans_id',$request->refpaiement)->delete();
                        $courierPayment =TransactionFacture::where('transaction_id',$trans->id)->delete();

                        $adminNotification = new AdminNotification();
                        $adminNotification->user_id = $user->id;
                        $adminNotification->title = 'Transaction Supprimée' . $user->username;
                        $adminNotification->click_url = urlPath('admin.courier.info.details', $request->refpaiement);
                        $adminNotification->save();
                        
                        activity('Suppression transfert')
                        ->performedOn($trans)
                        ->causedBy($user)
                       // ->withProperties(['customProperty' => 'customValue'])
                        ->log('Suppression Tranfert par ' . $user->username);
                    }

                  DB::commit();
                  $notify[] = ['success', 'Envoi supprimé avec succès'];
                  return back()->withNotify($notify);

            } catch (Exception $e) {

                DB::rollback();
            }

       }

       public function newrdv($id){

        $pageTitle = "Creer RDV dans le programme";
        $branchs = Branch::where('status', 1)->latest()->get();
        $types = Type::where('status', 1)->with('unit')->latest()->get();
        $chauffeur =User::where('user_type','staff')->get();
        $mission_id = $id;
        return view('staff.transactions.createrdv', compact('pageTitle', 'branchs', 'types','chauffeur','mission_id'));

       }


    }
