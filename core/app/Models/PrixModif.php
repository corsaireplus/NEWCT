<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrixModif extends Model
{
   // use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "prix_modif";
    protected $primaryKey = 'id';
    protected $fillable = ['old_amount', 'new_amount', 'branch_id', 'old_user', 'new_user', 'transfert_id', 'sms_id'];



}