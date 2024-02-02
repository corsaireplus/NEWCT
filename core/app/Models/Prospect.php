<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prospect extends Model
{
   // use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "prospects";
    protected $primaryKey = 'id';
    protected $fillable = ['reference','customer_id','date','status','user_id','observation'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'customer_id');
    }
    public function senderStaff()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}