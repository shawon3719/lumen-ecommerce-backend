<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $appends = ["created_at_formatted", "updated_at_formatted"];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class, 'shipping_address_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id')->with("product");
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('F d, Y h:i');
    }

    public function getUpdatedAtFormattedAttribute()
    {
        return $this->updated_at->format('F d, Y h:i');
    }

    public function countOrderItems()
    {
        $amount = 0;

        foreach ($this->orderDetails as $detail) {
            $amount += $detail->amount;
        }

        return $amount;
    }
}