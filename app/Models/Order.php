<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /*
    * The "booted" method of the model.
    */
   protected static function booted(): void
   {
       static::created(function (Order $order) {
           $code = 'OR' . Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('Ymd');
           $code .= str_pad($order->id, 5, "0", STR_PAD_LEFT);

           $order->order_code = $code;
           $order->save();
       });
   }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_code',
        'total_price',
        'total_quantity'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that owns the cart.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the product for the order.
     */
    public function order_details(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
}
