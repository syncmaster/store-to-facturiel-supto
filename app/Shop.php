<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Shop extends Model
{
    protected $table = 'shops';

    public function create($data) {
        self::insert($data);
    }

    public function updateShop($id, $data) {
        self::where('id', $id)->update($data);
    }

    public function destroyShop($id) {
        self::destroy($id);
    }

    public function products() {
        return $this->hasMany(Product::class, 'shop_id', 'id');
    }
}
