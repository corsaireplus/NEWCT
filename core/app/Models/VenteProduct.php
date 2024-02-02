<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VenteProduct extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "vente_product";
    protected $primaryKey = 'id';
    protected $fillable=['id'];

    public function type()
    {
        return $this->belongsTo(Type::class, 'vente_type_id');
    }

}