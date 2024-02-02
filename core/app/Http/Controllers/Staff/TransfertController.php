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


class TransfertController extends Controller
{
    public function index()
    {
        $pageTitle = "Liste des Envois";
        $emptyMessage = "Aucun Colis";
        $user = Auth::user();
        $transferts = Transfert::where('sender_branch_id', $user->branch_id)->with('sender', 'receiver', 'paymentInfo')->withSum('paiement as payer','sender_payer')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('staff.transfert.index', compact('transferts', 'user', 'pageTitle', 'emptyMessage'));
    }

    public function colisNonPaye()
    {
        $pageTitle = "Liste des Envois Non Payés";
        $emptyMessage = "Aucun Colis";
        $user = Auth::user();
        $transferts = Transfert::where('sender_branch_id', 1)
                                 ->join('transfert_payments', 'transferts.id', '=', 'transfert_payments.transfert_id')
                                 ->where('transfert_payments.status', 1)
                                ->with('sender', 'receiver', 'paymentInfo')
                                ->withSum('paiement as payer','sender_payer')
                                ->orderBy('id', 'DESC')->paginate(getPaginate());
        
        
        return view('staff.transfert.nonpaye', compact('transferts', 'user', 'pageTitle', 'emptyMessage'));
    }
    public function entrepotlist()
    {
        $pageTitle = "Liste des Colis en entrepot A Abidjan";
        $emptyMessage = "Aucun Colis";
        $user = Auth::user();
        $transferts = Transfert::where('container_id','>','0')->whereHas('nbcolis' ,function ($query) {
        $query->where('date_livraison', NULL);})->with('sender', 'receiver', 'paymentInfo')->withSum('paiement as payer','sender_payer')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('staff.transfert.entrepotlist', compact('transferts', 'user', 'pageTitle', 'emptyMessage'));
    }
    public function getReceive(Request $request)
    {
        $user = Auth::user();
        $pageTitle = "Transferts Reçu";
        $emptyMessage = "Aucun Colis";
        $user = Auth::user();
        $transferts = Transfert::where('receiver_branch_id', $user->branch_id)->where('status','>',0)->orderBy('reference_souche', 'DESC')->with('senderBranch', 'receiver', 'sender', 'receiverBranch', 'senderStaff', 'receiverStaff', 'paymentInfo','courierDetail')->withSum('paiement as payer','receiver_payer')->paginate(getPaginate());
        return view('staff.transfert.receive', compact('pageTitle', 'user', 'emptyMessage', 'transferts'));
    }
    public function getTransferts(Request $request)
    {
        if ($request->ajax()) {
            $transferts = Transfert::with('sender', 'receiver', 'paymentInfo')->get();
            return Datatables::of($transferts)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        $pageTitle = "Enregistrer Transfert";
        $admin = Auth::user();
        $branchs = Branch::where('status', 1)->where('id', '!=', $admin->branch_id)->latest()->get();
        $types = Type::where('status', 1)->where('cat_id','<',2)->with('unit')->latest()->get();
        if ($admin->branch->country == 'FRA') {
            return view('staff.transfert', compact('pageTitle', 'branchs', 'types'));
        } else {
            return view('staff.transfert2', compact('pageTitle', 'branchs', 'types'));
        }
    }
    // ENREGISTREMENT TRANSFERT DEPUIS BUREAU 
    public function store(Request $request)
    {

        $request->validate([
            'branch' => 'required|exists:branches,id',
            'sender_name' => 'required|max:40',
            'reference' => 'required|max:20|unique:transferts,reference_souche',
            'sender_phone' => 'required|string|max:40',
            'sender_address' => 'max:255',
            'receiver_name' => 'required|max:40',
            //'receiver_email' => 'email|max:40',
            'receiver_phone' => 'required|string|max:40',
            'receiver_address' => 'max:255',
            // 'reference'=>'required',
            'total_payer' => 'numeric|gt:0',
            'courierName.*' => 'required_with:quantity|exists:types,id',
            'quantity.*' => 'required_with:courierName|integer|gt:0',
            'amount' => 'required|array',
            'amount.*' => 'numeric|gt:0',
        ]);
        //dd($request);

        DB::beginTransaction();
        try {
            
            $user = Auth::user();
            $date_paiement = date('Y-m-d');
            $sender_user = Client::where('contact', $request->sender_phone)->first();
            if (!isset($sender_user)) {
                $sender = new Client();
                $sender->nom = strtoupper($request->sender_name);
                $sender->contact = $request->sender_phone;
                $sender->country_id =$user->branch_id;
                if ($request->sender_email) {
                    $sender->email = $request->sender_email;
                }
               
                $sender->save();
                $sende_id = $sender->id;

                $adresse= new RdvAdresse();
                $adresse->client_id =$sende_id;
                $adresse->adresse ="";
                $adresse->code_postal="";
                $adresse->save();

            } else {
                $sende_id = $sender_user->id;
            }
                  
            $receiver_user = Client::where('contact', $request->receiver_phone)->first();
            if (!isset($receiver_user)) {
                $receiver = new Client();
                $receiver->nom = strtoupper($request->receiver_name);
                $receiver->contact = $request->receiver_phone;
                if ($request->receiver_email) {
                    $receiver->email = $request->receiver_email;
                }
            
                $receiver->save();
                $receive_id = $receiver->id;
            } else {
                $receive_id = $receiver_user->id;
            }
           
            $courier = new Transfert();
            $courier->code = getTrx();
            $courier->reference_souche = $request->reference;
            $courier->sender_branch_id = $user->branch_id;
            $courier->sender_staff_id = $user->id;
            $courier->sender_idsender = $sende_id;
            $courier->receiver_idreceiver = $receive_id;
            $courier->receiver_branch_id = $request->branch;
            $courier->facture_idfacture = getTrx();
            $courier->status = 0;
            $courier->type_envoi=$request->envoi;//1 maritime 2 Aerien
            $courier->save();
            $id = $courier->id;

            // $sender_adresse= new RdvAdresse();
            // $sender_adresse->client_id =$sende_id;
            // $sender_adresse->rdv_id =$id;
            // $sender_adresse->adresse =$request->sender_address;
            // $sender_adresse->code_postal =$request->sender_code;
            // $sender_adresse->save();

            $receiver_adresse= new RdvAdresse();
            $receiver_adresse->client_id =$receive_id;
            $receiver_adresse->rdv_id =$id;
            $receiver_adresse->adresse =$request->receiver_address;
            $receiver_adresse->save();


            $totalAmount = 0;
            for ($i = 0; $i < count($request->courierName); $i++) {
                $courierType = Type::where('id', $request->courierName[$i])->where('status', 1)->firstOrFail();
                if ($user->branch->country == 'CIV') {
                    $totalAmount += ($request->quantity[$i] * $courierType->price) * 656;
                } else {
                    $totalAmount += $request->quantity[$i] * $courierType->price;
                }
                if($courierType->cat_id != 3){
                    $courierProduct = new TransfertProduct();
                    $courierProduct->transfert_id = $courier->id;
                    $courierProduct->transfert_type_id = $courierType->id;
                    $courierProduct->type_cat_id = $courierType->cat_id;
                    $courierProduct->qty = $request->quantity[$i];
                    $courierProduct->fee = $request->quantity[$i] * $courierType->price;
                    $courierProduct->save();
                }
                
            }
            $courierPayment = new TransfertPayment();
            $courierPayment->transfert_id = $courier->id;
            $courierPayment->branch_id =$user->branch_id;
            $courierPayment->date =$date_paiement;
            $courierPayment->transfert_senderid = $sende_id;
            $courierPayment->transfert_receiverid = $receive_id;
            if ($user->branch->country == 'CIV') {
                $courierPayment->sender_amount = $request->total_payer;
                $courierPayment->receiver_amount = $request->total_payer / 656;
            } else {
                $courierPayment->sender_amount = $request->total_payer;
                $courierPayment->receiver_amount = $request->total_payer * 656;
            }


            $courierPayment->reftransfert = getTrx();
            $courierPayment->status = 0;
            $courierPayment->save();

            $q = DB::table('transfert_product')->where('transfert_id', $courier->id)->where('type_cat_id',1)->sum('qty');
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
                $status_payer= $request->total_payer - $request->montant_payer ;
                if($status_payer < 0)
                {
                    $notify[] = ['error', 'Montant payé incorrect'];
                    return back()->withNotify($notify);
                }
                
                $payer = new Paiement();
                $payer->user_id = $user->id;
                $payer->branch_id = $user->branch_id;
                $payer->sender_branch_id = $user->branch_id;
                $payer->transfert_id = $courierPayment->id;
                $payer->refpaiement = getTrx();
                $payer->sender_payer = $request->montant_payer;
                $payer->receiver_payer = $request->montant_payer * 656;
                $payer->mode_paiement = $request->mode;
                $payer->date_paiement = $date_paiement;
                if ($status_payer == 0) {
                    $payer->status = '2';
                } else 
                {
                    $payer->status = '1';
                }
                $payer->save();

                $update = TransfertPayment::where('transfert_id', $courierPayment->id)->update(array('status' => $payer->status));

                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $user->id;
                $adminNotification->title = 'Paiement Frais Chauffeur ' . $user->username;
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
            $adminNotification->title = 'Nouveau Colis Enregistré ' . $user->username;
            $adminNotification->click_url = urlPath('admin.courier.info.details', $id);
            $adminNotification->save();
            DB::commit();

            $notify[] = ['success', 'Transfert enregistré avec succès'];
        } catch (Exception $e) {

            DB::rollback();
        }

        return redirect()->route('staff.transfert.liste')->withNotify($notify);
    }



    //ENREGISTREMENT TRANSFERT SOUCHE CHAUFFEUR
    public function rdvstore(Request $request)
    {

        $request->validate([
            'branch' => 'required|exists:branches,id',
            'receiver_name' => 'max:100',
            //'receiver_email' => 'email|max:40',
            'receiver_phone' => 'max:22',
            'receiver_address' => 'max:255',
            'reference' => 'required|max:20|unique:transferts,reference_souche',
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
            $totalRecupAmount = 0;
            $totalDepotAmount = 0;
            $totalServiceAmount = 0;
            $date_paiement = date('Y-m-d');
            $rdv = Rdv::where('code', $request->refrdv)->first();
            $mission = Mission::where('idmission',$rdv->mission_id)->first();
            $date_mission = date('Y-m-d h:i:s', strtotime($mission->date));
                //SUPPRIMER ELEMENT RDV POUR METTRE A JOUR 
                $delete_product =RdvProduct::where('rdv_idrdv',$rdv->idrdv)->delete();
            for ($i = 0; $i < count($request->courierName); $i++) {
                $courierType = Type::where('id', $request->courierName[$i])->where('status', 1)->firstOrFail();
                if ($request->rdvName[$i] == 2) {
                    $totalDepotAmount += $request->amount[$i]; 
                       
                } else {
                    $totalRecupAmount += $request->amount[$i];
                }
                
                $totalServiceAmount += $request->amount[$i];
                
                
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
                
               // dd('recup '.$totalRecupAmount);
            }
             // MISE A JOUR MONTANT RDV 
             $montant=$totalDepotAmount + $totalRecupAmount;
             $rdv_update=Rdv::where('idrdv',$rdv->idrdv)->update(array('sender_idsender' => $request->sender_id,'montant'=>$montant));
             $rdv_update_paiement=RdvPayment::where('rdv_id',$rdv->idrdv)->update(array('rdv_senderid' => $request->sender_id,'amount'=>$totalDepotAmount,'recup_amount'=>$totalRecupAmount));
             
            // VERIFIER SI MONTANT RECUP EST SUPERIEUR A ZERO ET DESTINATAIRE EXISTE ALORS ENREGISTRER TRANSFERT 
            if($totalRecupAmount > 0 )
            {
                if($request->receiver_phone == null){
                    $notify[]=['error','Ajouter  télephone Destinataire'];
                    return back()->withNotify($notify);
                }else{
                $receiver_user = Client::where('contact', $request->receiver_phone)->first();
                if (!isset($receiver_user)) {
                    $receiver = new Client();
                    $receiver->nom = strtoupper($request->receiver_name);
                    $receiver->contact = $request->receiver_phone;
                    $receiver->email = $request->receiver_email;
                   // $receiver->adresse = $request->receiver_adresse;
                    $receiver->save();
                    $receive_id = $receiver->id;
                } else {
                    $receive_id = $receiver_user->id;
                }
                

                $courier = new Transfert();
                $courier->code = getTrx();
                $courier->reference_souche = $request->reference;
                $courier->sender_branch_id = $user->branch_id;
                $courier->sender_staff_id = $user->id;
                $courier->sender_idsender = $request->sender_id;
                $courier->receiver_idreceiver = $receive_id;
                $courier->type_envoi='1';//1 maritime 2 Aerien
                $courier->receiver_branch_id = $request->branch;
                $courier->facture_idfacture = $request->refrdv;
                $courier->receiver_satff_id =$rdv->idrdv;
                $courier->status = 0;
                if ($request->message != null) {
                    $courier->note = $request->message;
                }
                $courier->save();

                //ENREGISTRER ACTIVITE
                if($courier){
                    activity('Nouveau transfert')
                    ->performedOn($courier)
                    ->causedBy($user)
                    ->withProperties(['customProperty' => 'customValue'])
                    ->log('Transfert '.$request->reference.' créé par ' . $user->username);
                }
                $id = $courier->id;
                //ENREGISTRER ADRESSE
                    $adresse= new RdvAdresse();
                    $adresse->client_id =$receive_id;
                    $adresse->rdv_id =$request->reference;
                    $adresse->adresse =$request->receiver_address;
                   // $adresse->code_postal=$request->sender_code_postal;
                    $adresse->save();
                // ENREGISTRER LISTE PRODUIT A ENVOYER

                for ($i = 0; $i < count($request->courierName); $i++) {
                    $courierType = Type::where('id', $request->courierName[$i])->where('status', 1)->firstOrFail();
                    //if ($request->rdvName[$i] != 2) { prendre tout en compte 
                        // $totalRecupAmount += $request->amount[$i];
                        $courierProduct = new TransfertProduct();
                        $courierProduct->transfert_id = $courier->id;
                        $courierProduct->transfert_type_id = $courierType->id;
                        $courierProduct->type_cat_id = $courierType->cat_id;
                        $courierProduct->qty = $request->quantity[$i];
                        $courierProduct->fee = $request->amount[$i];
                        $courierProduct->save();
                   // }
                    
                }

                $courierPayment = new TransfertPayment();
                $courierPayment->transfert_id = $courier->id;
                $courierPayment->branch_id = $user->branch_id;
                $courierPayment->date = $date_paiement;
                $courierPayment->transfert_senderid = $request->sender_id;
                $courierPayment->transfert_receiverid = $receive_id;
                $courierPayment->sender_amount = $totalServiceAmount;
                $courierPayment->receiver_amount = $totalServiceAmount * 656;
                $courierPayment->reftransfert = getTrx();
                $courierPayment->status = 0;
                $courierPayment->save();

                $q = DB::table('transfert_product')->where('transfert_id', $courier->id)->where('type_cat_id',1)->sum('qty');
                if ($q == 1) {
                    $transfertRef = new TransfertRef();
                    $transfertRef->transfert_id = $courier->id;
                    $transfertRef->ref_souche_part = $request->reference;
                    $transfertRef->status = 0;
                    $transfertRef->save();
                } else {
                    for ($i = 0; $i < $q; $i++) {
                        $refsouch = $i+1;
                        $transfertRef = new TransfertRef();
                        $transfertRef->transfert_id = $courier->id;
                        $transfertRef->ref_souche_part = $request->reference . '-'.$refsouch.'/'.$q;
                        $transfertRef->status = 0;
                        $transfertRef->save();
                    }
                }

                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $user->id;
                $adminNotification->title = 'Nouveau Colis Enregistré ' . $user->username;
                $adminNotification->click_url = urlPath('admin.courier.info.details', $id);
                $adminNotification->save();
             }
            }
          // enregistrement paiement en une seule fois avec branche transaction
            if($request->montant_payer > 0){
                $rdv = Rdv::where('code', $request->refrdv)->first();
                $payment = RdvPayment::where('rdv_id', $rdv->idrdv)->first();

                $reste_payer = $totalServiceAmount - $request->montant_payer;
                  
                $payer = new Paiement();
                $payer->user_id = $user->id;
                $payer->branch_id = $user->branch_id;
                $payer->rdv_id = $rdv->idrdv;  
                $payer->sender_payer = $request->montant_payer;
                $payer->receiver_payer = $request->montant_payer * 656;
                $payer->date_paiement = $date_paiement;
                $payer->refpaiement = getTrx();
                if($totalRecupAmount > 0){
                  $payer->transfert_id = $courierPayment->id;
                }
                if ( $reste_payer == 0) {
                    $payer->status = '2';
                }else{
                    $payer->status = '1';
                }
                $payer->mode_paiement = $request->mode;
                $payer->save();
                
                
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
                
                if($totalRecupAmount > 0){
                 $update = TransfertPayment::where('transfert_id', $courierPayment->id)->update(array('status' => $payer->status));

                }
              

            }
           
            //SI MONTANT DEPOT EST SUPERIEUR A ZERO ALORS ON ENREGISTRE D ABORD LE MONTANT A PAYER POUR LE RENDEZ VOUS
            $montantRdvPayer = 0;
            if ($totalDepotAmount > 0 && $request->montant_payer >= $totalDepotAmount)
            {
                
                //dd($request->montant_payer);
                $user = Auth::user();
                $rdv = Rdv::where('code', $request->refrdv)->first();
                $payment = RdvPayment::where('rdv_id', $rdv->idrdv)->first();

/*
                $payer = new Paiement();
                $payer->user_id = $user->id;
                $payer->branch_id = $user->branch_id;
                $payer->rdv_id = $rdv->idrdv;
                $payer->date_paiement = $date_paiement;
                $payer->refpaiement = getTrx();
                if ($request->montant_payer > $totalDepotAmount) {
                    $payer->sender_payer = $totalDepotAmount;
                    $payer->status = '2';
               }else{
                    
                    $payer->sender_payer = $request->montant_payer;
                    $payer->status = '1';
                }
                $payer->mode_paiement = $request->mode;
                $payer->save();
                */
               if ($request->montant_payer > $totalDepotAmount) {
                    $status = '2';
               }else{
                    $status = '1';
                }
                $update = RdvPayment::where('rdv_id', $rdv->idrdv)->update(array('amount'=> $totalDepotAmount,'status' => $status));

                //$payment->chauffeur_id=
                $payment->status = $payer->status;
                $payment->save();

               /*
                $branchtransaction = new BranchTransaction();
                $branchtransaction->branch_id = $user->branch_id;
                $branchtransaction->type = 'credit';
                if ($request->montant_payer > $totalDepotAmount) {
                $branchtransaction->amount = $totalDepotAmount;
                }elseif($request->montant_payer == $totalDepotAmount){
                    $branchtransaction->amount = $request->montant_payer;
                }
                $branchtransaction->reff_no = getTrx();
                $branchtransaction->created_by = $user->id;
                $branchtransaction->transaction_id = $payment->refrdv;
                $branchtransaction->transaction_payment_id = $payer->id;
                $branchtransaction->operation_date= $date_paiement;
                $branchtransaction->type_transaction ='3';
                $branchtransaction->save();
*/
                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $request->sender_id;
                $adminNotification->title = 'Paiement Frais RDV ';
                $adminNotification->click_url = urlPath('staff.rdv.details', $payment->rdv_id);
                $adminNotification->save();

                $montantRdvPayer =  $payer->sender_payer;
                
            }
            /*elseif($totalDepotAmount > 0 && $request->montant_payer < $totalDepotAmount)
            {
           // //else{
                // le montant payé est inferieur au montant total du depot donc retour erreur
              $notify[]=['error','Le Montant payé est inferieur au montant du depôt'];
                   return back()->withNotify($notify);
            }
            */
            
            $montantTransfertPayer=0;
            if ($totalRecupAmount > 0){
                $reste_payer = $request->montant_payer - $montantRdvPayer;
                if ($reste_payer > 0  && $reste_payer <= $totalRecupAmount ) 
                {
                  $status_payer = $reste_payer - $totalRecupAmount;
                  
                 $montantTransfertPayer=$reste_payer;
                 
                   /* $payer = new Paiement();
                    $payer->user_id = $user->id;
                    $payer->branch_id = $user->branch_id;
                    $payer->sender_branch_id = $user->branch_id;
                    $payer->transfert_id = $courierPayment->id;
                    $payer->refpaiement = getTrx();
                    $payer->sender_payer = $reste_payer;
                    $payer->receiver_payer = $reste_payer * 656;
                    $payer->mode_paiement = $request->mode;
                    $payer->date_paiement = $date_paiement;
                    if ($status_payer == 0) {
                        $payer->status = '2';
                    } else 
                    {
                        $payer->status = '1';
                    }
                    $payer->save();
                    */

                    $adminNotification = new AdminNotification();
                    $adminNotification->user_id = $user->id;
                    $adminNotification->title = 'Paiement Frais Chauffeur ' . $user->username;
                    $adminNotification->click_url = urlPath('admin.courier.info.details', $id);
                    $adminNotification->save();
                }
                /*
                    $branchtransaction = new BranchTransaction();
                    $branchtransaction->branch_id = $user->branch_id;
                    $branchtransaction->type = 'credit';
                    $branchtransaction->amount = $reste_payer;
                    $branchtransaction->reff_no = getTrx();
                    $branchtransaction->operation_date= $date_paiement;
                    $branchtransaction->created_by = $user->id;
                    $branchtransaction->transaction_id = $request->refrdv;
                    $branchtransaction->type_transaction ='1';
                    $branchtransaction->transaction_payment_id = $payer->id;
                    $branchtransaction->save();
                    
                }
                //else{
                     // le montant payé est superieur au montant total du transfert donc retour erreur
               // $notify[]=['error','Le Montant payé est superieur au montant du transfert'];
                  //  return back()->withNotify($notify);
               // }
               */
            }
            $totalEncaisse=$montantRdvPayer + $montantTransfertPayer;
            $rdv_update = Rdv::where('code', $request->refrdv)->update(array('status' => '3','encaisse' =>$totalEncaisse));
           


            DB::commit();
            $rdv=Rdv::where('code',$request->refrdv)->first();
            $notify[] = ['success', 'Transfert enregistré avec succès'];
            return redirect()->route('staff.mission.detailmission', encrypt($rdv->mission_id))->withNotify($notify);

        } catch (Exception $e) {

            DB::rollback();
        }
      
       
    }


    public function invoice($id)
    {
        $pageTitle = "Facture Transfert";
        $userInfo = Auth::user();
        $courierInfo = Transfert::where('id', decrypt($id))->first();
        $courierProductInfos = TransfertProduct::where('transfert_id', $courierInfo->id)->with('type')->get();
        $courierProductRef = TransfertRef::where('transfert_id', $courierInfo->id)->get();
        $courierPayment = TransfertPayment::where('transfert_id', $courierInfo->id)->first();
        $code = '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($courierInfo->code, 'C128') . '" alt="barcode"   />' . "<br>" . $courierInfo->code;
        return view('staff.invoice_transfert', compact('pageTitle', 'courierInfo', 'courierProductRef', 'courierProductInfos', 'courierPayment', 'userInfo', 'code'));
    }

    public function detail($id)
    {
        $userInfo = Auth::user();
        $pageTitle = "Detail Transfert";
        $courierInfo = Transfert::where('id', decrypt($id))->with('paiement.agent', 'paiement.modepayer')->first();
        $courierProductInfos = TransfertProduct::where('transfert_id', $courierInfo->id)->with('type')->get();
        $courierProductRef = TransfertRef::where('transfert_id', $courierInfo->id)->get();
        $courierPayment = TransfertPayment::where('transfert_id', $courierInfo->id)->first();
        $deja_payer_sender=Paiement::where('transfert_id',decrypt($id))->where('branch_id',1)->sum('sender_payer');
        $deja_payer_receiver=Paiement::where('transfert_id',decrypt($id))->where('sender_branch_id',1)->sum('receiver_payer');
        $conteneur=ContainerNbcolis::where('id_colis',decrypt($id))->with('conteneur')->get();
        $programme=Rdv::where('idrdv',$courierInfo->receiver_satff_id)->with('senderStaff','mission','mission.chauffeur','mission.staff')->first();
        $rdv_detail = Rdv::with('adresse')->findOrFail($courierInfo->receiver_satff_id);

        // dd($programme);
        return view('staff.transfert.detail', compact('pageTitle', 'userInfo', 'courierInfo', 'courierProductRef', 'courierProductInfos', 'courierPayment','deja_payer_sender','deja_payer_receiver','conteneur','programme','rdv_detail'));
    }

    public function edit($id)
    {
        $pageTitle = "Modifier Transfert";
        $courierInfo = Transfert::where('id', decrypt($id))->with('receiver_adresse')->first();
        $admin = Auth::user();
        $courierProductInfos = TransfertProduct::where('transfert_id', $courierInfo->id)->with('type')->get();
        $courierProductRef = TransfertRef::where('transfert_id', $courierInfo->id)->get();
        $courierPayment = TransfertPayment::where('transfert_id', $courierInfo->id)->first();
        $branchs = Branch::where('status', 1)->where('id', '!=', $admin->branch_id)->latest()->get();
        $types = Type::where('status', 1)->where('cat_id','<',2)->with('unit')->latest()->get();
        $deja_payer=Paiement::where('transfert_id',decrypt($id))->where('branch_id',$admin->branch_id)->sum('sender_payer');
       // dd($courierInfo);
        return view('staff.transfert.edit', compact('pageTitle', 'courierInfo', 'courierProductRef', 'courierProductInfos', 'courierPayment','branchs','types','deja_payer'));
    }
    public function transfert_payment(Request $request)
    {
        //dd($request);
        $user = Auth::user();
        $transfert = Transfert::where('code', $request->code)->first();
        $transfertPayment = TransfertPayment::where('transfert_id', $transfert->id)->first();
        $amount = $request->montant_payer;
        // dd($transfertPayment);
        if ($user->branch_id == $transfert->sender_branch_id) {
            if ($user->branch->country == 'CIV') {
                $sender_payer = $request->montant_payer;
                $receiver_payer = $request->montant_payer / 656;
                $totpayer = DB::table('paiements')
                    ->where('transfert_id', $transfert->id)
                    ->get(DB::raw('SUM(sender_payer) AS deja_payer'));
            } else {
                $sender_payer = $request->montant_payer;
                $receiver_payer = $request->montant_payer * 656;
                $totpayer = DB::table('paiements')
                    ->where('transfert_id', $transfert->id)
                    ->get(DB::raw('SUM(sender_payer) AS deja_payer'));
            }
        } else {
            if ($user->branch->country == 'CIV') {
                $receiver_payer = $request->montant_payer;
                $sender_payer = $request->montant_payer / 656;
                $totpayer = DB::table('paiements')
                    ->where('transfert_id', $transfert->id)
                    ->get(DB::raw('SUM(receiver_payer) AS deja_payer'));
            } else {
                $receiver_payer = $request->montant_payer;
                $sender_payer = $request->montant_payer * 656;
                $totpayer = DB::table('paiements')
                    ->where('transfert_id', $transfert->id)
                    ->get(DB::raw('SUM(receiver_payer) AS deja_payer'));
            }
        }

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
                $payer = new Paiement();
                $payer->user_id = $user->id;
                $payer->branch_id = $user->branch_id;
                $payer->sender_branch_id = $payment->transfert->sender_branch_id;
                $payer->transfert_id = $payment->transfert_id;
                $payer->refpaiement = getTrx();
                $payer->sender_payer = $sender_payer;
                $payer->receiver_payer = $receiver_payer;
                $payer->mode_paiement = $request->mode;
                $payer->date_paiement = $date_paiement;
                if ($request->montant_payer = $payment->amount) {
                    $payer->status = '2';
                } elseif ($request->montant_payer < $payment->amount) {
                    $payer->status = '1';
                }
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
                $adminNotification->title = 'Paiement Frais Envoi '; //. $payment->transfert->client->nom
                $adminNotification->click_url = urlPath('staff.transfert.detail', $payment->transfert_id);
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
       // dd($request);
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
            $courier = Transfert::where('id',$request->transfert_id)->firstOrFail();
            $old_user= $courier->sender_staff_id ;

            $courier->reference_souche = $request->reference;
            $courier->sender_branch_id = $user->branch_id;
            $courier->sender_staff_id = $user->id;
            $courier->sender_idsender = $sende_id;
            $courier->receiver_idreceiver = $receive_id;
            $courier->receiver_branch_id = $request->branch;
            $courier->status = 0;
            $courier->type_envoi=$request->envoi;//1 maritime 2 Aerien
            $courier->save();
            $id = $courier->id;
            //ENREGISTRER ACTIVITE
            if($courier){
                activity('Nouveau transfert')
                ->performedOn($courier)
                ->causedBy($user)
                //->withProperties(['customProperty' => 'customValue'])
                ->log('Modification Transfert '.$request->reference.' créé par ' . $user->username);
            }
            //mise à jour adresse destinataire
            $delete_adresse= RdvAdresse::where('rdv_id',$request->transfert_id)->delete();
            $receiver_adresse= new RdvAdresse();
            $receiver_adresse->client_id =$receive_id;
            $receiver_adresse->rdv_id =$id;
            $receiver_adresse->adresse =$request->receiver_address;
            $receiver_adresse->save();

            $totalAmount = 0;
            $delete_product =TransfertProduct::where('transfert_id',$request->transfert_id)->delete();
            for ($i = 0; $i < count($request->courierName); $i++) {
                $courierType = Type::where('id', $request->courierName[$i])->where('status', 1)->firstOrFail();
                if ($user->branch->country == 'CIV') {
                    $totalAmount += ($request->quantity[$i] * $courierType->price) * 656;
                } else {
                    $totalAmount += $request->quantity[$i] * $courierType->price;
                }
                if($courierType->cat_id != 3){
                    $courierProduct = new TransfertProduct();
                    $courierProduct->transfert_id = $courier->id;
                    $courierProduct->transfert_type_id = $courierType->id;
                    $courierProduct->type_cat_id = $courierType->cat_id;
                    $courierProduct->qty = $request->quantity[$i];
                    $courierProduct->fee = $request->amount[$i];
                    $courierProduct->save();
                }
                
            }


            $courierPayment =TransfertPayment::where('transfert_id',$request->transfert_id)->firstOrFail();

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
                $subject = 'Modification Montant Tranfert '.$request->reference;
                $message = 'Le Montant du Transfert de Reference '.$request->reference.' a été modifié ce jour par '.$user->firstname.' '.$user->lastname.' Ancien Montant: '.$old_amount.' Nouveau Montant: '.$new_amount;   ;

                try {
                    sendGeneralEmail('lbagate@yahoo.fr', $subject, $message, $receiver_name);
                } catch (\Exception $exp) {
                    // $notify[] = ['error', 'Invalid credential'];
                    // return back()->withNotify($notify);
                }

               
            }
        //FIN ALERTE
            $courierPayment->branch_id =$user->branch_id;
            $courierPayment->date =$date_paiement;
            $courierPayment->transfert_senderid = $sende_id;
            $courierPayment->transfert_receiverid = $receive_id;
            if ($user->branch->country == 'CIV') {
                $courierPayment->sender_amount = $totalAmount;
                $courierPayment->receiver_amount = $totalAmount / 656;
            } else {
                $courierPayment->sender_amount = $request->total_payer;
                $courierPayment->receiver_amount = $request->total_payer * 656;
            }
            if($request->total_payer == $request->deja_payer)
            {
                $courierPayment->status = 2;
            }elseif($request->total_payer > $request->deja_payer && $request->deja_payer != 0)
            {
                $courierPayment->status = 1;
            }
            $courierPayment->save();

            $delete_trans_ref=TransfertRef::where('transfert_id',$request->transfert_id)->delete();
            $q = DB::table('transfert_product')->where('transfert_id', $courier->id)->where('type_cat_id',1)->sum('qty');
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
                          $payer->transfert_id = $courierPayment->id;
                          $payer->refpaiement = getTrx();
                          $payer->sender_payer = $request->montant_payer;
                          $payer->receiver_payer = $request->montant_payer * 656;
                          $payer->mode_paiement = $request->mode;
                          $payer->date_paiement = $date_paiement;
                          if ($status_payer == 0) {
                              $payer->status = '2';
                          } else 
                          {
                              $payer->status = '1';
                          }
                          $payer->save();
          
                          $update = TransfertPayment::where('transfert_id', $courierPayment->id)->update(array('status' => $payer->status));
          
                          $adminNotification = new AdminNotification();
                          $adminNotification->user_id = $user->id;
                          $adminNotification->title = 'Paiement Frais Transfert ' . $user->username;
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
                    $adminNotification->title = 'Transfert Modifié ' . $user->username;
                    $adminNotification->click_url = urlPath('admin.courier.info.details', $id);
                    $adminNotification->save();
                    DB::commit();
        
                    $notify[] = ['success', 'Transfert modifié avec succès'];


        }catch (Exception $e) {

            DB::rollback();
        }
        //dd('ok');
        return redirect()->route('staff.transfert.liste')->withNotify($notify);
    }

    
        public function delete(Request $request){

            $user = Auth::user();
            $rdv_code = Transfert::where('id',$request->refpaiement)->first(); 
            
             $rdv_restore=Rdv::where('code',$rdv_code->facture_idfacture)->first();
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
                if($rdv_restore)
                     {
                    $rdv_restore->status ='2';
                    $rdv_restore->save();
                    $rdv_payment=RdvPayment::where('rdvref',$rdv_code->facture_idfacture)->firstOrFail();
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
           

            $courier = Transfert::where('id',$request->refpaiement)->delete();
            $courierPayment =TransfertPayment::where('transfert_id',$request->refpaiement)->delete();
            $adminNotification = new AdminNotification();
                        $adminNotification->user_id = $user->id;
                        $adminNotification->title = 'Transfert Supprimé ' . $user->username;
                        $adminNotification->click_url = urlPath('admin.courier.info.details', $request->refpaiement);
                        $adminNotification->save();
                        
                        activity('Suppression transfert')
                        ->performedOn($courier)
                        ->causedBy($user)
                       // ->withProperties(['customProperty' => 'customValue'])
                        ->log('Suppression Tranfert par ' . $user->username);

            $notify[] = ['success', 'Envoi supprimé avec succès'];
            return back()->withNotify($notify);

            }

           
    
        }

