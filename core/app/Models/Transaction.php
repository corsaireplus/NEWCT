<?php


// app/Models/Transaction.php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Constants\Status;
use App\Traits\Searchable;
use App\Traits\GlobalStatus;


class Transaction extends Model
{
   // use LogsActivity;
    use Searchable, GlobalStatus;
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "transactions";
    protected $primaryKey = 'id';

    // Autres attributs et méthodes de votre modèle

    // protected static $logAttributes = ['*'];
    // protected static $logOnlyDirty = true;
    // protected static $logName = 'transactions';


    public function sender()
    {
        return $this->belongsTo(Client::class, 'sender_id');
    }
    
    public function receiver()
    {
        return $this->belongsTo(Client::class, 'receiver_id');
    }
    public function sender_adresse()
    {
        return $this->belongsTo(RdvAdresse::class, 'client_id','sender_id');
    }
    
    public function receiver_adresse()
    {
        return $this->belongsTo(RdvAdresse::class, 'id','rdv_id');
    }
    // public function senderStaff()
    // {
    //     return $this->belongsTo(User::class, 'sender_staff_id');
    // }

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
        return $this->belongsTo(Branch::class, 'branch_id');
    }


    public function paymentInfo()
    {
        return $this->hasOne(TransactionFacture::class, 'transaction_id');
    }

    public function courierDetail()
    {
        return $this->hasMany(TransactionProduct::class, 'transaction_id')->with('type');
    }
    public function transfertDetail()
    {
        return $this->hasMany(TransfertRef::class, 'transaction_id');
    }
    public function paiement(){
        return $this->hasMany(Paiement::class, 'transaction_id');
    }
    public function payment()
    {
        return $this->hasOne(CourierPayment::class, 'courier_info_id', 'id');
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

    public function senderStaff()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function products()
    {
        return $this->hasMany(TransactionProduct::class, 'transaction_id', 'id');
    }
    // public function receiverStaff()
    // {
    //     return $this->belongsTo(User::class, 'receiver_staff_id');
    // }
    public function scopeUpcoming()
    {
        return $this->where('branch_id', auth()->user()->branch_id)->where('ship_status',0);
    }

}
