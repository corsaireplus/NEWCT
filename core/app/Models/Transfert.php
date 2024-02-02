<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfert extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "transferts";
    protected $primaryKey = 'id';


    public function sender()
    {
        return $this->belongsTo(Client::class, 'sender_idsender');
    }
    
    public function receiver()
    {
        return $this->belongsTo(Client::class, 'receiver_idreceiver');
    }
    public function sender_adresse()
    {
        return $this->belongsTo(RdvAdresse::class, 'client_id','sender_idsender');
    }
    
    public function receiver_adresse()
    {
        return $this->belongsTo(RdvAdresse::class, 'id','rdv_id');
    }
    public function senderStaff()
    {
        return $this->belongsTo(User::class, 'sender_staff_id');
    }

    public function receiverStaff()
    {
        return $this->belongsTo(User::class, 'receiver_staff_id');
    }

    public function receiverBranch()
    {
        return $this->belongsTo(Branch::class, 'receiver_branch_id');
    }

    public function senderBranch()
    {
        return $this->belongsTo(Branch::class, 'sender_branch_id');
    }


    public function paymentInfo()
    {
        return $this->hasOne(TransfertPayment::class, 'transfert_id');
    }

    public function courierDetail()
    {
        return $this->hasMany(TransfertProduct::class, 'transfert_id')->with('type');
    }
    public function transfertDetail()
    {
        return $this->hasMany(TransfertRef::class, 'transfert_id');
    }
    public function paiement(){
        return $this->hasMany(Paiement::class, 'transfert_id');
    }
    public function container(){
        return $this->belongsTo(Container::class);
    }
    public function branch(){
        return $this->belongsTo(Branch::class);
    }
    public function nbcolis(){
        return $this->hasMany(ContainerNbcolis::class,'id_colis');
    }
    public function rdv(){
        return $this->belongsTo(Rdv::class,'idrdv','receiver_satff_id');
    }
    public function livraison(){
        return $this->hasMany(Livraison::class,'colis_id');
    }
}