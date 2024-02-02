<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PDO;

class BranchTransaction extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "branch_transactions";
    protected $primaryKey = 'id';
    protected $fillable=['type','amount','reff_no','note'];

    
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
     public function transfert(){
         return $this->belongsTo(Transfert::class,'transaction_id');
     }
     public function agent(){
         return $this->belongsTo(User::class,'created_by');
     }
}