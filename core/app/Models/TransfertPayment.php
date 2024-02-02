<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransfertPayment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "transfert_payments";
    protected $primaryKey = 'id';

   
    public function transfert(){
        return $this->belongsTo(Transfert::class, 'transfert_id');
    }
    public function container_nbcolis(){
        return $this->belongsTo(ContainerNbcolis::class,'transfert_id','id_colis');
    }

    public function payments(){
        return $this->hasMany(Paiement::class,'transfert_id','transfert_id');

    }

    
}