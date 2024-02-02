<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vente extends Model
{

    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "vente_carton";
    protected $primaryKey = 'id';
    protected $fillable = ['id','sender_idsender','reference','date','status','user_id','montant'];


    public function senderStaff()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function venteDetail()
    {
        return $this->hasMany(VenteProduct::class, 'vente_id')->with('type');
    }
    public function paiement(){
        return $this->hasMany(Paiement::class, 'vente_id');
    }

    public function client(){
        return $this->belongsTo(Client::class, 'sender_idsender');

    }
}