<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Livraison extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "livraison";
    protected $primaryKey = 'id';
    protected $fillable = ['id','colis_id','nom','telephone','piece_id','user_id'];

   
    public function livreur(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function container(){
        return $this->belongsTo(ContainerNbcolis::class,'id_colis','colis_id');
    }

    public function transfert(){
        return $this->belongsTo(Transfert::class,'colis_id','id');
     }
    
   
   
   

}