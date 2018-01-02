<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';

    protected $guarded = ['id'];

    protected $fillable = [
        'code',
        'type',
        'discount_percentage',
        'discount_amount',
        'shipping',
        'limited',
        'limit',
        'usage',
        'start',
        'end',
        'active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'shipping' => 'boolean',
        'limited' => 'boolean',
        'limit' => 'integer',
        'usage' => 'integer',
        'start' => 'datetime',
        'end' => 'datetime',
        'active' => 'boolean',
    ];

    /**
     * Products (Coupon - Product: Many to Many)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products() {
        return $this->belongsToMany('App\Product', 'coupon_product', 'coupon_id', 'product_id');
    }

    /**
     * Orders that used this Coupon
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders() {
        return $this->hasMany('App\Order');
    }
}