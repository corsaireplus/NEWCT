<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Constants\Status;
use App\Traits\Searchable;
use App\Traits\GlobalStatus;

class Container extends Model
{
    use SoftDeletes;
     use Searchable, GlobalStatus;
    protected $dates = ['deleted_at'];
    protected $table = "containers";
    protected $primaryKey = 'idcontainer';
    protected $fillable = ['idcontainer','desti_id','armateur','date','date_arrivee','status','user_id'];

   
    public function staff(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function envois(){
        return $this->hasMany(ContainerNbcolis::class,'container_id');
    }
    public function destination(){
        return $this->hasOne(Branch::class,'id','desti_id');
    }
    public function getTotalRemainingAttribute()
{
    // Sélectionnez l'ID de colis et le premier ID de conteneur associé pour chaque colis.
    $firstContainerForColis = DB::table('conatainer_nbcolis')
        ->select('id_colis', DB::raw('MIN(container_id) as first_container_id'))
        ->groupBy('id_colis');

    // Calculez le montant total restant en considérant uniquement les colis dans leur premier conteneur.
    $totalRemaining = DB::table('conatainer_nbcolis')
        ->joinSub($firstContainerForColis, 'first_containers', function ($join) {
            $join->on('conatainer_nbcolis.id_colis', '=', 'first_containers.id_colis');
        })
        ->join('transferts', 'conatainer_nbcolis.id_colis', '=', 'transferts.id')
        ->leftJoin('transfert_payments', 'transferts.id', '=', 'transfert_payments.transfert_id')
        ->leftJoin('paiements', 'transfert_payments.transfert_id', '=', 'paiements.transfert_id')
        ->where('conatainer_nbcolis.container_id', $this->idcontainer)
        ->where('first_containers.first_container_id', $this->idcontainer)
        ->whereIn('transfert_payments.status', [0, 1])
        ->select(DB::raw('SUM(transfert_payments.receiver_amount - COALESCE(paiements.receiver_payer, 0)) as total_remaining'))
        ->value('total_remaining');

    // Retournez le montant total restant, ou 0 s'il n'y a pas de données.
    return $totalRemaining ?: 0;
}

    /*
     public function getTotalRemainingAttribute()
      {
                    // Mettez ici votre logique pour calculer le montant restant à payer pour un conteneur.
                    // Vous pouvez utiliser la logique que vous avez déjà développée et l'adapter pour utiliser $this->id pour obtenir l'ID du conteneur actuel.
                
                    $firstContainerForColis = DB::table('conatainer_nbcolis')
                        ->select('id_colis', DB::raw('MIN(container_id) as first_container_id'))
                        ->groupBy('id_colis');
                
                    $totalRemaining = DB::table('conatainer_nbcolis')
                        ->join('transferts', 'conatainer_nbcolis.id_colis', '=', 'transferts.id')
                        ->join('transfert_payments', 'transferts.id', '=', 'transfert_payments.transfert_id')
                        ->leftJoin('paiements', 'transfert_payments.transfert_id', '=', 'paiements.transfert_id')
                        ->joinSub($firstContainerForColis, 'first_containers', function ($join) {
                            $join->on('conatainer_nbcolis.id_colis', '=', 'first_containers.id_colis');
                        })
                        ->where('conatainer_nbcolis.container_id', $this->idcontainer)
                        ->where('first_containers.first_container_id', $this->idcontainer)
                        ->whereIn('transfert_payments.status', [0, 1])
                        ->select(DB::raw('SUM(transfert_payments.receiver_amount - COALESCE(paiements.receiver_payer, 0)) as total_remaining'))
                        ->groupBy('conatainer_nbcolis.container_id')
                        ->first();
                     
                    return $totalRemaining ? $totalRemaining->total_remaining : 0;
          }
   */
    // public function sender(){
    //     return $this->
    // }
   

}