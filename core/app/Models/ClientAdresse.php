<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAdresse extends Model
{
    protected $table = "client_adresses";
    protected $primaryKey = 'id';
    protected $fillable = ['id','adresse','code_postal','observation'];
   
    public function rdv()
    {
        return $this->hasMany(Rdv::class, 'sender_idsender');
    }

}