<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suivi extends Model
{
   // use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "suivi_conteneur";
    protected $primaryKey = 'id';
    protected $fillable = ['date_charge', 'etd', 'eta', 'conteneur_num', 'dossier_num', 'comp_bateau', 'draft_status', 'relache_status', 'palette', 'montant', 'regle', 'livrer'];
}