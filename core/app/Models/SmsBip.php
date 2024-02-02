<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SmsBip extends Model
{
    use HasFactory;
    protected $table = "sms_bip";
    protected $primaryKey = 'id';
    protected $fillable = ['id','groupId','groupName','name','ids','sms_id'];

    public function sms(){
        return $this->belongsTo(Sms::class,'sms_id','id');
    }
}