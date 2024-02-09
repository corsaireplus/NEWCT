<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\CourierInfo;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
//RDV
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
use App\Models\GeneralSetting;

class SiteController extends Controller
{
    public function index()
    {
        $pageTitle = 'Home';
        
        $sections  = Page::where('tempname', $this->activeTemplate)->where('slug', '/')->first();
    
        return view($this->activeTemplate . 'home', compact('pageTitle', 'sections'));
    }

    public function pages($slug)
    {
        $page      = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections  = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections'));
    }

    public function contact()
    {
        $pageTitle = "Contact Us";
        $contact   = Frontend::where('data_keys', 'contact_us.content')->firstOrFail();
        return view($this->activeTemplate . 'contact', compact('pageTitle', 'contact'));
    }

    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name'    => 'required',
            'email'   => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket           = new SupportTicket();
        $ticket->user_id  = auth()->id() ?? 0;
        $ticket->name     = $request->name;
        $ticket->email    = $request->email;
        $ticket->priority = Status::PRIORITY_MEDIUM;

        $ticket->ticket     = $random;
        $ticket->subject    = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status     = Status::TICKET_OPEN;
        $ticket->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title     = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message                    = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message           = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function orderTracking(Request $request)
    {
        $pageTitle   = "Suivi Colis";
        $orderNumber = null;
        $orderConteneur=null;
        return view($this->activeTemplate . 'order_tracking', compact('pageTitle','orderNumber','orderConteneur'));
    }
    public function findOrder(Request $request)
    {
        $pageTitle = "Suivi Colis Tracking";
        $orderNumber = null;
        $orderConteneur=null;
        if($request->order_number){
            $request->validate([
                'order_number' => 'required|exists:transferts,reference_souche',
            ]);
            $orderNumber = Transfert::where('reference_souche', $request->order_number)->with('transfertDetail')->first();
            $orderCont=ContainerNbcolis::where('id_colis',$orderNumber->id)->with('conteneur')->get();

            //dd($orderCont);
            if($orderNumber->status != 0 || $orderCont)
            {
             $orderConteneur=ContainerNbcolis::where('id_colis',$orderNumber->id)->with('conteneur')->get();
             //dd($orderConteneur);

            }
            
            if(!$orderNumber){
                $notify[] = ['success', 'Reference Invalide'];
                return back()->withNotify($notify);
            }
           // dd($orderNumber);
        }
        return view($this->activeTemplate . 'order_tracking', compact('pageTitle', 'orderNumber','orderConteneur'));
        // $request->validate([
        //     'order_number' => 'required|exists:courier_infos,code',
        // ], [
        //     'order_number.exists' => "Invalid Order Number"
        // ]);
        // $pageTitle   = "Order Tracking";
        // $orderNumber = CourierInfo::where('code', $request->order_number)->first();

        // return view($this->activeTemplate . 'order_tracking', compact('pageTitle', 'orderNumber'));
    }

    public function policyPages($slug, $id)
    {
        $policy    = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate . 'policy', compact('policy', 'pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) {
            $lang = 'en';
        }

        session()->put('lang', $lang);
        return back();
    }

    public function cookieAccept()
    {
        $general = gs();
        Cookie::queue('gdpr_cookie', $general->site_name, 43200);
        return back();
    }

