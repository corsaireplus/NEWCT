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
use App\Models\Rdv;
use App\Models\RdvPayment;
use App\Models\RdvProduct;
use App\Models\User;
use App\Models\Paiement;
use App\Models\Mission;
use App\Models\BranchTransaction;
use DataTables;
use App\Models\Client;
use App\Models\RdvAdresse;
use App\Models\Transfert;
use App\Models\ClientAdresse;



class RdvController extends Controller
{

    public function index(){
        $pageTitle = "Liste RDV";
        $rdv=Rdv::where('status',0)->orderBy('date', 'ASC')->with('client','client.adresse','chauffeur','adresse')->paginate(getPaginate());
        $listerdv=Rdv::all();
        $emptyMessage = "No data found";
        

       //dd($rdv);
        // $datatable = Datatables::of($rdv)
        //         ->addColumn(
           // dd($rdv);
        return view('staff.rdv.index',compact('pageTitle','rdv','emptyMessage','listerdv'));
    }
    public function rdvclient(){
        $pageTitle = "Demandes de Rendez-vous en ligne";
        $rdv=Rdv::where('status',10)->where('user_id',911)->orderBy('date', 'ASC')->with('client','client.adresse','chauffeur','adresse')->paginate(getPaginate());
        $listerdv=Rdv::all();
        $emptyMessage = "Aucune demande en cours";
        

       //dd($rdv);
        // $datatable = Datatables::of($rdv)
        //         ->addColumn(
           // dd($rdv);
        return view('staff.rdv.rdvclient',compact('pageTitle','rdv','emptyMessage','listerdv'));
    }
    public function create()
    {
        $pageTitle = "Creer RDV";
        $branchs = Branch::where('status', 1)->latest()->get();
        $types = Type::where('status', 1)->with('unit')->latest()->get();
        $chauffeur =User::where('user_type','staff')->get();
        return view('staff.rdv.create', compact('pageTitle', 'branchs', 'types','chauffeur'));
    }

