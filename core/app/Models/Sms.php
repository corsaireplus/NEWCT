<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sms extends Model
{
    use HasFactory;
    protected $table = "sms";
    protected $primaryKey = 'id';
    protected $fillable = ['id','date','rdv_cont','message','user_id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function details(){
        return $this->hasMany(SmsBip::class,'rd_ct','rdv_cont');
    }
}