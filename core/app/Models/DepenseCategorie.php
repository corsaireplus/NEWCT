<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepenseCategorie extends Model
{
    protected $table = "categorie_depenses";
    protected $primaryKey = 'id';
    protected $fillable = ['nom','decription'];


}