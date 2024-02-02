<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
//use Spatie\Activitylog\Traits\LogsActivity;

class TransactionProduct extends Model
{
   // use LogsActivity;

    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "transaction_product";
    protected $primaryKey = 'id';

    // Autres attributs et méthodes de votre modèle

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $logName = 'transaction_product';

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_cat_id');
    }
}