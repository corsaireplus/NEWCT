<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Trans extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "trans";
    protected $primaryKey = 'id';
    
    
     public function paiement(){
        return $this->hasMany(TransPayments::class, 'trans_id');
    }
}