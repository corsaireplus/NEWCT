<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Searchable, GlobalStatus;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */


    public function loginLogs()
    {
        return $this->hasMany(UserLogin::class);
    }


    public function fullname(): Attribute
    {
        return new Attribute(
            get: fn () => $this->firstname . ' ' . $this->lastname,
        );
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }


    // SCOPES
  

    public function scopeBanned()
    {
        return $this->where('status', Status::BAN_USER);
    }
    public function scopeManager($query)
    {
        $query->where('user_type', 'manager');
    }
    public function scopeStaff($query)
    {
        $query->where('user_type', 'staff');
    }
}
