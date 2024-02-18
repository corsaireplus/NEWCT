<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Type;
//use App\Models\Mission;
//use App\Models\Rdv;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Sender;
use App\Models\Rdv;
use App\Models\User;
use App\Models\Paiement;
use App\Models\RdvProduct;
use App\Models\Mission;
use App\Models\BranchTransaction;
use App\Models\Receiver;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use App\Models\TransactionFacture;
use App\Models\TransfertRef;
use App\Models\Client;
use App\Models\RdvAdresse;
use App\Models\RdvPayment;
use App\Models\ContainerNbcolis;
use App\Models\Livraison;
use App\Models\PrixModif;
use App\Models\GeneralSetting;
use App\Models\CompteurRdvChauffeur;
use App\Models\AdminNotification;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\SmsController;


class ApiController extends Controller
{
    public function types_colis(Request $request ){
        
    $types = Type::where('status', 1)->with('unit')->latest()->get();
    if(!empty($types)){
             return response()->json(['types_colis' => $types], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

    }
    
    public function mission(Request $request,$id){
        //recuperer la liste des missions du jour pour le chauffeur connecté
      
        $mission = Mission::where('chauffeur_idchauffeur',$id)->where('status',0)->latest('created_at')->first();
        
        
      if($mission){
             return response()->json(['mission' => $mission], 200);
           // $dateFromDB = $mission->date;  // Supposons que c'est la date que vous obtenez de la base de données
            //$dateObject = Carbon::createFromFormat('d-m-Y', $dateFromDB);
            //dd($dateObject);
            //$today = Carbon::now();  // Date du jour
            // Maintenant, vous pouvez effectuer des comparaisons
           // if ($dateObject->eq($today)) {
               
           // }else{
            //    return response()->json(['error' => 'Unauthorized'], 401);
           // }
      }else{
         return response()->json(['error' => 'Unauthorized'], 401);

      }
            

    }
    
    public function programme(Request $request,$id_mission){
         $mission=Mission::findOrFail($id_mission);
         $rdv_chauf=Rdv::with('client','rdvDetail','rdvDetail.type','adresse','transaction','depot','paymentInfo')->where('mission_id',$mission->idmission)->orderBy('order_list','asc')->get();
         if(!empty($rdv_chauf)){
            return response()->json(['rdvs' => $rdv_chauf], 200);

         }else{
            return response()->json(['error' => 'Unauthorized'], 401);

         }
    }
    public function rdvDetails(Request $request,$code){
    $rdv_chauf=Rdv::with('client','rdvDetail','adresse','transaction','depot','paymentInfo')->where('code',$code)->where('status','>=','2')->orderBy('order_list','ASC')->first();
    if(!empty($rdv_chauf)){
            return response()->json(['rdvs' => $rdv_chauf], 200);

         }else{
            return response()->json(['error' => 'Unauthorized'], 401);

         }
    }
    public function bilanProgramme(Request $request,$id_chauffeur){
        $mission = Mission::where('chauffeur_idchauffeur',$id_chauffeur)->where('status',0)->latest('created_at')->first();

        //$mission = Mission::findOrFail($id_mission);
        $totalEncaisse = Rdv::where('mission_id', $mission->idmission)
                    ->where('status', '>=', '2')
                    ->sum('encaisse');
        if(!empty($totalEncaisse)){
            return response()->json(['bilan' => $totalEncaisse], 200);
         }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }            

    }
    public function checkphone(Request $request,$phonenumber)
    {
            $data = null;
            
                $query = $phonenumber;
                $data = DB::table('clients')
                    ->join('rdv_adresse', 'clients.id', '=', 'rdv_adresse.client_id')
                    ->where('nom', 'LIKE', "%{$query}%")
                    ->orWhere('contact', 'LIKE', "%{$query}%")
                    ->first();
            
           return response()->json($data,200);
    }
    
    public function savecolis(Request $request){

   
    $formData1 = $request->get('formData1');// liste des Colis
    $formData2 = $request->get('formData2');// paiement
    $formData3 = $request->get('formData3'); // destinataire
    $formData4 = $request->get('formData4'); // expediteur
    $userID = $request->get('userID');
    
   $rules = [
        'formData4.sender_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
        'formData4.sender_name' => 'required|string|max:50',
        'formData4.sender_address' => 'required|string|max:100',
        'formData4.sender_code_postal' => 'required|string|max:50'
    ];

    $customMessages = [
        'formData4.sender_phone.required' => 'Le numéro de téléphone est requis.',
        'formData4.sender_phone.regex' => 'Le format du numéro de téléphone est invalide.',
        'formData4.sender_phone.min' => 'Le numéro de téléphone doit avoir au moins 10 chiffres.',
        'formData4.sender_phone.max' => 'Le numéro de téléphone ne peut pas avoir plus de 10 chiffres.',
        'formData4.sender_name.required' => 'Le nom est requis.',
        'formData4.sender_name.string' => 'Le nom doit être une chaîne de caractères.',
        'formData4.sender_name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
        'formData4.sender_address.required' => 'L\'adresse est requise.',
        'formData4.sender_address.string' => 'L\'adresse doit être une chaîne de caractères.',
        'formData4.sender_address.max' => 'L\'adresse ne peut pas dépasser 255 caractères.',
        'formData4.sender_code_postal.required' => 'Le code postal est requis.',
        'formData4.sender_code_postal.string' => 'Le code postal doit être une chaîne de caractères.',
        'formData4.sender_code_postal.max' => 'Le code postal ne peut pas dépasser 10 caractères.'
    ];

    $this->validate($request, $rules, $customMessages);

    $formData1 = $request->input('formData1.lines');

    if (count($formData1) < 1) {
        return response()->json(['error' => 'Le formulaire doit contenir au moins une ligne.'], 400);
    }
  //  $refrdv = $request->input('formData4.refrdv');
    $mission = Mission::where('chauffeur_idchauffeur',$request->input('userID.id')) ->latest('created_at')->first();

  
    try {
            DB::beginTransaction();
            // INITILISATION DES VARIABLES
            $user = User::where('id',$request->input('userID.id'))->first();
           // $user = User::where('id',33)->first();

            $totalRecupAmount = 0;
            $totalDepotAmount = 0;
            $totaltransaction = 0;
            $date_paiement = date('Y-m-d');

            //chequer si rffrdv exist sinon creer le rdv pour utiliser le refrdv
            if($request->input('formData4.refrdv') !=''){
                $refrdv = $request->input('formData4.refrdv');
                $sende_id =$request->input('formData4.sender_id');
                $rdv = Rdv::where('code', $request->input('formData4.refrdv'))->first();
                
             // Log::info('Display this data', ['anyData' => $rdv]);
               //                dd($request);
            }else{
                      //verifier si le chauffeur a toujour une mission en cours
                        $mission = Mission::where('chauffeur_idchauffeur',$request->input('userID.id'))->where('status',0)->latest('created_at')->first();
                        if(!$mission){
                            return response()->json(['message' => 'Vous n\'avez aucun Programme en cours', 'status' => 'error'], 400);
                        }

                         //creer un nouveau rdv et attribuer la mission au chauffeur
                           $sender_user=Client::where('contact',$request->input('formData4.sender_phone'))->first();
                           // dd($sender_user);
                           if( !isset($sender_user) )
                           {
                            $sender = new Client();
                            $sender->nom=strtoupper($request->input('formData4.sender_name'));
                            $sender->contact=$request->input('formData4.sender_phone');
                            $sender->country_id =$user->branch_id;
                            $sender->save();
                            $sende_id= $sender->id;
                    
                            $adresse= new RdvAdresse();
                            $adresse->client_id =$sende_id;
                            $adresse->adresse =$request->input('formData4.sender_address');
                            $adresse->code_postal=$request->input('formData4.sender_code_postal');
                           
                           }else{
                              
                               $sende_id= $sender_user->id;

                           }
                             // Log::info('Display this data', ['anyData' => $sende_id]);
                               // dd($request);
                           //$request->input('userID.id')
                           // $mission = Mission::where('chauffeur_idchauffeur',$request->input('userID.id')) ->latest('created_at')->first();
                           
                            $rdv= new Rdv();
                            $rdv->sender_idsender=$sende_id;
                            $rdv->status='1';
                            $rdv->code = getTrx();
                            $rdv->user_id=$user->id;
                            $rdv->mission_id =$mission->idmission;
                            $rdv->date=$mission->date;
                           // $rdv->observation=$request->observation;
                            $rdv->save();

                             $adresse->rdv_id =$rdv->id;
                             $adresse->save();
                            
                            $refrdv = $rdv->code;
                            
                             $lines = $request->input('formData1.lines');  // Récupérer le tableau 'lines' à partir de formData1
                            $courierName = array_column($lines, 'courierName');
                            $rdvName = array_column($lines, 'rdvName');
                            $amount = array_column($lines, 'amount');
                            $quantity =array_column($lines, 'quantity');
                            
                                $totalDepotAmount = 0;
                                $totalRecupAmount = 0 ;
                                $totalServiceAmount = 0; // Total montant du service depot comme recup pour avoir le montant total
                                for ($i=0; $i <count($courierName); $i++) { 
                                    $courierType = Type::where('id',$courierName[$i])->where('status', 1)->firstOrFail();
                                    if($rdvName[$i] == 2 ){
                                        $totalDepotAmount +=  $amount[$i];
                                    }else{ 
                                        $totalRecupAmount +=  $amount[$i];
                                    }
                                    $totalServiceAmount +=$amount[$i];
                                    
                                    $courierProduct = new RdvProduct();
                                    $courierProduct->rdv_idrdv = $rdv->idrdv;
                                    $courierProduct->rdv_type_id = $rdvName[$i];
                                    $courierProduct->rdv_product_id = $courierType->id;
                                    $courierProduct->qty = $quantity[$i];
                                    $courierProduct->fee =  $amount[$i];  
                                   //dd($request->amount[$i]);
                                   
                                    $courierProduct->save();
                                }
                                
                                $rdv->montant=$totalDepotAmount + $totalRecupAmount;
                                $rdv->save();
                                 
                                $date_paiement = date('Y-m-d');
                                
                                $courierPayment = new RdvPayment();
                                $courierPayment->rdv_id = $rdv->idrdv;
                                $courierPayment->rdv_senderid = $sende_id;
                                $courierPayment->amount = $totalDepotAmount;
                                $courierPayment->date=$date_paiement;
                                $courierPayment->recup_amount =$totalRecupAmount;
                                $courierPayment->refrdv=getTrx();
                                if($totalDepotAmount == 0){
                                    $courierPayment->status =2;  
                                }else{  $courierPayment->status =0; }
                               
                                $courierPayment->save();
                
                      }
                   //FIN INITIALISATION SELON LES DONNEES REÇUES
                   
                   
                $mission = Mission::where('idmission',$rdv->mission_id)->first();
                $date_mission = date('Y-m-d h:i:s', strtotime($mission->date));
                //SUPPRIMER ELEMENT RDV POUR METTRE A JOUR 
                $delete_product =RdvProduct::where('rdv_idrdv',$rdv->idrdv)->delete();
                // depuis application mobile redeclaration de nouvelles variables
                            $lines = $request->input('formData1.lines');  // Récupérer le tableau 'lines' à partir de formData1
                            $courierName = array_column($lines, 'courierName');
                            $rdvName = array_column($lines, 'rdvName');
                            $amount = array_column($lines, 'amount');
                            $quantity =array_column($lines, 'quantity');
                //fin declaration
                            $totalDepotAmount = 0;
                            $totalRecupAmount = 0 ;
                            $totalServiceAmount = 0 ; //total montant service recup comme depot
                    for ($i = 0; $i < count($courierName); $i++)
                      {
                             $courierType = Type::where('id', $courierName[$i])->where('status', 1)->firstOrFail();
                            if ($rdvName[$i] == 2) {
                                $totalDepotAmount += $amount[$i]; 
                                   
                            } else {
                                $totalRecupAmount += $amount[$i];
                            }
                            
                            $totalServiceAmount += $amount[$i];
                            
                            // MISE A JOUR DES ELEMENTS DU RDV 
                            $rdvProduct = new RdvProduct();
                            $rdvProduct->rdv_idrdv = $rdv->idrdv;
                            if ($rdvName[$i] == 2){
                                $rdvProduct->description='3';
                            }
                            $rdvProduct->rdv_type_id = $rdvName[$i];
                            $rdvProduct->rdv_product_id = $courierType->id;
                            $rdvProduct->qty = $quantity[$i];
                            $rdvProduct->fee =  $amount[$i];
                            $rdvProduct->created_at = $date_mission;
                            $rdvProduct->save();
                        }
             // MISE A JOUR MONTANT RDV 
             $montant=$totalDepotAmount + $totalRecupAmount;
    
             $rdv_update=Rdv::where('idrdv',$rdv->idrdv)->update(array('sender_idsender' => $sende_id,'montant'=>$montant));
             $rdv_update_paiement=RdvPayment::where('rdv_id',$rdv->idrdv)->update(array('rdv_senderid' => $sende_id,'amount'=>$totalDepotAmount,'recup_amount'=>$totalRecupAmount));
           //  Log::info('Display this data', ['anyData' => $totalRecupAmount]);
             //                   dd($request);

              if($request->input('formData3.receiver_phone') == null && $totalRecupAmount > 0){
                   return response()->json(['message' => 'Ajouter téléphone Destinataire', 'status' => 'error'], 400);
                }else{
                $receiver_user = Client::where('contact', $request->input('formData3.receiver_phone'))->first();
                if (!isset($receiver_user)) {
                    $receiver = new Client();
                    $receiver->nom = strtoupper($request->input('formData3.receiver_name'));
                    $receiver->contact = $request->input('formData3.receiver_phone');
                   // $receiver->email = $request->receiver_email;
                   // $receiver->adresse = $request->receiver_adresse;
                    $receiver->save();
                    $receive_id = $receiver->id;
                } else {
                    $receive_id = $receiver_user->id;
                }

                $chauffeurId = $request->input('userID.id'); 
                $compteur = CompteurRdvChauffeur::firstOrCreate(
                            ['chauffeur_id' => $chauffeurId],
                            ['rdv_counter' => 0]  // Valeurs par défaut pour la création
                            );
                if($compteur){
                    $lastCounter = $compteur->rdv_counter;
                }else{
                    $lastCounter = 0;
                }
                
                $newCounter = $lastCounter + 1;  // Incrémenter le compteur
                
                // Formatez le compteur pour avoir 4 chiffres, en ajoutant des zéros devant si nécessaire
                $formattedCounter = str_pad($newCounter, 4, '0', STR_PAD_LEFT);  // Cela convertit 1 en 0001
                
                // Récupérez les initiales du chauffeur
               // $initials = "JD";  // à récupérer depuis le formulaire ou la base de données, en fonction de votre modèle
               // $initials = strtoupper($request->input('userID.firstname[0]') . $request->input('userID.lastname[0]'));
                $firstname = $request->input('userID.firstname');
                $lastname = $request->input('userID.lastname');
                
                if ($firstname && $lastname) {
                    $initials = strtoupper($firstname[0] . $lastname[0]);
                } else {
                    // Gérer le cas où les noms sont vides ou null
                }
                // Utilisez un caractère aléatoire pour ajouter une touche d'unicité
                $uniqueId = uniqid();
                $letter = strtoupper(substr($uniqueId, -1));  // par exemple, "A"
                if($request->input('formData4.reference') != ''){
                    $Reference = $request->input('formData4.reference');
                }else{
                // Assemblez le tout pour créer une nouvelle référence
                $Reference = $formattedCounter . $initials . $letter;  // résultat : 0001JDA
                }
               
                // Log::info('Display this data', ['anyData' => $Reference]);
                // dd($request);
                // Sauvegardez la nouvelle référence et mettez à jour le compteur de rendez-vous pour ce chauffeur
                // (Mettez à jour vos modèles et noms de tables en fonction de votre base de données)
                //Rendezvous::create(['reference' => $newReference]);
                
                $compteur->rdv_counter = $newCounter;
                $compteur->save();
            // ENREGISTRER TRANSACTION 

             // Créez une nouvelle instance de Transaction
                $transaction = new Transaction();

                // Attribuez les valeurs individuellement
                $transaction->code = getTrx();
                $transaction->trans_id = $this->generateUniqueInvoiceId();
                $transaction->rdv_id = $rdv->idrdv;
                if($request->input('formData4.reference') && $totalRecupAmount > 0)
                {
                $transaction->reftrans = $Reference;
                }
                $transaction->branch_id = $user->branch_id;
                $transaction->user_id =  $user->id;
                $transaction->sender_id = $request->input('formData4.sender_id');
                if(isset($receive_id) && $receive_id != null){
                $transaction->receiver_id = $receive_id;
                $transaction->receiver_branch_id = $request->branch; 
                }
                if ($request->message != null) 
                {
                $transaction->Observation = $request->input('formData4.');
                }
                $transaction->status = 0;
                $transaction->type_envoi = 1;
                if($request->input('formData4.reference'))
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
                    $adresse= new RdvAdresse();
                    $adresse->client_id =$receive_id;
                    $adresse->rdv_id =$Reference;
                    $adresse->adresse =$request->input('formData3.receiver_address');
                   // $adresse->code_postal=$request->sender_code_postal;
                    $adresse->save();

                    // ENREGISTRER LISTE PRODUIT A ENVOYER
                
                // depuis application mobile redeclaration de nouvelles variables
                $lines = $request->input('formData1.lines');  // Récupérer le tableau 'lines' à partir de formData1
                $courierName = array_column($lines, 'courierName');
                $rdvName = array_column($lines, 'rdvName');
                $amount = array_column($lines, 'amount');
                $quantity =array_column($lines, 'quantity');
                //fin declaration

                for ($i = 0; $i < count($courierName); $i++) {
                    $courierType = Type::where('id', $courierName[$i])->where('status', 1)->firstOrFail();
                
                        
                        $courierProduct = new TransactionProduct();
                        $courierProduct->transaction_id = $courier->id;
                        $courierProduct->transaction_type_id = $courierType->id;
                        $courierProduct->type_cat_id = $courierType->cat_id;
                        $courierProduct->qty = $quantity[$i];
                        $courierProduct->fee = $amount[$i];
                        $courierProduct->save();
              
                    
                }


            // VERIFIER SI MONTANT RECUP EST SUPERIEUR A ZERO ET DESTINATAIRE EXISTE ALORS ENREGISTRER TRANSFERT 
            // if($totalRecupAmount > 0 )
            // {
            //     if($request->input('formData3.receiver_phone') == null){
            //        return response()->json(['message' => 'Ajouter téléphone Destinataire', 'status' => 'error'], 400);
            //     }else{
            //     $receiver_user = Client::where('contact', $request->input('formData3.receiver_phone'))->first();
            //     if (!isset($receiver_user)) {
            //         $receiver = new Client();
            //         $receiver->nom = strtoupper($request->input('formData3.receiver_name'));
            //         $receiver->contact = $request->input('formData3.receiver_phone');
            //        // $receiver->email = $request->receiver_email;
            //        // $receiver->adresse = $request->receiver_adresse;
            //         $receiver->save();
            //         $receive_id = $receiver->id;
            //     } else {
            //         $receive_id = $receiver_user->id;
            //     }
                
            //     // Récupérez les initiales de l'utilisateur (chauffeur)
            //     // Récupérez l'ID du chauffeur depuis le formulaire ou une autre source
            //     $chauffeurId = $request->input('userID.id'); 
            //     // exemple
            //   //  $chauffeurId = 33;
                
            //     // Récupérez le compteur de rendez-vous pour ce chauffeur spécifique
            //     $compteur = CompteurRdvChauffeur::firstOrCreate(
            //                 ['chauffeur_id' => $chauffeurId],
            //                 ['rdv_counter' => 0]  // Valeurs par défaut pour la création
            //                 );
            //     if($compteur){
            //         $lastCounter = $compteur->rdv_counter;
            //     }else{
            //         $lastCounter = 0;
            //     }
                
            //     $newCounter = $lastCounter + 1;  // Incrémenter le compteur
                
            //     // Formatez le compteur pour avoir 4 chiffres, en ajoutant des zéros devant si nécessaire
            //     $formattedCounter = str_pad($newCounter, 4, '0', STR_PAD_LEFT);  // Cela convertit 1 en 0001
                
            //     // Récupérez les initiales du chauffeur
            //    // $initials = "JD";  // à récupérer depuis le formulaire ou la base de données, en fonction de votre modèle
            //    // $initials = strtoupper($request->input('userID.firstname[0]') . $request->input('userID.lastname[0]'));
            //     $firstname = $request->input('userID.firstname');
            //     $lastname = $request->input('userID.lastname');
                
            //     if ($firstname && $lastname) {
            //         $initials = strtoupper($firstname[0] . $lastname[0]);
            //     } else {
            //         // Gérer le cas où les noms sont vides ou null
            //     }
            //     // Utilisez un caractère aléatoire pour ajouter une touche d'unicité
            //     $uniqueId = uniqid();
            //     $letter = strtoupper(substr($uniqueId, -1));  // par exemple, "A"
            //     if($request->input('formData4.reference') != ''){
            //         $Reference = $request->input('formData4.reference');
            //     }else{
            //     // Assemblez le tout pour créer une nouvelle référence
            //     $Reference = $formattedCounter . $initials . $letter;  // résultat : 0001JDA
            //     }
               
            //     // Log::info('Display this data', ['anyData' => $Reference]);
            //     // dd($request);
            //     // Sauvegardez la nouvelle référence et mettez à jour le compteur de rendez-vous pour ce chauffeur
            //     // (Mettez à jour vos modèles et noms de tables en fonction de votre base de données)
            //     //Rendezvous::create(['reference' => $newReference]);
                
            //     $compteur->rdv_counter = $newCounter;
            //     $compteur->save();
               
                
            //     $courier = new transaction();
            //     $courier->code = getTrx();
            //     $courier->reference_souche = $Reference;
            //     $courier->sender_branch_id = $user->branch_id;
            //     $courier->sender_staff_id = $user->id;
            //     // controler sender_id si il existe sinon creer l expediteur
            //     if($request->input('formData4.sender_id')){
            //       $courier->sender_idsender = $request->input('formData4.sender_id');
            //     }else{
            //         $courier->sender_idsender = $sende_id;
            //     }
            //     $courier->receiver_idreceiver = $receive_id;
            //     $courier->type_envoi='1';//1 maritime 2 Aerien
            //     $courier->receiver_branch_id = '2';
            //     if($request->input('formData4.refrdv')){
            //        $courier->facture_idfacture = $request->input('formData4.refrdv');
            //     }else{
            //        $courier->facture_idfacture = $rdv->code;
            //     }
            //     $courier->receiver_satff_id =$rdv->idrdv;
            //     $courier->status = 0;
            //    // if ($request->message != null) {
            //   //        $courier->note = $request->message;
            // //    }
            //    $courier->save();

            //     //ENREGISTRER ACTIVITE
            //     if($courier){
            //         activity('Nouveau transaction')
            //         ->performedOn($courier)
            //         ->causedBy($user)
            //         ->withProperties(['customProperty' => 'customValue'])
            //         ->log('transaction '.$Reference.' créé par ' . $user->username);
            //     }
            //     $id = $courier->id;
            //     //ENREGISTRER ADRESSE
            //         $adresse= new RdvAdresse();
            //         $adresse->client_id =$receive_id;
            //         $adresse->rdv_id =$Reference;
            //         $adresse->adresse =$request->input('formData3.receiver_address');
            //        // $adresse->code_postal=$request->sender_code_postal;
            //         $adresse->save();
            //     // ENREGISTRER LISTE PRODUIT A ENVOYER
                
            //     // depuis application mobile redeclaration de nouvelles variables
            //     $lines = $request->input('formData1.lines');  // Récupérer le tableau 'lines' à partir de formData1
            //     $courierName = array_column($lines, 'courierName');
            //     $rdvName = array_column($lines, 'rdvName');
            //     $amount = array_column($lines, 'amount');
            //     $quantity =array_column($lines, 'quantity');
            //     //fin declaration

            //     for ($i = 0; $i < count($courierName); $i++) {
            //         $courierType = Type::where('id', $courierName[$i])->where('status', 1)->firstOrFail();
            //        // if ($rdvName[$i] != 2) { prend en compte tous les produits depot comme recup
            //             // $totalRecupAmount += $request->amount[$i];
                        
            //             $courierProduct = new TransactionProduct();
            //             $courierProduct->transaction_id = $courier->id;
            //             $courierProduct->transaction_type_id = $courierType->id;
            //             $courierProduct->type_cat_id = $courierType->cat_id;
            //             $courierProduct->qty = $quantity[$i];
            //             $courierProduct->fee = $amount[$i];
            //             $courierProduct->save();
            //        // }
                    
            //     }

            //     $courierPayment = new TransfertPayment();
            //     $courierPayment->transfert_id = $courier->id;
            //     $courierPayment->branch_id = $user->branch_id;
            //     $courierPayment->date = $date_paiement;
            //     if($request->input('formData4.sender_id')){
            //         $courierPayment->transfert_senderid = $request->input('formData4.sender_id');
            //     }else{
            //         $courierPayment->transfert_senderid = $sende_id;
            //     }
            //     //$courierPayment->transfert_senderid = $request->sender_id;
            //     $courierPayment->transfert_receiverid = $receive_id;
            //     $courierPayment->sender_amount = $totalServiceAmount;
            //     $courierPayment->receiver_amount = $totalServiceAmount * 656;
            //     $courierPayment->reftransfert = getTrx();
            //     $courierPayment->status = 0;
            //     $courierPayment->save();

            //     $q = DB::table('transfert_product')->where('transfert_id', $courier->id)->where('type_cat_id',1)->sum('qty');
            //     if ($q == 1) {
            //         $transfertRef = new TransfertRef();
            //         $transfertRef->transfert_id = $courier->id;
            //         $transfertRef->ref_souche_part = $Reference;
            //         $transfertRef->status = 0;
            //         $transfertRef->save();
            //     } else {
            //         for ($i = 0; $i < $q; $i++) {
            //             $refsouche = $i + 1;
            //             $transfertRef = new TransfertRef();
            //             $transfertRef->transfert_id = $courier->id;
            //             $transfertRef->ref_souche_part = $Reference . '-' . $refsouche.'/'.$q;
            //             $transfertRef->status = 0;
            //             $transfertRef->save();
            //         }
            //     }

            //     $adminNotification = new AdminNotification();
            //     $adminNotification->user_id = $user->id;
            //     $adminNotification->title = 'Nouveau Colis Enregistré ' . $user->username;
            //     $adminNotification->click_url = urlPath('admin.courier.info.details', $id);
            //     $adminNotification->save();
            //  }
            // }
            //enregistrement unique de paiement
            if($request->input('formData2.montant_payer') > 0){
                 $user = User::where('id',$request->input('userID.id'))->first();
               // $user = User::where('id',33)->first();
                $rdv = Rdv::where('code', $refrdv)->first();
                $payment = RdvPayment::where('rdv_id', $rdv->idrdv)->first();
                
              //  $rdv = Rdv::where('code', $request->refrdv)->first();
             //$payment = RdvPayment::where('rdv_id', $rdv->idrdv)->first();

                $reste_payer = $totalServiceAmount - $request->input('formData2.montant_payer');
                  
                $payer = new Paiement();
                $payer->user_id = $user->id;
                $payer->branch_id = $user->branch_id;
                $payer->rdv_id = $rdv->idrdv;  
                $payer->sender_payer = $request->input('formData2.montant_payer');
                $payer->receiver_payer = $request->input('formData2.montant_payer') * 656;
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
                $branchtransaction->amount = $request->input('formData2.montant_payer');
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
            if ($totalDepotAmount > 0) {
                $user = User::where('id',$request->input('userID.id'))->first();
               // $user = User::where('id',33)->first();
                $rdv = Rdv::where('code', $refrdv)->first();
                $payment = RdvPayment::where('rdv_id', $rdv->idrdv)->first();
                
                $payer_rdv = 0;// montant payer pour un rdv depot uniquement 
                /*
                $payer = new Paiement();
                $payer->user_id = $user->id;
                $payer->branch_id = $user->branch_id;
                $payer->rdv_id = $rdv->idrdv;
                $payer->date_paiement = $date_paiement;
                $payer->refpaiement = getTrx();
                $status_payer ="";
                if ($request->input('formData2.montant_payer') > $totalDepotAmount) {
                    $payer->sender_payer = $totalDepotAmount;
                    $payer->status = '2';
                    $status_payer ='2';
                    $payer_rdv= $totalDepotAmount;
                } elseif($request->input('formData2.montant_payer') == $totalDepotAmount) {
                    $payer->sender_payer = $request->input('formData2.montant_payer');
                    $payer->status = '2';
                    $status_payer ='2';
                    $payer_rdv=$totalDepotAmount;
                }else{
                    $payer->sender_payer = $request->input('formData2.montant_payer');
                    $payer->status = '1';
                    $status_payer ='1';
                    $payer_rdv = $request->input('formData2.montant_payer');
                }
                $payer->mode_paiement = $request->input('formData2.mode');
                $payer->save();
                */
                if ($request->input('formData2.montant_payer') > $totalDepotAmount) {
                    $status = '2';
               }else{
                    $status = '1';
                }
                $update = RdvPayment::where('rdv_id', $rdv->idrdv)->update(array('amount'=> $totalDepotAmount,'status' => $status));
               
              
                //$payment->chauffeur_id=
                //mis a 1 pour exemple a remplacer
                $payment->status = $payer->status; 
                $payment->save();
                
               //ENVOI SMS POU PAIMENT FRAIS DE TRANSFERT 
                    $message='REFDEPOT:'.$payer->refpaiement.' - M.PAYÉ: '.$payer_rdv.'€ - RESTE: '.($totalDepotAmount - $payer_rdv).'€ - CHALLENGE TRANSIT vous remercie';
                    $recipient="0033".substr($request->input('formData4.sender_phone'),-9);
                    $idmission=$rdv->mission_id;
                    $rdv_id=$user->id;
                    $controller= new SmsController;
                    $controller->sendSms($recipient,$message,$idmission,$rdv_id);
                    //FIN ENVOI SMS
                    
              /*
                $branchtransaction = new BranchTransaction();
                $branchtransaction->branch_id = $user->branch_id;
                $branchtransaction->type = 'credit';
                if ($request->montant_payer > $totalDepotAmount) {
                $branchtransaction->amount = $totalDepotAmount;
                }elseif($request->montant_payer == $totalDepotAmount){
                    $branchtransaction->amount = $request->input('formData2.montant_payer');
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
                $adminNotification->user_id = $sende_id;
                $adminNotification->title = 'Paiement Frais RDV ';
                $adminNotification->click_url = urlPath('staff.rdv.details', $payment->rdv_id);
                $adminNotification->save();

                $montantRdvPayer =  $payer->sender_payer;
            }
            $montantTransfertPayer=0;
            if ($totalRecupAmount > 0) {
                $reste_payer = $request->input('formData2.montant_payer') - $montantRdvPayer;
                if ($reste_payer > 0) {
                  $status_payer = $reste_payer - $totalRecupAmount;
                 $montantTransfertPayer=$reste_payer;
                 /*
                    $payer = new Paiement();
                    $payer->user_id = $user->id;
                    $payer->branch_id = $user->branch_id;
                    $payer->sender_branch_id = $user->branch_id;
                    $payer->transfert_id = $courierPayment->id;
                    $payer->refpaiement = getTrx();
                    $payer->sender_payer = $reste_payer;
                    $payer->receiver_payer = $reste_payer * 656;
                    $payer->mode_paiement = $request->input('formData2.mode');
                    $payer->date_paiement = $date_paiement;
                    if ($status_payer == 0) {
                        $payer->status = '2';
                    } else 
                    {
                        $payer->status = '1';
                    }
                    $payer->save();
                    
                    */
                    
                    //ENVOI SMS POU PAIMENT FRAIS DE TRANSFERT 
                    $message='REFENVOI: '.$Reference.'- M.PAYÉ: '.$reste_payer.'€ - RESTE: '.($totalRecupAmount - $reste_payer).'€ - CHALLENGE TRANSIT vous remercie';
                    $recipient="0033".substr($request->input('formData4.sender_phone'),-9);
                    $idmission=$rdv->mission_id;
                    $rdv_id=$user->id;
                    $controller= new SmsController;
                    $controller->sendSms($recipient,$message,$idmission,$rdv_id);
                    //FIN ENVOI SMS

                    $adminNotification = new AdminNotification();
                    $adminNotification->user_id = $user->id;
                    $adminNotification->title = 'Paiement Frais Chauffeur ' . $user->username;
                    $adminNotification->click_url = urlPath('admin.courier.info.details', $id);
                    $adminNotification->save();

                    $branchtransaction = new BranchTransaction();
                    $branchtransaction->branch_id = $user->branch_id;
                    $branchtransaction->type = 'credit';
                    $branchtransaction->amount = $reste_payer;
                    $branchtransaction->reff_no = getTrx();
                    $branchtransaction->operation_date= $date_paiement;
                    $branchtransaction->created_by = $user->id;
                    if($request->input('formData4.refrdv')){
                        $branchtransaction->transaction_id = $request->input('formData4.refrdv');
                    }else{
                        $branchtransaction->transaction_id = $refrdv;
                    }
                   // $branchtransaction->transaction_id = $request->refrdv;
                    $branchtransaction->type_transaction ='1';
                    $branchtransaction->transaction_payment_id = $payer->id;
                    $branchtransaction->save();
                }
            }
            $totalEncaisse=$montantRdvPayer + $montantTransfertPayer;
            
            $rdv_update = Rdv::where('code', $refrdv)->update(array('status' => '3','encaisse' =>$totalEncaisse));
           // Log::info('Display this data', ['anyData' => $rdv_update]);
             //   dd($request);
            DB::commit();
            $rdv=Rdv::with('client','rdvDetail','adresse','transfert','transfert.receiver','depot','paymentInfo')->where('code',$refrdv)->where('status','>=','2')->orderBy('order_list','ASC')->first();

           // $rdv=Rdv::where('code',$refrdv)->first();
            
            
            return response()->json(['rdv' => $rdv], 200);

          //  $notify[] = ['success', 'Transfert enregistré avec succès'];
         // return redirect()->route('staff.mission.detailmission', encrypt($rdv->mission_id))->withNotify($notify);

        } catch (Exception $e) {

            DB::rollback();
        }
        
        
        
    }
    
    public function detailstransfert($id){
        
        $courierInfo = Transfert::where('id', decrypt($id))->with('paiement.agent', 'paiement.modepayer')->first();
        $courierProductInfos = TransfertProduct::where('transfert_id', $courierInfo->id)->with('type')->get();
        $courierProductRef = TransfertRef::where('transfert_id', $courierInfo->id)->get();
        $courierPayment = TransfertPayment::where('transfert_id', $courierInfo->id)->first();
        $deja_payer_sender=Paiement::where('transfert_id',decrypt($id))->where('branch_id',1)->sum('sender_payer');
        $deja_payer_receiver=Paiement::where('transfert_id',decrypt($id))->where('sender_branch_id',1)->sum('receiver_payer');
        $conteneur=ContainerNbcolis::where('id_colis',decrypt($id))->with('conteneur')->get();
        $programme=Rdv::where('idrdv',$courierInfo->receiver_satff_id)->with('senderStaff','mission','mission.chauffeur','mission.staff')->first();
    }
    /// VERIFIER SI LE NUMERO EXISTE ET QU IL EST BON ENVOYER UN CODE SMS POUR AUTHENTIFICATION
    public function verifyphone(Request $request)
    {
       // dd($request);
        $phone = $request->input('phoneNumber');

        // Vérifier si l'utilisateur existe
        $user = User::where('mobile', $phone)->where('status',1)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found','code' => 404], 404);
        }
         $smsCode = rand(1000, 9999);
         $message= 'Votre code de vérification est: ' . $smsCode;
         $recipient = "0033".substr($phone,-9);
         $rdv_id =$user->id;
         $idmission = $smsCode;
         
         $user->ver_code = $smsCode;
         $user->save();
         
         $controller= new SmsController;
        //controller->sendSms($recipient,$message,$idmission,$rdv_id);
        return response()->json(['message' => 'Verification code sent via SMS', 'code' => 200], 200);
    }
    
    

         
    
    
    
}