    //CREATION RDV 
    public function store(Request $request)
    {
       // dd($request);
        $request->validate([
          
            'sender_name' => 'required|max:40',
           // 'sender_email' => 'required|email|max:40',
            'sender_phone' => 'required|string|max:40',
            'sender_address' => 'required|max:255',
            'sender_code_postal' =>'required|max:255',
            'date'=>'required',
            'rdvName.*' => 'required_with:quantity|exists:types,id',
            'courierName.*' => 'required_with:quantity|exists:types,id',
            'quantity.*' => 'required_with:courierName|integer|gt:0',
            // 'amount' => 'required|array',
            // 'amount.*' => 'numeric|gt:0',
        ]);
        //dd($request);
       
 try {
            DB::beginTransaction();

             $admin = Auth::user();
             $sender_user=Client::where('contact',$request->sender_phone)->first();
                        // dd($sender_user);
                        if( !isset($sender_user) ) // si l utilisateur n existe pas 
                        {
                            $sender = new Client();
                            $sender->nom=strtoupper($request->sender_name);
                            $sender->contact=$request->sender_phone;
                            $sender->country_id =$admin->branch_id;
                            $sender->save();
                            $sende_id= $sender->id;

                            // $adresse= new RdvAdresse();
                            // $adresse->client_id =$sende_id;
                            // $adresse->adresse =$request->sender_address;
                            // $adresse->code_postal=$request->sender_code_postal;
                            // $adresse->save();

                            $newAdresse = [
                                            'client_id' =>$sende_id,
                                            'adresse' => $request->sender_address,
                                            'code_postal' => $request->sender_code_postal,
                                            'observation' => '',
                                        ];

                            $clientAdresse = ClientAdresse::firstOrNew([
                                    'client_id' =>$sende_id,
                                    'adresse' => $request->sender_address,
                                    'code_postal' => $request->sender_code_postal,
                                ]);

                                if (!$clientAdresse->exists) {
                                    // L'adresse n'existe pas encore, vous pouvez l'ajouter
                                    $clientAdresse->fill($newAdresse);
                                    $clientAdresse->save();
                                }
                        }else{
                            // $nom = strtoupper($request->sender_name);
                            //  $insertOrUpdate=DB::UPDATE("UPDATE `clients` SET `nom`='$nom',`adresse`='$request->sender_address',`code_postal`='$request->sender_code_postal' WHERE 'contact' = '$request->sender_phone'");
                            $sende_id= $sender_user->id;
                            //$adresse=RdvAdresse::where('client_id',$sende_id)->update(array('adresse' =>$request->sender_address,'code_postal'=>$request->sender_code_postal));

                                $newAdresse = [
                                    'client_id' =>$sende_id,
                                    'adresse' => $request->sender_address,
                                    'code_postal' => $request->sender_code_postal,
                                    'observation' => '',
                                ];

                                $clientAdresse = ClientAdresse::firstOrNew([
                                    'client_id' => $sende_id,
                                    'adresse' => $request->sender_address,
                                    'code_postal' => $request->sender_code_postal,
                                    'observation' => '',
                                ]);

                                if (!$clientAdresse->exists) {
                                    // L'adresse n'existe pas encore, vous pouvez l'ajouter
                                    $clientAdresse->fill($newAdresse);
                                    $clientAdresse->save();
                                }

                        }

       
        $rdv= new Rdv();
        $rdv->sender_idsender=$sende_id;
        $rdv->status='0';
        $rdv->code = getTrx();
        $rdv->user_id=$admin->id;
        $rdv->date=$request->date;
        $rdv->observation=$request->observation;
        $rdv->save();
        $rdv_id = $rdv->idrdv;

        ////dd($rdv);


        $adresse= new RdvAdresse();
                            $adresse->client_id =$sende_id;
                            $adresse->rdv_id =$rdv_id;
                            $adresse->adresse =$request->sender_address;
                            $adresse->code_postal=$request->sender_code_postal;
                            $adresse->save();

       

        $totalDepotAmount = 0;
        $totalRecupAmount = 0 ;
        for ($i=0; $i <count($request->courierName); $i++) { 
            $courierType = Type::where('id',$request->courierName[$i])->where('status', 1)->firstOrFail();
            if($request->rdvName[$i] == 2 ){
                $totalDepotAmount +=  $request->amount[$i];
            }else{ 
                $totalRecupAmount +=  $request->amount[$i];
            }
           
            $courierProduct = new RdvProduct();
            $courierProduct->rdv_idrdv = $rdv->idrdv;
            $courierProduct->rdv_type_id = $request->rdvName[$i];
            $courierProduct->rdv_product_id = $courierType->id;
            $courierProduct->qty = $request->quantity[$i];
            $courierProduct->fee =  $request->amount[$i];  
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

        


        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $admin->id;
        $adminNotification->title = 'Nouveau Rdv '.$admin->username;
        $adminNotification->click_url = urlPath('staff.rdv.details',$rdv->idrdv);
        $adminNotification->save();
        DB::commit();

        $notify[]=['success','Rdv Créé avec succès'];

    } catch (Exception $e) {
        DB::rollback();
    }

    return redirect()->route('staff.rdv.list', encrypt($rdv->idrdv))->withNotify($notify);

       // dd($request);
      
    }

    public function update(Request $request){
           //dd($request);
        $request->validate([
          
            'sender_name' => 'max:40',
            //'sender_email' => 'required|email|max:40',
            'sender_phone' => 'required|string|max:40',
            'sender_address' => 'required|max:255', 
            'date'=>'required',
            'rdvName.*' => 'required_with:quantity|exists:types,id',
            'courierName.*' => 'required_with:quantity|exists:types,id',
            'quantity.*' => 'required_with:courierName|integer|gt:0',
            // 'amount' => 'required|array',
            // 'amount.*' => 'numeric|gt:0',
        ]);

        try{

        DB::beginTransaction();

        
         $admin = Auth::user();
         $sender_user=Client::where('contact',$request->sender_phone)->first();
      // dd($sender_user);
            $sende_id = null;
            if( empty($sender_user->contact) )
            {
                $sender = new Client();
                $sender->nom=$request->sender_name;
                $sender->contact=$request->sender_phone;
                $sender->country_id=$admin->branch_id;
                $sender->save();
                $sende_id= $sender->id;
            }else{
                $sende_id= $sender_user->id;
            }
             // dd($sende_id);
                $rdv = Rdv::where('code', $request->rdvcode)->first();
               // $adresse=RdvAdresse::where('client_id',$sende_id)->update(array('adresse' =>$request->sender_address,'code_postal'=>$request->sender_code_postal));
                $test_adresse = RdvAdresse::where('rdv_id',$rdv->idrdv)->first();
                if($test_adresse){
                 $adresse=RdvAdresse::where('rdv_id',$rdv->id)->update(array('adresse' =>$request->sender_address,'code_postal'=>$request->sender_code_postal));

                }else{
                            $adresse= new RdvAdresse();
                            $adresse->client_id =$sende_id;
                            $adresse->rdv_id =$rdv->idrdv;
                            $adresse->adresse =$request->sender_address;
                            $adresse->code_postal=$request->sender_code_postal;
                            $adresse->save();
                }
                $totalDepotAmount = 0;
                $totalRecupAmount = 0 ;
             //$rdvProducts=$rdv->rdvDetail;

             // dd($rdvProducts);
             $delete_product =RdvProduct::where('rdv_idrdv',$rdv->idrdv)->delete();
      for ($i=0; $i <count($request->courierName); $i++) { 
        $courierType = Type::where('id',$request->courierName[$i])->where('status', 1)->firstOrFail();
        if($request->rdvName[$i] == 2 ){
            $totalDepotAmount +=  $request->amount[$i];
        }else{ 
            $totalRecupAmount +=  $request->amount[$i];
        }
       
                $courierProduct = new RdvProduct();
                $courierProduct->rdv_idrdv = $rdv->idrdv;
                $courierProduct->rdv_type_id = $request->rdvName[$i];
                $courierProduct->rdv_product_id = $courierType->id;
                $courierProduct->qty = $request->quantity[$i];
                $courierProduct->fee =  $request->amount[$i];  
                //dd($request->amount[$i]);
            
                $courierProduct->save();
         }

        $montant=$totalDepotAmount + $totalRecupAmount;
        $rdv_update=Rdv::where('idrdv',$rdv->idrdv)->update(array('sender_idsender' => $sende_id,'montant'=>$montant,'date'=>$request->date,'observation'=>$request->observation,'user_id'=>$admin->id,'status'=>0));
        $rdv_update_paiement=RdvPayment::where('rdv_id',$rdv->idrdv)->update(array('rdv_senderid' => $sende_id,'amount'=>$totalDepotAmount,'recup_amount'=>$totalRecupAmount));

        
        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $admin->id;
        $adminNotification->title = 'Modification Rdv '.$admin->username;
        $adminNotification->click_url = urlPath('staff.rdv.details',$rdv->idrdv);
        $adminNotification->save();
        DB::commit();

        $notify[]=['success','Rdv Modifié avec succès'];
    } catch (Exception $e) {
        DB::rollback();
    }
        return redirect()->route('staff.rdv.list', encrypt($rdv->idrdv))->withNotify($notify);
    }


    public function details($id)
    {
       
        $pageTitle = "Rdv Details";
       // $courierInfo = Rdv::with('paiement','adresse')->findOrFail(decrypt($id));
        // $admin=Auth::where('id',$courierInfo->user_id)->first();
        $branchs = Branch::where('status', 1)->latest()->get();
        $types = Type::where('status', 1)->with('unit')->latest()->get();
        $chauffeur =User::where('user_type','staff')->get();
        $courierInfo = Rdv::with('adresse')->findOrFail(decrypt($id));
       // dd($courierInfo);
        return view('staff.rdv.edit',compact('pageTitle','courierInfo','chauffeur','types','branchs'));
      
       // return view('staff.rdv.details', compact('pageTitle','courierInfo'));
        
    }
    public function detail($id)
    {
       
        $pageTitle = "Rdv Details";
       // $courierInfo = Rdv::with('paiement','adresse')->findOrFail(decrypt($id));
        // $admin=Auth::where('id',$courierInfo->user_id)->first();
        $branchs = Branch::where('status', 1)->latest()->get();
        $types = Type::where('status', 1)->with('unit')->latest()->get();
        $chauffeur =User::where('user_type','staff')->get();
        $courierInfo = Rdv::with('adresse','mission.chauffeur')->findOrFail(decrypt($id));
       // dd($courierInfo);
        return view('staff.rdv.details',compact('pageTitle','courierInfo','chauffeur','types','branchs'));
      
       // return view('staff.rdv.details', compact('pageTitle','courierInfo'));
        
    }
    public function edit($id){
        // $pageTitle = "Modifier Rdv"; 
        // $branchs = Branch::where('status', 1)->latest()->get();
        // $types = Type::where('status', 1)->with('unit')->latest()->get();
        // $chauffeur =User::where('user_type','staff')->get();
        // $courierInfo = Rdv::findOrFail(decrypt($id));
        // return view('staff.rdv.edit',compact('pageTitle','courierInfo','chauffeur','types','branchs'));
        $admin = Auth::user();
        $rdv=Rdv::findOrFail(decrypt($id));
        $rdv->delete();
        $delete=RdvProduct::where('rdv_idrdv',decrypt($id))->delete();
        $rdv_update_paiement=RdvPayment::where('rdv_id',decrypt($id))->delete();
        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $admin->id;
        $adminNotification->title = 'Annulation Rdv '.$admin->username;
        $adminNotification->click_url = urlPath('staff.rdv.details',decrypt($id));
        $adminNotification->save();

        $notify[]=['success','Rdv Annulé avec succès'];
        return redirect()->route('staff.rdv.list')->withNotify($notify);
    }
    
    public function getRdv(Request $request){
        if ($request->ajax()) {
        $data=Rdv::where('status',0)->orderBy('date', 'ASC')->with('client')->with('chauffeur')->get();
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
    }
    public function rdvSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $pageTitle = "Recher RDV";
        $emptyMessage = "No Data Found";
        $user = Auth::user();
        $rdv = Rdv::where('user_id', $user->id)->with('client')->paginate(getPaginate());
        return view('staff.rdv.index', compact('pageTitle', 'emptyMessage', 'rdv', 'search'));
    }
        /***PAIEMENT POUR RDV *******/
    public function rdv_payment(Request $request){
       //dd($request);
        $rdvmontant=Rdv::where('code',$request->code)->first();
        $statuspayment=RdvPayment::where('rdv_id',$rdvmontant->idrdv)->first();

        if($rdvmontant->montant > $request->montant_payer){
            $notify[]=['error','Erreur Montant'];
            
        }elseif($statuspayment->status == 2 ){
            $notify[]=['error','Paiement dejà enregistré'];
        }elseif($statuspayment->amount == $request->montant_payer){ 
            DB::beginTransaction();
            try{
                $user = Auth::user();
               
                $payment=RdvPayment::where('rdv_id',$rdvmontant->idrdv)->first();

            
                $payer=new Paiement();
                $payer->user_id=$user->id;
                $payer->branch_id=$user->branch_id;
                $payer->rdv_id=$payment->rdv_id;
                $payer->refpaiement=getTrx();
                $payer->sender_payer=$request->montant_payer;
                $payer->mode_paiement=$request->mode;
                if($request->montant_payer = $payment->amount)
                {$payer->status='2';}
                elseif($request->montant_payer < $rdvmontant->montant){
                    $payer->status='1';
                }
                $payer->save();

                //$payment->chauffeur_id=
                $payment->status= $payer->status;
                $payment->save();

                $branchtransaction= new BranchTransaction();
                $branchtransaction->branch_id=$user->branch_id;
                $branchtransaction->type='credit';
                $branchtransaction->amount=$request->montant_payer;
                $branchtransaction->reff_no=getTrx();
                $branchtransaction->created_by=$user->id;
                $branchtransaction->transaction_id=$payment->refrdv;
                $branchtransaction->transaction_payment_id=$payer->id;
                $branchtransaction->save();


                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $rdvmontant->sender_idsender;
                $adminNotification->title = 'Paiement Frais RDV '.$rdvmontant->client->nom;
                $adminNotification->click_url = urlPath('staff.rdv.details',$payment->rdv_id);
                $adminNotification->save();
                DB::commit();
           // }
                $notify[]=['success','Paiement validé '];
            }catch (Exception $e) {
                
                DB::rollback();
            }
           

            
        }
        return back()->withNotify($notify);
    }
    public function rdv_validate($idmission){
       //dd($idmission);
        $rdv_update=Rdv::where('code',decrypt($idmission))->update(array('status' => '3'));
        $rdv=Rdv::where('code',decrypt($idmission))->get();
       // dd($rdv);
       // Page::where('id', $id)->update(array('image' => 'asdasd'));
        $notify[]=['success','RdV Terminé Merci'];
        return redirect()->route('staff.mission.detailmission', encrypt($rdv[0]->mission_id))->withNotify($notify);
    }
    public function rdv_missioncancel($idmission){
        //dd($idmission);
        $rdv_update=Rdv::where('idrdv',decrypt($idmission))->update(array('status' => '0','mission_id' =>'0','code'=>getTrx()));
        $rdv=Rdv::where('idrdv',decrypt($idmission))->get();
        // dd($rdv);
        // Page::where('id', $id)->update(array('image' => 'asdasd'));
         $notify[]=['success','RdV Annulé'];
         return back()->withNotify($notify);
     }
     function fetch(Request $request)
       {
        if($request->get('query'))
        {
         $query = $request->get('query');
        //  $data = DB::table('clients')
        //         ->join('client_adresses', 'clients.id', '=', 'client_adresses.client_id')
        //         ->where('nom', 'LIKE', "%{$query}%")
        //         ->orWhere('contact', 'LIKE', "%{$query}%")
        //         ->latest('client_adresses.created_at')  // Triez par ordre décroissant selon la date de création
        //         ->first();
        //     }
         $data = DB::table('clients')
           ->join('rdv_adresse','clients.id','=','rdv_adresse.client_id')
           ->where('nom', 'LIKE', "%{$query}%")
           ->orWhere('contact','LIKE',"%{$query}%")
            ->latest('rdv_adresse.created_at')  // Triez par ordre décroissant selon la date de création
           ->first();
        }
        //dd($data);
        return response()->json($data);
    }
    function fetchAdresse(Request $request)
       {
        if($request->get('query'))
        {
         $query = $request->get('query');
         $data = DB::table('client_adresses')
           ->join('clients','client_adresses.client_id','=','clients.id')
           ->where('adresse', 'LIKE', "%{$query}%")
           ->orWhere('code_postal','LIKE',"%{$query}%")
           ->first();
        }
        //dd($data);
        return response()->json($data);
    }
    function fetchreceiver(Request $request)
       {
        if($request->get('queryreciever'))
        {
         $query = $request->get('queryreciever');
         $data = DB::table('clients')
           ->join('rdv_adresse','clients.id','=','rdv_adresse.client_id')
           ->where('nom', 'LIKE', "%{$query}%")
           ->orWhere('contact','LIKE',"%{$query}%")
           ->first();
        }
        //dd($data);
        return response()->json($data);
    }
    public function delete_rdv(Request $request){
        $courierInfo = Rdv::where('idrdv',$request->refpaiement)->delete();
        $rdvPayment =  RdvPayment::where('rdv_id',$request->refpaiement)->delete();
        $notify[] = ['success', 'Rdv supprimé avec succès'];
        return back()->withNotify($notify);
    }

    function bilan_depot(Request $request){
        $pageTitle = "Bilan des depôt carton et barrique du jour";
        
       // DB::enableQueryLog();
        $total_colis=Transfert::with('transfertDetail');
        $courierInfo=Type::where('cat_id','2')->with('rdv_product.payments')->withSum(['rdv_product as qty' => function($query) {
            $query->whereDate('created_at', Carbon::today())->where('description','=','3');
        }],'qty')->paginate(getPaginate());
        // dd(DB::getQueryLog());

      
        return view('staff.rdv.bilan_depot', compact('pageTitle','courierInfo'));
    }

    function search_bilan_depot(Request $request){

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
            return redirect()->route('staff.customer.depot_bilan')->withNotify($notify);
        }
        if ($end && !preg_match($pattern,$end)) {
            $notify[] = ['error','Invalid date format'];
            return redirect()->route('staff.customer.depot_bilan')->withNotify($notify);
        }
        $pageTitle = "Recherche Bilan des depôt carton et barrique";
               // DB::enableQueryLog();

        $courierInfo=Type::where('cat_id','2')->with('rdv_product.payments')
                    ->withSum(['rdv_product as qty' => function($query) use ($start,$end) {
                         $query->where('description','=','3')
                         ->whereDate('created_at','>=',Carbon::parse($start))
                         ->whereDate('created_at','<=',Carbon::parse($end) );
                     }],'qty')->paginate(getPaginate());
                 // dd(DB::getQueryLog());

      
        return view('staff.rdv.bilan_depot', compact('pageTitle','courierInfo'));
    }

    public function notificationRead($id){
        $notification = AdminNotification::findOrFail($id);
        $notification->read_status = 1;
        $notification->save();
        return redirect($notification->click_url);
    }


    public function getClientAddresses($clientId)
        {
            $addresses = RdvAdresse::where('client_id', $clientId)
                                    ->select('adresse', 'code_postal')
                                    ->get();
            //->pluck('adresse');
            return response()->json($addresses);
        }



}