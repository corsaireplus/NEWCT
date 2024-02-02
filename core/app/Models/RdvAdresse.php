<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RdvAdresse extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "rdv_adresse";
    protected $primaryKey = 'id';
    protected $fillable = ['id','rdv_id','client_id','adressse','code_postal'];

    public function rdv(){
        return $this->belongsTo(Rdv::class, 'rdv_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    

}