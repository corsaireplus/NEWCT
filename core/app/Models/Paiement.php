<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paiement extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "paiements";
    protected $primaryKey = 'id';
    protected $fillable = ['id','user_id','refpaiement','branch_id','transfert_id','rdv_id','date','status','montant_paye','mode_paiement','date_paiement'];
    
    public function rdv(){
        return $this->belongsTo(Rdv::class,'rdv_id');
    }
    public function transfert(){
        return $this->belongsTo(Transfert::class,'transfert_id');
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function TransfertPayment()
    {
        return $this->belongsTo(TransfertPayment::class, 'branch_id');
    }
    public function agent(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function modepayer(){
        return $this->hasOne(ModePaiement::class,'id','mode_paiement');
    }
    public function container_nbcolis(){
        return $this->belongsTo(ContainerNbcolis::class,'transfert_id','id_colis');    
    } 

}
