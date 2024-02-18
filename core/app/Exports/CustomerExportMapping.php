<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class CustomerExportMapping implements FromCollection, WithMapping, WithHeadings
{
    protected $branch_id;
    protected $start;
    protected $end;

    function __construct($branch_id,$start,$end) {
            $this->branch_id = $branch_id;
            $this->start =$start;
            $this->end =$end;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
      
            $branch_id = $this->branch_id;
            $start = $this->start;
            $end= $this->end;
            return Client::with('client_adresse')->where('country_id',$branch_id)->whereBetween('created_at', [Carbon::parse($start), Carbon::parse($end)])->orderBy('id','DESC')->get();
    }

    public function map($paiement) : array {

        return [
            $paiement->nom,
            $paiement->contact,
            $paiement->email,
            $paiement->client_adresse ? $paiement->client_adresse->adresse :'' ,
            $paiement->client_adresse ? $paiement->client_adresse->code_postal : '',
            showDateTime($paiement->created_at, 'd M Y')
            
             
        ] ;
    }

    public function headings() : array {

        return [

           'Nom Prenom',
           'Contact',
           'Email',
           'Adresse',
           'Code Postal',
           'Date Creation'
         
        ] ;

    }
}
