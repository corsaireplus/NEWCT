<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MissionsRdvs extends Model
{
 public function type()
 {
    return $this->belongsTo(Rdv::class, 'rdv_idrdv');
 }
}