<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdvProduct extends Model
{
   // use HasFactory;

   protected $table = "rdv_products";
   protected $primaryKey = 'id';
   protected $fillable=['qty','description'];

    public function type()
    {
        return $this->belongsTo(Type::class, 'rdv_product_id');
    }

    public function rdv(){
        return $this->belongsTo(Rdv::class,'rdv_idrdv','idrdv');
    }

    public function payments(){
        return $this->belongsTo(Paiement::class,'rdv_id','rdv_product_id');
    }
}
