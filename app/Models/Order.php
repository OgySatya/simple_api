<?php

namespace App\Models;

use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'costomer_name',
        'table_number',
        'order_time',
        'status',
        'total_price',
        'waiter_id',
        'chef_id',
        'cashier_id',
    ];
    public function totalPrice()
    {
        $order = OrderDetail::where('order_id', $this->id)->pluck('price');
        // $sum = OrderDetail::where('order_id', $this->id)->sum('price');
        $sum = collect($order)->sum();
        return $sum;
    }
    public function totalAmount()
    {
        $totalAmount = Order::where('status', 'Lunas')->sum('total_price');
        return $totalAmount;
    }
    /**
     * Get all of the orderDetail for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetail(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function waiter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'waiter_id', 'id');
    }
    public function chef(): BelongsTo
    {
        return $this->belongsTo(User::class, 'chef_id', 'id');
    }
    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_id', 'id');
    }
}
