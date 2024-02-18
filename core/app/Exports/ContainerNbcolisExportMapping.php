<?php

namespace App\Exports;

use App\Models\ContainerNbcolis;
use App\Models\Container;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ContainerNbcolisExportMapping implements FromCollection, WithMapping, WithHeadings
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
        $ct=$this->id;
        return ContainerNbcolis::where('container_id',$ct)->where('date_livraison',NULL)->with('colis','colis.receiver','colis.transfertDetail','colis.courierDetail','colis.paiement')->withSum('payments as paye','sender_payer')->with(['transfert_payments'=> function ($q){
            $q->where('status','!=','2');}])->get();
       // $ct = $this->id;

                /* Obtenir la date de création du conteneur pour comparer
                $containerCreationDate = Container::where('idcontainer', $ct)->value('created_at');
                
                return ContainerNbcolis::where('container_id', $ct)
                    ->where('date_livraison', null)
                    ->whereDoesntHave('colis.otherContainerColis', function ($query) use ($containerCreationDate) {
                        $query->where('container_creation_date', '<', $containerCreationDate);
                    })
                    ->with([
                        'colis' => function ($query) {
                            $query->with([
                                'receiver',
                                'transfertDetail',
                                'courierDetail',
                                'paiement' => function ($q) {
                                    $q->where('status', '!=', '2');
                                }
                            ])
                            ->whereDoesntHave('otherContainerColis', function ($query) use ($containerCreationDate) {
                                $query->where('container_creation_date', '<', $containerCreationDate);
                            });
                        },
                        'colis.transfert_payments' => function ($q) {
                            $q->where('status', '!=', '2');
                        }
                    ])
                    ->withSum(['payments as paye' => function ($q) {
                        $q->where('status', '!=', '2');
                    }], 'sender_payer')
                    ->get();
                    */

    }

    public function map($paiement) : array {

        return [

            $paiement->colis->reference_souche,
            $paiement->colis->transfertDetail->count(),
            $paiement->nb_colis,
            $paiement->colis->receiver->nom,
            $paiement->colis->receiver->contact,
            $paiement->colis->paymentInfo->sender_amount,
            getAmount($paiement->colis->paymentInfo->sender_amount - $paiement->paye)
         

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
