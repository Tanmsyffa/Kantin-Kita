<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'nama_menu', 'qty', 'subtotal'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
