<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransfertProduct extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "transfert_product";
    protected $primaryKey = 'id';
    protected $fillable=['name'];

    public function type()
    {
        return $this->belongsTo(Type::class, 'transfert_type_id');
    }

}