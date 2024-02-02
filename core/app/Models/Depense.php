<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
   // use HasFactory;
   protected $table = "depenses";
   protected $primaryKey = 'id';
   protected $fillable = ['montant','decription'];

   public function staff(){
    return $this->belongsTo(User::class, 'user_id');
        }
        public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function categorie()
    {
        return $this->belongsTo(DepenseCategorie::class, 'cat_id');
    }


}