        public function transfertSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $pageTitle = "Recherche Transfert";
        $emptyMessage = "Aucun Transfert";
        $user = Auth::user();
        $transferts = Transfert::where('sender_branch_id', $user->branch_id)->with('sender', 'receiver', 'paymentInfo')->withSum('paiement as payer','sender_payer')->where('reference_souche','like', '%'.$search.'%')->orWhere(function ($query) use ($search) {
            $query->with('receiver')->whereHas('receiver', function ($q) use ($search) {
                $q->where('contact', 'like', '%' . $search . '%');
            });
        })->orWhere(function ($query) use ($search) {
            $query->with('receiver')->whereHas('receiver', function ($q) use ($search) {
                $q->where('nom', 'like', '%' . $search . '%');
            });
        })->orWhere(function ($query) use ($search) {
            $query->with('sender')->whereHas('sender', function ($q) use ($search) {
                $q->where('contact', 'like', '%' . $search . '%');
            });
        })->orWhere(function ($query) use ($search) {
            $query->with('sender')->whereHas('sender', function ($q) use ($search) {
                $q->where('nom', 'like', '%' . $search . '%');
            });
        })->paginate(getPaginate());
        return view('staff.transfert.index', compact('transferts', 'user', 'pageTitle', 'emptyMessage','search'));
    }
    public function transfertDateSearch(Request $request)
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
            return redirect()->route('admin.courier.info.index')->withNotify($notify);
        }
        $pageTitle = "Recherche Transfert";
        $dateSearch = $search;
        $emptyMessage = "Aucun Transfert";
        $transferts = Transfert::where('sender_branch_id', $user->branch_id)->with('sender', 'receiver', 'paymentInfo')->whereBetween('created_at', [Carbon::parse($start), Carbon::parse($end)])->orderBy('id', 'DESC')->paginate(getPaginate());

        // $courierLists = CourierInfo::where('sender_staff_id', $user->id)->orWhere('receiver_staff_id', $user->id)->whereBetween('created_at', [Carbon::parse($start), Carbon::parse($end)])->orderBy('id', 'DESC')->with('senderBranch', 'receiverBranch', 'senderStaff', 'receiverStaff', 'paymentInfo')->paginate(getPaginate());
        // return view('staff.courier.list', compact('pageTitle', 'emptyMessage', 'courierLists', 'dateSearch'));
        return view('staff.transfert.index', compact('transferts', 'user', 'pageTitle', 'emptyMessage','dateSearch'));

    }
    public function transfertSearchReceive(Request $request)
    {
        $request->validate(['search' => 'required']);
       
        $pageTitle = "Recherche Transfert";
        $emptyMessage = "Aucun Transfert";
        $user = Auth::user();
         $search = $request->search;
        $transferts = Transfert::where('receiver_branch_id', $user->branch_id)->with('sender', 'receiver', 'paymentInfo')->withSum('paiement as payer','receiver_payer')->where('reference_souche','like', '%'.$search.'%')->orWhere(function ($query) use ($search) {
            $query->with('receiver')->whereHas('receiver', function ($q) use ($search) {
                $q->where('contact', 'like', '%' . $search . '%');
            });
        })->orWhere(function ($query) use ($search) {
            $query->with('receiver')->whereHas('receiver', function ($q) use ($search) {
                $q->where('nom', 'like', '%' . $search . '%');
            });
        })->orWhere(function ($query) use ($search) {
            $query->with('sender')->whereHas('sender', function ($q) use ($search) {
                $q->where('contact', 'like', '%' . $search . '%');
            });
        })->orWhere(function ($query) use ($search) {
            $query->with('sender')->whereHas('sender', function ($q) use ($search) {
                $q->where('nom', 'like', '%' . $search . '%');
            });
        })->where('status','>',0)->paginate(getPaginate());
        return view('staff.transfert.receive', compact('transferts', 'user', 'pageTitle', 'emptyMessage','search'));
    }
    public function transfertSearchReceiveFFF(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $pageTitle = "Recherche Transfert";
        $emptyMessage = "Aucun Transfert";
        $user = Auth::user();
        $transferts = Transfert::where('receiver_branch_id', $user->branch_id)->where('status','>',0)->with('sender', 'receiver', 'paymentInfo')->where('reference_souche','like', '%'.$search.'%')->withSum('paiement as payer','receiver_payer')->paginate(getPaginate());
        return view('staff.transfert.receive', compact('transferts', 'user', 'pageTitle', 'emptyMessage','search'));
    }
    public function livraison($id)
    {
        $userInfo = Auth::user();
        $pageTitle = "Livraison Transfert";
        $courierInfo = Transfert::where('id', decrypt($id))->with('paiement.agent', 'paiement.modepayer')->first();
        $courierProductInfos = TransfertProduct::where('transfert_id', $courierInfo->id)->with('type')->get();
        $courierProductRef = TransfertRef::where('transfert_id', $courierInfo->id)->get();
        $courierPayment = TransfertPayment::where('transfert_id', $courierInfo->id)->first();
        $deja_payer_sender=Paiement::where('transfert_id',decrypt($id))->where('branch_id',$userInfo->branch_id)->sum('sender_payer');
        $deja_payer_receiver=Paiement::where('transfert_id',decrypt($id))->where('branch_id',$userInfo->branch_id)->sum('receiver_payer');
        $conteneur=ContainerNbcolis::where('id_colis',decrypt($id))->with('conteneur')->get();
       // dd($conteneur);
         
        return view('staff.transfert.livraison', compact('pageTitle', 'userInfo', 'courierInfo', 'courierProductRef', 'courierProductInfos', 'courierPayment','deja_payer_sender','deja_payer_receiver','conteneur'));
    }

    public function livraison_validate(Request $request){
        $user = Auth::user();
        $date_livraison = date('Y-m-d');

        $livraison= new Livraison();
        $livraison->user_id=$user->id;
        $livraison->nom=$request->nom;
        $livraison->telephone=$request->telephone;
        $livraison->piece_id=$request->piece_id;
        $livraison->colis_id=$request->colis_id;
        $livraison->date=$date_livraison;
        $livraison->description=$request->description;
        $livraison->save();

        $transfert=Transfert::where('id',$request->colis_id)->get();
        $status=$transfert[0]->status;
        if($status == 2){
            $transfert_update=Transfert::where('id',$request->colis_id)->update(array('container_id'=>'2'));
        }elseif($status == 1){
            $transfert_update=Transfert::where('id',$request->colis_id)->update(array('container_id'=>'1'));
        }
        $container_update=ContainerNbcolis::where('container_id',$request->container_id)->where('id_colis',$request->colis_id)->update(array('date_livraison' => $date_livraison));

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'Livraison Colis ' . $user->username;
        $adminNotification->click_url = urlPath('admin.courier.info.details', $request->colis_id);
        $adminNotification->save();
        $notify[] = ['success', 'Colis Livré avec succès'];
        return redirect()->route('staff.transfert.livraison_invoice',[encrypt($request->colis_id),encrypt($request->container_id)])->withNotify($notify);

    }
     public function livraison_invoice($colis_id,$container_id){
       // dd(decrypt($colis_id));
       $livraison=ContainerNbcolis::where('container_id',decrypt($container_id))->where('id_colis',decrypt($colis_id))->with('conteneur','livraison','colis')->first();
       $code = '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($livraison->colis->reference_souche, 'C128') . '" alt="barcode"   />' . "<br> #" . $livraison->colis->reference_souche;

       //dd($livraison);
        return view('staff.transfert.livraison_invoice', compact('livraison','code'));

     }

     public function getReceiveDelivery(Request $request)
     {
         $user = Auth::user();
         $pageTitle = "Transferts Livrés";
         $emptyMessage = "Aucun Colis";
         $user = Auth::user();
         $transferts =Livraison::with('transfert','transfert.receiver','transfert.sender','transfert.paymentInfo','livreur')->orderBy('created_at','DESC')->paginate(getPaginate());

        // $transferts = Transfert::where('receiver_branch_id', $user->branch_id)->where('container_id','!=',NULL)->orderBy('reference_souche', 'DESC')->with('senderBranch', 'receiver', 'sender', 'receiverBranch', 'senderStaff', 'receiverStaff', 'paymentInfo','courierDetail')->withSum('paiement as payer','receiver_payer')->paginate(getPaginate());
         return view('staff.transfert.delivery', compact('pageTitle', 'user', 'emptyMessage', 'transferts'));
     }

     public function getReceiveDeliverySearch(Request $request)
    {
        $request->validate(['search' => 'required']);
       
        $pageTitle = "Recherche Transfert Livré";
        $emptyMessage = "Aucun Transfert";
        $user = Auth::user();
         $search = $request->search;
        $transferts = Transfert::where('receiver_branch_id', $user->branch_id)->with('sender', 'receiver', 'paymentInfo')->withSum('paiement as payer','receiver_payer')->where('reference_souche','like', '%'.$search.'%')->orWhere(function ($query) use ($search) {
            $query->with('receiver')->whereHas('receiver', function ($q) use ($search) {
                $q->where('contact', 'like', '%' . $search . '%');
            });
        })->orWhere(function ($query) use ($search) {
            $query->with('receiver')->whereHas('receiver', function ($q) use ($search) {
                $q->where('nom', 'like', '%' . $search . '%');
            });
        })->orWhere(function ($query) use ($search) {
            $query->with('sender')->whereHas('sender', function ($q) use ($search) {
                $q->where('contact', 'like', '%' . $search . '%');
            });
        })->orWhere(function ($query) use ($search) {
            $query->with('sender')->whereHas('sender', function ($q) use ($search) {
                $q->where('nom', 'like', '%' . $search . '%');
            });
        })->where('container_id','!=',NULL)->paginate(getPaginate());
        return view('staff.transfert.delivery', compact('transferts', 'user', 'pageTitle', 'emptyMessage','search'));
    }
    function sendSms( $message)
    { 
     
       $curl = curl_init();
    
      /*TEST*/
      // $BASE_URL = "https://5v4p6j.api.infobip.com";
      // $API_KEY = "App 884683fde796d3d9d7afb4bb355daa1b-ac7d401b-ad12-4bbe-b34e-1c8891c85f15";
       /** */
    $BASE_URL= "https://gygyrw.api.infobip.com";
    $API_KEY = "App 53ac56146d9ddda8f3396fb303fe5101-27968279-6a9d-4962-83a2-562d37ac649c";
      
 
       $SENDER = "CHALLENGE ALERTE";
       $RECIPIENT = "002250759664106";
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
       $idmessage=$res->messages[0]->messageId;
       $code=json_decode(($httpcode));
       //dd($code);
       curl_close($curl);
       if($code == 200){
          $date = date('Y-m-d');   
          $sauvegarde=DB::INSERT(" INSERT INTO `sms_envoi`(`date`, `idmission`, `rdv_id`, `contact`, `status`, `messageid`) VALUES ('$date','901','901','$RECIPIENT','200','$idmessage') ");
          return ;
       }
       
 
    
 
       // HTTP code: 200 Response body: {"messages":[{"to":"2250759393911","status":{"groupId":1,"groupName":"PENDING","id":26,"name":"PENDING_ACCEPTED","description":"Message sent to next instance"},"messageId":"34175105815303572542"}]}
    }
    
}
