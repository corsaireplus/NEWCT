<?php

namespace App\Exports;

use App\Models\TransfertPayment;
use App\Models\ContainerNbcolis;
use App\Models\Container;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;


class TransfertPaymentExportMapping implements  FromCollection, WithMapping, WithHeadings
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
        ->whereNotExists(function ($query) use ($containerCreationDate) {
            $query->select(DB::raw(1))
              ->from('conatainer_nbcolis as cnb')
              ->join('containers as c', 'cnb.container_id', '=', 'c.idcontainer')
              ->whereRaw('cnb.id_colis = conatainer_nbcolis.id_colis')
              ->where('c.created_at', '<', $containerCreationDate);
            })
            ->with([
                'colis' => function ($query) {
            $query->with(['receiver', 'transfertDetail', 'courierDetail','paymentInfo'])
                  ->with(['paiement' => function ($query) {
                      $query->where('status', '<>', '2');
                  }]);
                 // ->selectRaw('transferts.*, (SELECT SUM(receiver_payer) FROM paiements WHERE paiements.transfert_id = transferts.id) as paye');
        }
    ])
    ->withSum('payments as paye','receiver_payer')
    ->get();
    
       // return TransfertPayment::where('status','!=','2')->withSum('payments as paye','sender_payer')->whereHas('container_nbcolis', function ($q) use ($id) {
         //   $q->where('container_id', $id);
         // })->with('transfert','transfert.paymentInfo','transfert.transfertDetail','transfert.receiver')->get();
    }

    public function map($paiement) : array {

        return [

            $paiement->colis->reference_souche,
            $paiement->colis->transfertDetail->count(),
            $paiement->nb_colis,
            $paiement->colis->receiver->nom,
            $paiement->colis->receiver->contact,
            $paiement->colis->paymentInfo->receiver_amount,
            getAmount($paiement->receiver_amount - $paiement->paye)
         

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
