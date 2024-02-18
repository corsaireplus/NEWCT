<?php

namespace App\Exports;

use App\Models\Paiement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaiementExportMapping implements  FromCollection, WithMapping, WithHeadings
{
    protected $id;

    function __construct($id) {
            $this->id = $id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $id=$this->id;
        return Paiement::where('branch_id','2')->where('sender_branch_id','1')->whereHas('container_nbcolis', function ($q) use ($id) {
            $q->where('container_id', $id);
          })->with('transfert','transfert.paymentInfo','transfert.transfertDetail','transfert.receiver')->get();
    }

    public function map($paiement) : array {

        return [

            $paiement->transfert->reference_souche,
            $paiement->transfert->transfertDetail->count(),
            $paiement->container_nbcolis->nb_colis,
            $paiement->transfert->receiver->nom,
            $paiement->transfert->receiver->contact,
            $paiement->transfert->paymentInfo->sender_amount,
            $paiement->sender_payer
         

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
           'Montant Paye'

        ] ;

    }
}
