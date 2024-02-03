<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Searchable;
use App\Traits\GlobalStatus;

class Rdv extends Model
{
    use Searchable, GlobalStatus;
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = "rdvs";
    protected $primaryKey = 'idrdv';
    protected $fillable = ['idrdv','sender_idsender','date','status','user_id','montant','mission_id','order_list','created_at'];
    
    public function senderStaff()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function paymentInfo()
    {
        return $this->hasOne(RdvPayment::class, 'rdv_id');
    }

    public function sender()
    {
        return $this->belongsTo(Client::class, 'sender_idsender');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'sender_idsender');
    }
    // public function staff(){
    //     return $this->belongsTo(Admin::class, 'user_id');
    // }
    public function courierDetail()
    {
        return $this->hasMany(RdvProduct::class, 'rdv_idrdv')->with('type');
    }
    public function rdvDetail()
    {
        return $this->hasMany(RdvProduct::class, 'rdv_idrdv')->with('type');
    }
    public function mission()
    {
        return $this->belongsTo(Mission::class,'mission_id');
    }
    public function chauffeur(){
        return $this->belongsTo(User::class,'chauf_id');
    }
    public function paiement(){
        return $this->hasMany(Paiement::class, 'transfert_id');
    }

    public function adresse(){
        return $this->hasOne(RdvAdresse::class,'rdv_id','idrdv');
    }

    public function transfert(){
        return $this->hasOne(Transfert::class,'receiver_satff_id','idrdv');
    }

    public function depot(){
        return $this->hasOne(Paiement::class,'rdv_id','idrdv');
    }

    public function scopeQueue()
    {
        return $this->where('mission_id','!=',NULL)->where('status', 0);
    }

    public function scopeNextrdv()
    {
        return $this->where('status', 0);
    }
}