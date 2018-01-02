<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'uri',
        'parent_id',
        'order',
        'menu'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'parent_id' => 'integer',
        'order' => 'integer',
        'menu' => 'boolean'
    ];

    /**
     * Products in a Category (Category - Product: One to Many)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products() {
        return $this->hasMany('App\Product');
    }

    /**
     * Sub-Categories of this Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(){
        return $this->hasMany('App\Category', 'parent_id');
    }

    /**
     * Parent Category of this Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(){
        return $this->belongsTo('App\Category', 'parent_id');
    }

    /**
     * All products under this Category and all of its Sub-Categories
     *
     * @param $category
     * @param null $products
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function allProducts($category, $products = null) {
        if ($products === null) {
            $products = collect();
        }

        $products = $products->merge($category->products);

        $category->children->each(function($child) use(&$products) {
            $products = self::allProducts($child, $products);
        });

        $products = $products->sortBy('order');

        return $products;
    }
}