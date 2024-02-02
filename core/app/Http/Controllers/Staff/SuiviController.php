<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Suivi;


class SuiviController extends Controller
{

    public function index(){
        $pageTitle = "Suivi Conteneur";
        $rdv=Suivi::where('date_charge','!=',null)->paginate(getPaginate());
       // $listerdv=Rdv::all();
        $emptyMessage = "No data found";
        return view('staff.suivi.index',compact('rdv','pageTitle','emptyMessage'));
    }
    public function create(){
        $pageTitle = "Crer Suivi Conteneur";
       // $rdv=Rdv::where('status',0)->orderBy('date', 'ASC')->with('client','client.adresse','chauffeur','adresse')->paginate(getPaginate());
       // $listerdv=Rdv::all();
        $emptyMessage = "No data found";
        return view('staff.suivi.create',compact('pageTitle','emptyMessage'));
    }

    public function store(Request $request){
       // dd($request);
        $id=Suivi::create($request->all())->id;
        $suivi=Suivi::find($id);
        $suivi->date_charge=date("Y-m-d", strtotime($request->date_charge));
        $suivi->save();

        $notify[]=['success','Suivi Créé avec succès'];
        return redirect()->route('staff.suivi.liste')->withNotify($notify);
    }

    public function edit($id){
        $pageTitle = "Modifier Suivi";
        $suivi =Suivi::findOrFail(decrypt($id));
        return view('staff.suivi.edit',compact('suivi','pageTitle'));

    }

    public  function update(Request $request)
    {
       // dd($request);
       $form_data=$request->all();
       unset($form_data['_token']);
        Suivi::where('id',$request->id)->update($form_data);
        $suivi=Suivi::find($request->id);
        $suivi->date_charge=date("Y-m-d", strtotime($request->date_charge));
        $suivi->save();
        
        $notify[]=['success','Suivi Modifié avec succès'];
        return redirect()->route('staff.suivi.liste')->withNotify($notify);
    }

}