    public function cookiePolicy()
    {
        $pageTitle = 'Cookie Policy';
        $cookie    = Frontend::where('data_keys', 'cookie.data')->first();
        return view($this->activeTemplate . 'cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        $imgWidth  = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text      = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font/RobotoMono-Regular.ttf');
        $fontSize  = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox    = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function blog()
    {
        $pageTitle = "Blog";
        $blogs     = Frontend::where('data_keys', 'blog.element')->paginate(getPaginate());
        return view($this->activeTemplate . 'blog', compact('blogs', 'pageTitle'));
    }

    public function blogDetails($id, $slug)
    {
        $blog        = Frontend::where('id', $id)->where('data_keys', 'blog.element')->firstOrFail();
        $recentBlogs = Frontend::where('data_keys', 'blog.element')->where('id', '!=', $id)->orderby('id', 'DESC')->limit(7)->get();
        $pageTitle   = "Blog Details";

        $seoContents['keywords']           =  [];
        $seoContents['social_title']       = $blog->data_values->title;
        $seoContents['description']        = strLimit(strip_tags($blog->data_values->description_nic), 150);
        $seoContents['social_description'] = strLimit(strip_tags($blog->data_values->description_nic), 150);
        $seoContents['image']              = getImage('assets/images/frontend/blog/' . @$blog->data_values->blog_image, '700x525');
        $seoContents['image_size']         = '700x525';

        return view($this->activeTemplate . 'blog_details', compact('blog', 'pageTitle', 'recentBlogs', 'seoContents'));
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        $general   = gs();
        if ($general->maintenance_mode == Status::DISABLE) {
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view($this->activeTemplate . 'maintenance', compact('pageTitle', 'maintenance'));
    }

    function fetch(Request $request)
       {
        if($request->get('query'))
        {
         $query = $request->get('query');
         $data = DB::table('clients')
           ->join('rdv_adresse','clients.id','=','rdv_adresse.client_id')
           ->where('nom', 'LIKE', "%{$query}%")
           ->orWhere('contact','LIKE',"%{$query}%")
           ->first();
        }
        //dd($data);
        return response()->json($data);
    }
    public function getType(Request $request){
        $types = Type::where('status', 1)->where('cat_id',$request->id)->with('unit')->latest()->get();
        
        $output = '<option value=""> Choisir </option>';
        foreach($types as $row)
        {
           $output .= '<option   value="'.$row->id.'"  data-price='.round($row->price,2).' > '.$row->name.' '.round($row->price,2).' €</option>';
        }
      
        return $output;
     }

     public function rdvclientSubmit(Request $request)
    {

        
        $attachments = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $request->validate([
          
            'sender_name' => 'required|max:40',
           // 'sender_email' => 'required|email|max:40',
            'sender_phone' => 'required|string|max:40',
            'sender_address' => 'required|max:255',
            'date'=>'required',
            'rdvName.*' => 'required_with:quantity|exists:types,id',
            'courierName.*' => 'required_with:quantity|exists:types,id',
            'quantity.*' => 'required_with:courierName|integer|gt:0',
            'g-recaptcha-response' => 'required|captcha',

            // 'amount' => 'required|array',
            // 'amount.*' => 'numeric|gt:0',
        ]);
        
        try {
          //  $admin = Auth::user();
            $sender_user=Client::where('contact',$request->sender_phone)->first();

            if( !isset($sender_user) )
       {
        $sender = new Client();
        $sender->nom=strtoupper($request->sender_name);
        $sender->contact=$request->sender_phone;
        $sender->country_id =1;
        $sender->save();
        $sende_id= $sender->id;

        $adresse= new RdvAdresse();
        $adresse->client_id =$sende_id;
        $adresse->adresse =$request->sender_address;
        $adresse->code_postal=$request->sender_code_postal;
        $adresse->save();
       }else{
          // $nom = strtoupper($request->sender_name);
         //  $insertOrUpdate=DB::UPDATE("UPDATE `clients` SET `nom`='$nom',`adresse`='$request->sender_address',`code_postal`='$request->sender_code_postal' WHERE 'contact' = '$request->sender_phone'");
           $sende_id= $sender_user->id;
           //$adresse=RdvAdresse::where('client_id',$sende_id)->update(array('adresse' =>$request->sender_address,'code_postal'=>$request->sender_code_postal));

       }

        $dates=date('m/d/Y', strtotime($request->date));       
        $rdv= new Rdv();
        $rdv->sender_idsender=$sende_id;
        $rdv->status='10';
        $rdv->code = getTrx();
        $rdv->user_id= 911;
        $rdv->date=$dates;
        $rdv->observation=$request->observation;
        $rdv->save();

       

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
        $adminNotification->user_id = 911;
        $adminNotification->title = 'Nouvelle demande de Rdv le '.date('d/m/Y', strtotime($request->date));
        $adminNotification->click_url = urlPath('staff.rdv.edit',encrypt($rdv->idrdv));
        $adminNotification->save();

        $notify[]=['success','Rdv Créé avec succès'];
        return redirect()->route('rdvclient')->withNotify($notify);

    } catch (Exception $e) {
        DB::rollback();
    }

        //return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

     public function akwaba(Request $request){
        $pageTitle = "Akwaba chez Challenge Transit Plus";
        return view($this->activeTemplate .'akwaba',compact('pageTitle'));
    }
    
    public function departs(Request $request){
        $pageTitle = "Challenge Transit Plus";
        return view($this->activeTemplate .'departs',compact('pageTitle'));
    }

    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }
}
