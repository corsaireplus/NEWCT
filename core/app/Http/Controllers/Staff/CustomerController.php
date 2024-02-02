<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;
use App\Models\Transfert;
use App\Models\RdvAdresse;
use App\Models\Prospect;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;
use App\Models\SmsEnvoi;

use App\Exports\CustomerExportMapping;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{


public function index(Request $request){

    $emptyMessage ="";
    $pageTitle="Liste des Clients";
    $admin= Auth::user();
   // dd($admin->branch_id);
    $branch = $admin->branch_id;
  //  DB::enableQueryLog();
    //$clients=Client::with('transfert')->where('country_id',$admin->branch_id)->get();
    $clients =Client::withCount('transfert')->with('transfert')->where('country_id',$admin->branch_id)->paginate(getPaginate());
//dd($clients);
//     $clients = Client::with('transfert')->where('country_id',$admin->branch_id)->get()->sortBy(function($client)
// {
//     return $client->transfert->count();
// });
//     // $clients=Client::with(['transfert'=>function($q) {
    //     $q->where('transferts.sender_idsender', '=', 'id');
    //    // $q->where('transferts.sender_branch_id', '=',$branch);
    // }]) ->orderBy('created_at','DESC')->paginate(getPaginate());
    //dd($clientss);
  // $clients=DB::SELECT("SELECT nom,contact,email,adresse,code_postal,clients.created_at FROM `clients`,`transferts` WHERE  clients.id=transferts.sender_idsender");
  //dd(DB::getQueryLog());
  //dd($clients);
    return view('staff.customer.index', compact('clients','pageTitle','emptyMessage'));

}

public function getClientData(Request $request){
    $admin= Auth::user();
    $posts = Client::where('country_id',$admin->branch_id)->with('transfert','client_adresse')->get();

   // dd($posts->client_adresse);

    return Datatables::of($posts) 
        ->addColumn('action', function ($post){
            if($post->transfert->count() > 0 && !empty($post->transfert)){
                return  '<a href="clients/factures/'.encrypt($post->id).'" title="" class="icon-btn bg--10 ml-1">Factures</a>
                        <a href="client/edit/'.encrypt($post->id).'" title="" class="icon-btn btn--priamry ml-1">Details</a>';
                    }else{
            return '<a href="client/edit/'.encrypt($post->id).'" title="" class="icon-btn btn--priamry ml-1">Details</a>';
                }
        })
        ->editColumn('nom', '{!! str_limit($nom, 60) !!}')
        //  ->editColumn('adresse', function($post){
        //      return $post->client_adresse->adresse? :"";
        //  })       
        //  ->editColumn('code', function($post){
        //       return $post->client_adresse ? :"";
        //   })
         ->editColumn('created_at', function ($post) {
            return $post->created_at ? with(new Carbon($post->created_at))->format('d/m/Y') : '';
        })
        ->make(true);
}

public function facture($id){
    $emptyMessage ="Aucune Facture";
    $client=Client::findOrFail(decrypt($id));
    $user = Auth::user();
    $transferts=Transfert::where('sender_idsender',decrypt($id))->orWhere('receiver_idreceiver')->with('sender', 'receiver', 'paymentInfo')->orderBy('id', 'DESC')->paginate(getPaginate());
    $pageTitle="Liste des Factures de ".$client->nom;
    return view('staff.customer.factures', compact('user','client','transferts','pageTitle','emptyMessage'));

}
public function edit_client($id){
    $pageTitle="Details client";
    $client=Client::with('client_adresse')->findOrFail(decrypt($id));

    return view('staff.customer.edit', compact('client','pageTitle'));
}
public function update(Request $request, $id)
{
    $id = decrypt($id);
    //dd($request);
    $request->validate([
        'nom' => 'required|max:191',
        'contact' => 'required|min:10|unique:clients,contact,'.$id,
        'email' => 'email|nullable|max:40|unique:clients,email,'.$id,
       
       
    ]);
    $client = Client::where('id', $id)->firstOrFail();
    $client->nom=strtoupper($request->nom);
    $client->contact=$request->contact;
    $client->email=$request->email;
    $client->save();

    $adresse=RdvAdresse::where('client_id',$id)->firstOrFail();
    $adresse->adresse=$request->adresse;
    $adresse->code_postal=$request->code;
    $adresse->save();

    $notify[] = ['success', 'Modifié avec succès'];
    return redirect()->route('staff.customer.list')->withNotify($notify);
}
public function clientSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $pageTitle = "Recherche Client";
        $emptyMessage = "Aucun Client";
        $user = Auth::user();
        $clients =Client::with('transfert')->where('contact','like', '%'.$search.'%')->paginate(getPaginate());
        return view('staff.customer.index', compact('clients','pageTitle','emptyMessage','search'));
    }
    public function listprospect(){
        $emptyMessage ="";
        $admin= Auth::user();
        $branch = $admin->branch_id;
        if($admin->branch_id == 1){
            $pageTitle="Liste des Prospects";
            }else{
             $pageTitle="Liste  Reclamations";
            }
        $admin= Auth::user();
      
        $branch = $admin->branch_id;
      
        if($admin->username =="bagate"){
            $clients=Prospect::with('client')->orderBy('id','DESC')->paginate(getPaginate());
    
           }else{
               if($branch == 1){
                $clients=Prospect::with('client')->where('agence_id',1)->orderBy('id','DESC')->paginate(getPaginate());
    
               }else{
                $clients=Prospect::with('client')->where('agence_id','!=',1)->orderBy('id','DESC')->paginate(getPaginate());
    
               }
    
           }
      
        return view('staff.customer.prosp', compact('clients','pageTitle','emptyMessage'));

    }

    public function createprospect(){
          $admin = Auth::user();
          if($admin->branch_id == 1){
            $pageTitle="Ajouter Prospect";
            }else{
             $pageTitle="Ajouter Reclamation";
            }
        return view('staff.customer.prospcreate', compact('pageTitle'));
    }

    public function prospectstore(Request $request){
       // dd($request);
        $request->validate([
            'contact'=>'required',
            'nom'=>'required'
        ]);

        try {
            $admin = Auth::user();
            $date = date('Y-m-d');
            $sender_user=Client::where('contact',$request->contact)->first();
            // dd($sender_user);
            if( !isset($sender_user) )
            {
             $sender = new Client();
             $sender->nom=strtoupper($request->nom);
             $sender->contact=$request->contact;
             $sender->country_id =$admin->branch_id;
             $sender->save();
             $sende_id= $sender->id;
     
             if($admin->branch_id == 1){
                $adresse= new RdvAdresse();
                $adresse->client_id =$sende_id;
                $adresse->adresse =$request->adresse;
                $adresse->code_postal=$request->code;
                $adresse->save();
             }
            }else{
               // $nom = strtoupper($request->sender_name);
              //  $insertOrUpdate=DB::UPDATE("UPDATE `clients` SET `nom`='$nom',`adresse`='$request->sender_address',`code_postal`='$request->sender_code_postal' WHERE 'contact' = '$request->sender_phone'");
                $sende_id= $sender_user->id;
                //$adresse=RdvAdresse::where('client_id',$sende_id)->update(array('adresse' =>$request->sender_address,'code_postal'=>$request->sender_code_postal));
     
            }
            $rdv= new Prospect();
            $rdv->customer_id=$sende_id;
            $rdv->status='0';
            $rdv->reference = getTrx();
            $rdv->user_id=$admin->id;
            $rdv->date=$date;
            $rdv->observation=$request->message;
            if($admin->branch_id == 2){
                $rdv->type_id=2;
                }else{
                  $rdv->type_id=$request->type;
                }
                $rdv->agence_id=$admin->branch_id;
            $rdv->save();

            $adminNotification = new AdminNotification();
            $adminNotification->user_id = $admin->id;
            $adminNotification->title = 'Nouveau Prospect '.$admin->username;
            $adminNotification->click_url = urlPath('staff.prospect.status',$rdv->idrdv);
            $adminNotification->save();
    
            $notify[]=['success','Prospection Créé avec succès'];
            return redirect()->route('staff.prospect.list', encrypt($rdv->idrdv))->withNotify($notify);

        }catch (Exception $e) {
        DB::rollback();
        }

       

    }
    public function editprospect($id){
        $admin = Auth::user();
        if($admin->branch_id == 1){
        $pageTitle="Details Prospection";
        }else{
         $pageTitle="Details Reclamation";
        }
        $prosp=Prospect::with('client','client.client_adresse')->findOrFail(decrypt($id));
   // dd($prosp);
        return view('staff.customer.prospedit', compact('prosp','pageTitle'));   
    }

    public function updateprospect(Request $request,$id){
        $id = decrypt($id);
        $admin = Auth::user();
        $date = date('Y-m-d');
        $request->validate([
            'nom' => 'required|max:191',
            'contact' => 'required|min:10'
           
        ]);
        $sender_user=Client::where('contact',$request->contact)->first();
        // dd($sender_user);
        if( !isset($sender_user) )
        {
         $sender = new Client();
         $sender->nom=strtoupper($request->nom);
         $sender->contact=$request->contact;
         $sender->country_id =$admin->branch_id;
         $sender->save();
         $sende_id= $sender->id;
 
         $adresse= new RdvAdresse();
         $adresse->client_id =$sende_id;
         $adresse->adresse =$request->adresse;
         $adresse->code_postal=$request->code;
         $adresse->save();
        }else{
           // $nom = strtoupper($request->sender_name);
          //  $insertOrUpdate=DB::UPDATE("UPDATE `clients` SET `nom`='$nom',`adresse`='$request->sender_address',`code_postal`='$request->sender_code_postal' WHERE 'contact' = '$request->sender_phone'");
            $sende_id= $sender_user->id;
            $client = Client::where('id', $sende_id)->firstOrFail();
            $client->nom=strtoupper($request->nom);
            $client->contact=$request->contact;
            $client->save();
        
        }
    
        $adresse=RdvAdresse::where('client_id',$sende_id)->firstOrFail();
        $adresse->adresse=$request->adresse;
        $adresse->code_postal=$request->code;
        $adresse->save();

        $prospect=Prospect::where('id',$id)->firstOrFail();
        $prospect->action=$request->action;
        $prospect->observation=$request->message;
        if($admin->branch_id == 2){
            $prospect->type_id=2;
            }else{
                $prospect->type_id=$request->type;
            }
        $prospect->agence_id=$admin->branch_id;
        $prospect->save();
        $notify[] = ['success', 'Modifié avec succès'];
        return redirect()->route('staff.prospect.list')->withNotify($notify);

    }

    public function listesms(Request $request)
    {
         
    }
    
    public function export_list(Request $request) {
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
            return redirect()->route('staff.bilan.agencetranslist')->withNotify($notify);
        }
        if ($end && !preg_match($pattern,$end)) {
            $notify[] = ['error','Invalid date format'];
            return redirect()->route('staff.bilan.agencetranslist')->withNotify($notify);
        }

   
   return Excel::download( new CustomerExportMapping($branch_id,$start,$end), ('listeclient.xlsx')) ;
        
    }
    

}