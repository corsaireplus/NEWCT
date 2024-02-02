<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Type;
use DNS1D;
use App\Models\AdminNotification;
use Carbon\Carbon;
use App\Models\CourierProduct;
use App\Models\CourierPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Paiement;
use App\Models\BranchTransaction;
use App\Models\Vente;
use App\Models\VenteProduct;
use App\Models\Client;

class VenteController extends Controller
{
    public function index()
    {
        $pageTitle = "Liste des Ventes";
        $emptyMessage = "Aucune vente";
        $user = Auth::user();
        $courierLists=Vente::with('client','senderStaff')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('staff.vente.index', compact('courierLists', 'user', 'pageTitle', 'emptyMessage'));
    }
    public function create()
    {
        $pageTitle = "Ajouter Vente";
        $branchs = Branch::where('status', 1)->latest()->get();
        $types = Type::where('status', 1)->where('cat_id',2)->with('unit')->latest()->get();
    //dd($types);
        return view('staff.vente.create', compact('pageTitle', 'branchs', 'types'));
    }

    public function store(Request $request){
        //dd($request);

        $request->validate([
           
        'sender_name' => 'required|max:40',
        'sender_phone' => 'required|string|max:40',
        'total_payer' => 'numeric|gt:0',
        'courierName.*' => 'required_with:quantity|exists:types,id',
        'quantity.*' => 'required_with:courierName|integer|gt:0',
        'amount' => 'required|array',
        'amount.*' => 'numeric|gt:0',
    ]);
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
            } else {
                $sende_id = $sender_user->id;
            }
            $courier = new Vente();
            $courier->user_id = $user->id;
            $courier->sender_idsender = $sende_id;
            $courier->reference = getTrx();
            $courier->date=  $date_paiement;
            $courier->status = 0;
            $courier->montant=$request->montant_payer;
            $courier->save();
            $id = $courier->id;
            $totalAmount = 0;
            for ($i = 0; $i < count($request->courierName); $i++) {
                $courierType = Type::where('id', $request->courierName[$i])->where('status', 1)->firstOrFail();
               
                    $totalAmount += $request->quantity[$i] * $courierType->price;
            
              
                    $courierProduct = new VenteProduct();
                    $courierProduct->vente_id = $courier->id;
                    $courierProduct->vente_type_id = $courierType->id;
                    $courierProduct->type_cat_id = $courierType->cat_id;
                    $courierProduct->qty = $request->quantity[$i];
                    $courierProduct->fee = $request->quantity[$i] * $courierType->price;
                    $courierProduct->save();
             
                
            }

            $payer = new Paiement();
            $payer->user_id = $user->id;
            $payer->branch_id = $user->branch_id;
            $payer->sender_branch_id = $user->branch_id;
            $payer->vente_id = $courier->id;
            $payer->refpaiement = getTrx();
            $payer->sender_payer = $request->montant_payer;
            $payer->receiver_payer = $request->montant_payer * 656;
            $payer->mode_paiement = $request->mode;
            $payer->date_paiement = $date_paiement;
            $payer->status = '2';
            $payer->save();

            $branchtransaction = new BranchTransaction();
                $branchtransaction->branch_id = $user->branch_id;
                $branchtransaction->type = 'credit';
                $branchtransaction->amount = $request->montant_payer;
                $branchtransaction->reff_no = getTrx();
                $branchtransaction->operation_date= $date_paiement;
                $branchtransaction->type_transaction ='4';
                //$branchtransaction->rdv_id=$payment->rdv_id;
                $branchtransaction->created_by = $user->id;
                $branchtransaction->transaction_id = $request->refrdv;
                $branchtransaction->transaction_payment_id = $payer->id;
                
                $branchtransaction->save();

            $adminNotification = new AdminNotification();
            $adminNotification->user_id = $user->id;
            $adminNotification->title = 'Nouvel Vente Enregistré ' . $user->username;
            $adminNotification->click_url = urlPath('admin.courier.info.details', $id);
            $adminNotification->save();
            DB::commit();

            $notify[] = ['success', 'Vente enregistrée avec succès'];
    }catch (Exception $e) {

        DB::rollback();
    }


    return redirect()->route('staff.vente.list')->withNotify($notify);

    }
    
    public function invoice($id){
        $pageTitle = "Reçu Vente";
        $userInfo = Auth::user();
        $courierInfo =Vente::where('id', decrypt($id))->with('client','senderStaff')->first();
        $courierProductInfos = VenteProduct::where('vente_id', $courierInfo->id)->with('type')->get();
       // dd($courierInfo);
        $code = '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($courierInfo->reference, 'C128') . '" alt="barcode"   />' . "<br>" . $courierInfo->code;
        return view('staff.vente.print_invoice', compact('pageTitle', 'courierInfo', 'courierProductInfos','userInfo', 'code'));
    }
   
    

}