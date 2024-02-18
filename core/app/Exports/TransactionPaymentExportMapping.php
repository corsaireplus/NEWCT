<?php

namespace App\Exports;

use App\Models\TransactionFacture;
use App\Models\ContainerNbcolis;
use App\Models\Container;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;


class TransactionPaymentExportMapping implements  FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id;

    function __construct($id) {
            $this->id = $id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $ct=$this->id;
        $containerCreationDate = Container::where('idcontainer', $ct)->value('created_at');

        return ContainerNbcolis::where('container_id', $ct)
        ->where('date_livraison', null)
        ->where('newold',1)
        ->with('transaction')
        ->whereHas('transaction', function ($query) {
        $query->where('status', '!=', 2);
         })
        ->withSum('payments as paye','receiver_payer')
        ->get();
    
       // return TransfertPayment::where('status','!=','2')->withSum('payments as paye','sender_payer')->whereHas('container_nbcolis', function ($q) use ($id) {
         //   $q->where('container_id', $id);
         // })->with('transfert','transfert.paymentInfo','transfert.transfertDetail','transfert.receiver')->get();
    }

    public function map($paiement) : array {

        return [

            $paiement->transaction->reftrans,
            $paiement->transaction->transfertDetail->count(),
            $paiement->nb_colis,
            $paiement->transaction->receiver->nom,
            $paiement->transaction->receiver->contact,
            $paiement->transaction->paymentInfo->receiver_amount,
            getAmount($paiement->transaction->paymentInfo->receiver_amount - $paiement->paye)
         

        ] ;
    }

    public function headings() : array {

        return [

           'Reference',
           'Nb Colis',
           'Nb charge',
           'Destinataire',
           'Contact',
           'Frais',
           'Reste a Payer'

        ] ;

    }
}
