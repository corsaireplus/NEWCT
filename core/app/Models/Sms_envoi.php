<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SmsEnvoi extends Model
{
    use HasFactory;
    protected $table = "sms_envoi";
    protected $primaryKey = 'id';
    protected $fillable = ['id','date','idmission','rdv_id','contact','status'];
}