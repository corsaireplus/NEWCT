<?php

namespace App\Exports;

use App\Models\Paiement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BilanExportMapping implements FromCollection, WithMapping, WithHeadings
{
    protected $branch_id;
    protected $year;
    protected $type;

    function __construct($branch_id,$year,$type) {
            $this->branch_id = $branch_id;
            $this->year =$year;
            $this->type =$type;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        /** $ct=$this->id;
        return ContainerNbcolis::where('container_id',$ct)->where('date_livraison',NULL)->with('colis','colis.receiver','colis.transfertDetail','colis.courierDetail','colis.paiement')->withSum('payments as paye','sender_payer')->with(['transfert_payments'=> function ($q){
            $q->where('status','!=','2');}])->get();
            */
            $branch_id = $this->branch_id;
            $year = $this->year;
            $type = $this->type;
            return  Paiement::where('branch_id', $branch_id)->where('mode_paiement',$type)->with('branch', 'transfert.sender', 'rdv.sender', 'agent')->whereYear('created_at',$year)->orderBy('id', 'DESC')->get();
    }

    public function map($paiement) : array {

        return [
            showDateTime($paiement->created_at, 'd M Y'),
            $paiement->transfert ? $paiement->transfert->reference_souche:$paiement->rdv->code,
            $paiement->transfert ? $paiement->transfert->sender->nom:$paiement->rdv->sender->nom,
             $paiement->transfert ? $paiement->transfert->sender->contact:$paiement->rdv->sender->contact,
             $paiement->transfert ? 'Transfert':'Depot RDV',
             getAmount($paiement->sender_payer)
             
        ] ;
    }

    public function headings() : array {

        return [

           'Date',
           'Reference',
           'Nom',
           'Contact',
           'Type',
           'Montant Paye'

        ] ;

    }
}
