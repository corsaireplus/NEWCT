<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ContainerNbcolis extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "conatainer_nbcolis";
    protected $primaryKey = 'id';
    protected $fillable = ['id','container_id','id_colis','nb_colis'];

    public function colis(){
        return $this->belongsTo(Transfert::class,'id_colis');

    }
    public function payments(){
        return $this->hasMany(Paiement::class,'transfert_id','id_colis');

    }
    public function transfert_payments(){
        return $this->hasMany(TransfertPayment::class,'transfert_id','id_colis');
    }
    public function conteneur(){
        return $this->belongsTo(Container::class,'container_id');
    }
    public function livraison(){
        return $this->hasOne(Livraison::class,'colis_id','id_colis');
    }
}