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
//dd($courierLists);
        return view('staff.transactions.index', compact('pageTitle', 'courierLists'));
        // $pageTitle = "Liste des transactions";
        // $emptyMessage = "Aucun Colis";
        // $user = Auth::user();
        // $transferts = Transaction::where('branch_id', $user->branch_id)->with('sender', 'receiver', 'paymentInfo')->withSum('paiement as payer','sender_payer')->orderBy('id', 'DESC')->paginate(getPaginate());
        // return view('staff.transactions.index', compact('transferts', 'user', 'pageTitle', 'emptyMessage'));
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
            'courierName.*' => 'required_with:quantity|exists:types,id',
            'quantity.*' => 'required_with:courierName|integer|gt:0',
            'amount' => 'required|array',
            'amount.*' => 'numeric|gt:0',
            'total_payer' => 'numeric|gt:0',
            'montant_payer' => 'numeric',
            'mode' => 'numeric',
            'message' => 'max:1024',
            'refrdv' => 'max:100'
        ]);
        // dd($request);

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
            for ($i = 0; $i < count($request->courierName); $i++) 
            {
                $courierType = Type::where('id', $request->courierName[$i])->where('status', 1)->firstOrFail();
                
                if ($request->rdvName[$i] == 2) {
                    $totalDepotAmount += $request->amount[$i]; 
                       
                } else {
                    $totalRecupAmount += $request->amount[$i];
                }
                
                $totalAmount += $request->amount[$i];
                
                
                // MISE A JOUR DES ELEMENTS DU RDV 
                $rdvProduct = new RdvProduct();
                $rdvProduct->rdv_idrdv = $rdv->idrdv;
                if ($request->rdvName[$i] == 2){
                    $rdvProduct->description='3';
                }
                $rdvProduct->rdv_type_id = $request->rdvName[$i];
                $rdvProduct->rdv_product_id = $courierType->id;
                $rdvProduct->qty = $request->quantity[$i];
                $rdvProduct->fee =  $request->amount[$i];
                $rdvProduct->created_at = $date_mission;
                $rdvProduct->save();
              
            }


             // MISE A JOUR MONTANT RDV 
             $montant=$totalAmount;
             $rdv_update=Rdv::where('idrdv',$rdv->idrdv)->update(array('sender_idsender' => $request->sender_id,'montant'=>$montant));
             $rdv_update_paiement=RdvPayment::where('rdv_id',$rdv->idrdv)->update(array('rdv_senderid' => $request->sender_id,'amount'=>$totalDepotAmount,'recup_amount'=>$totalRecupAmount));
             
             //ENREGISTREMENT TRANSACTION 
                 if($request->reference != null){
                 
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
                for ($i = 0; $i < count($request->courierName); $i++) {
                    $courierType = Type::where('id', $request->courierName[$i])->where('status', 1)->firstOrFail();
                   
                        $totalRdvAmount += $request->amount[$i];
                        $courierProduct = new TransactionProduct();
                        $courierProduct->transaction_id = $transaction->id;
                        $courierProduct->type_cat_id = $courierType->cat_id;
                        $courierProduct->qty = $request->quantity[$i];
                        $courierProduct->fee = $request->amount[$i];
                        $courierProduct->save();
                   // }
                    
                }
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

                $q = DB::table('transfert_product')->where('transfert_id', $transaction->id)->where('type_cat_id',1)->sum('qty');
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
                        $transfertRef->transaction_id = $transaction-->id;
                        $transfertRef->ref_souche_part = $request->reference . '-'.$refsouch.'/'.$q;
                        $transfertRef->status = 0;
                        $transfertRef->save();
                    }
                }

                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $user->id;
                $adminNotification->title = 'New Transaction Enregistrée ' . $user->username;
                $adminNotification->click_url = urlPath('admin.courier.info.details', $id);
                $adminNotification->save();

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

                $rdv_update = Rdv::where('code', $request->refrdv)->update(array('status' => '3','encaisse' =>$request->montant_payer));

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
             
            
        

            DB::commit();
            $rdv=Rdv::where('code',$request->refrdv)->first();
            $notify[] = ['success', 'Transfert enregistré avec succès'];
            return redirect()->route('staff.mission.detailmission', encrypt($rdv->mission_id))->withNotify($notify);

        } catch (Exception $e) {

            DB::rollback();
        }
      
       
    }
    public function edit($id)
    {
        $courierInfo = Transaction::where('id', decrypt($id))->with('receiver_adresse')->first();
        $admin = Auth::user();
        $courierProductInfos = TransactionProduct::where('transaction_id', $courierInfo->id)->with('type')->get();
        $courierProductRef = TransfertRef::where('transaction_id', $courierInfo->id)->get();
        $courierPayment = TransactionFacture::where('transaction_id', $courierInfo->id)->first();
        $branchs = Branch::where('status', 1)->where('id', '!=', $admin->branch_id)->latest()->get();
        $types = Type::where('status', 1)->where('cat_id','<',2)->with('unit')->latest()->get();
        $deja_payer=Paiement::where('transaction_id',decrypt($id))->where('branch_id',$admin->branch_id)->sum('sender_payer');
       
        
        $pageTitle   = 'Modifier Transaction';
        // $id          = decrypt($id);
        // $branches    = Branch::active()->where('id', '!=', auth()->user()->branch_id)->orderBy('name')->get();
        // $types       = Type::active()->with('unit')->orderBy('name')->get();
        // $user        = auth()->user();
        // $courierInfo = CourierInfo::with('products.type', 'payment', 'senderCustomer', 'receiverCustomer')->where('sender_branch_id', $user->branch_id)->where('id', $id)->firstOrFail();

        // if ($courierInfo->status != ) {
        //     $notify[] = ['error', "You can update only sent in queue courier."];
        //     return back()->with($notify);
        // }
        return view('staff.transactions.edit', compact('pageTitle', 'courierInfo', 'courierProductRef', 'courierProductInfos', 'courierPayment','branchs','types','deja_payer'));
    }

    public function details($id)
    {
        $pageTitle   = 'Details Transaction';
        $userInfo = Auth::user();
        $courierInfo = Transaction::with('products.type.unit', 'sender', 'receiver','paymentInfo','paiement')->findOrFail(decrypt($id));
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


    }
