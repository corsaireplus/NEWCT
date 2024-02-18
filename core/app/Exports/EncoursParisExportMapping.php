<?php

namespace App\Exports;

use App\Models\TransfertPayment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class EncoursParisExportMapping implements FromCollection, WithMapping, WithHeadings
{
   
    protected $start;
    protected $end;

    function __construct($start,$end) {
          
            $this->start =$start;
            $this->end =$end;
    }
    public function collection()
    {
        
            $start = $this->start;
            $end= $this->end;
            return TransfertPayment::select(
    'transfert_payments.transfert_id as transfert_id',
    'transfert_payments.sender_amount as prix','transfert_payments.created_at as date','transfert_payments.status as infopaiement',
    DB::raw('SUM(paiements.sender_payer) as montant_total_paye'),
    DB::raw('(transfert_payments.sender_amount - COALESCE(SUM(paiements.sender_payer), 0)) as reste_a_payer'),
    'clients.nom as client','clients.contact as contact','transferts.reference_souche as reference'
)
    ->leftJoin('paiements', 'transfert_payments.transfert_id', '=', 'paiements.transfert_id')
    ->leftJoin('clients', 'transfert_payments.transfert_receiverid', '=', 'clients.id') // Joindre la table "clients"
    ->leftJoin('transferts', 'transfert_payments.transfert_id', '=', 'transferts.id') // Joindre la table "clients"
    ->whereNull('transfert_payments.deleted_at')
    ->whereIn('transfert_payments.status', [0,1])  // Condition modifiée ici
    ->whereIn('transferts.status',[1,2])
    ->whereBetween('transfert_payments.created_at', [Carbon::parse($start), Carbon::parse($end)])
    ->groupBy('transfert_payments.transfert_id', 'transfert_payments.sender_amount')
    ->orderBy('reste_a_payer','DESC')->get();
           // return Client::with('client_adresse')->where('country_id',$branch_id)->whereBetween('created_at', [Carbon::parse($start), Carbon::parse($end)])->orderBy('id','DESC')->get();
    }
    public function map($paiement) : array {

        return [
            showDateTime($paiement->date, 'd M Y'),
            $paiement->reference,
            $paiement->client,
            $paiement->contact,
            $paiement->prix,
            $paiement->montant_total_paye,
            $paiement->reste_a_payer,
            showDateTime($paiement->created_at, 'd M Y')
            
             
        ] ;
    }

    public function headings() : array {

        return [

           'Date',
           'Reference',
           'Client',
           'Contact',
           'Prix',
           'Montant Paye',
           'Reste a Payer'
         
        ] ;

    }
    
    
}