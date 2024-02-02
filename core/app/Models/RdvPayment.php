<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdvPayment extends Model
{
  

    protected $table = "rdv_payments";
    protected $primaryKey = 'id';
    protected $fillable=['date','amount','status','rdv_id','rdv_sender_id'];

    public function rdv(){
        return $this->belongsTo(Rdv::class, 'rdv_id');
    }
}
