<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompteurRdvChauffeur extends Model
{
    use HasFactory;

    protected $table = 'compteurRdvChauffeur';

    protected $fillable = [
        'chauffeur_id',
        'rdv_counter'
    ];

    public function chauffeur()
    {
        return $this->belongsTo(User::class,'chauffeur_id');
    }
}
