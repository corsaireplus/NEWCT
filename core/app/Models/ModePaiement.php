<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModePaiement extends Model
{
    protected $table = "mode_paiement";
    protected $fillable = ['nom','description'];

    public function paiement(){
        return $this->belongsTo(Paiement::class,'mode_paiement');
    }

}