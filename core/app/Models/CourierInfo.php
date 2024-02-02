<?php

namespace App\Models;

use App\Models\User;
use App\Models\Branch;
use App\Constants\Status;
use App\Traits\Searchable;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class CourierInfo extends Model
{
    use Searchable, GlobalStatus;

    public function senderStaff()
    {
        return $this->belongsTo(User::class, 'sender_staff_id');
    }

    public function receiverStaff()
    {
        return $this->belongsTo(User::class, 'receiver_staff_id');
    }

    public function receiverBranch()
    {
        return $this->belongsTo(Branch::class,'receiver_branch_id');
    }

    public function senderBranch()
    {
        return $this->belongsTo(Branch::class, 'sender_branch_id');
    }

    public function paymentInfo()
    {
        return $this->hasOne(CourierPayment::class, 'courier_info_id');
    }

    public function courierDetail()
    {
        return $this->hasMany(CourierProduct::class, 'courier_info_id')->with('type');
    }

    public function scopeQueue()
    {
        return $this->where('sender_branch_id', auth()->user()->branch_id)->where('status', Status::COURIER_QUEUE);
    }

    public function scopeDispatched()
    {
        return $this->where('sender_branch_id', auth()->user()->branch_id)->where('status', Status::COURIER_DISPATCH);
    }

    public function scopeUpcoming()
    {
        return $this->where('receiver_branch_id', auth()->user()->branch_id)->where('status', Status::COURIER_UPCOMING);
    }

    public function scopeDeliveryQueue()
    {
        return $this->where('receiver_branch_id', auth()->user()->branch_id)->where('status', Status::COURIER_DELIVERYQUEUE);
    }

    public function scopeDelivered()
    {
        return $this->where('receiver_branch_id', auth()->user()->branch_id)->where('status', Status::COURIER_DELIVERED);
    }

    public function products()
    {
        return $this->hasMany(CourierProduct::class, 'courier_info_id', 'id');
    }
    public function payment()
    {
        return $this->hasOne(CourierPayment::class, 'courier_info_id', 'id');
    }

    public function senderCustomer(){
        return $this->belongsTo(Customer::class, 'sender_customer_id', 'id');
    }

    public function receiverCustomer(){
        return $this->belongsTo(Customer::class, 'receiver_customer_id', 'id');
    }
}
