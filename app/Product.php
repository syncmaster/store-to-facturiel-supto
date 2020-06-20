<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Shop;

class Product extends Model
{
    protected $table = 'products';

    public function shops() {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function create($data) {
        self::insert($data);
    }
}
