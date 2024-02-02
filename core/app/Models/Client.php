<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
   // use HasFactory;
   protected $table = "clients";
   protected $primaryKey = 'id';
   protected $fillable = ['id','nom','contact','email'];

    public function rdv()
    {
        return $this->hasMany(Rdv::class, 'sender_idsender');
    }
    public function transfert()
    {
        return $this->hasMany(Transfert::class, 'sender_idsender');
    }
    public function adresse(){
        return $this->hasMany(RdvAdresse::class, 'rdv_id');
    }
    public function sender_adresse(){
        return $this->hasMany(RdvAdresse::class, 'client_id');
    }
    public function receiver_adresse(){
        return $this->hasMany(RdvAdresse::class, 'client_id');
    }
    public function client_adresse(){
        return $this->hasOne(RdvAdresse::class,'client_id','id')->latest();
    }
    // public function facture(){
    //     return $this->hasMany((TransfertPayment::''))
    // }

    // public function receiverStaff()
    // {
    //     return $this->belongsTo(User::class, 'receiver_staff_id');
    // }

    // public function receiverBranch()
    // {
    //     return $this->belongsTo(Branch::class, 'receiver_branch_id');
    // }

    // public function senderBranch()
    // {
    //     return $this->belongsTo(Branch::class, 'sender_branch_id');
    // }


    // public function paymentInfo()
    // {
    //     return $this->hasOne(CourierPayment::class, 'courier_info_id');
    // }


    // public function courierDetail()
    // {
    //     return $this->hasMany(CourierProduct::class, 'courier_info_id')->with('type');
    // }
}
