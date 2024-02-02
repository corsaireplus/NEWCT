<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mission extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "missions";
    protected $primaryKey = 'idmission';
    protected $fillable = ['idmission','date','missioncol','contact','chauffeur_idchauffeur','chargeur_idchargeur','camion','status','user_id'];

    public function chauffeur(){
        return $this->belongsTo(User::class, 'chauffeur_idchauffeur');
    }
    public function chargeur(){
        return $this->belongsTo(User::class, 'chargeur_idchargeur');
    }
    public function staff(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function rdv(){
        return $this->hasMany(Rdv::class);
    }
    // public function sender(){
    //     return $this->
    // }
    public function missionDetail(){
        return $this->hasMany(MissionsRdvs::class,'mission_idmission')->with('rdv');
    }
    public function rdvs(){
        return $this->hasMany(Rdv::class,'mission_id');
    }

}