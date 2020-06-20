<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;
use App\Product;
use Carbon\Carbon;

class FactorielController extends Controller
{
    public function index() {
        $products = Product::with('shops:id,name')->get();
        $shops = Shop::select('id', 'name')->whereHas('products')->get();
        return view('factoriel')->with(
            [
                'products' => $products,
                'shops' => $shops
            ]
        );
    }

    public function search(Request $request) {

        $data = $request->all();
        $search = $data['search'];
        $shopId = $data['shop'];

        $products = Product::with('shops:id,name')->where(function($query) use($search, $shopId) {
            if (mb_strlen($search)) {
                $query->where('order_id', $search);
            }
            if (mb_strlen($shopId) && $shopId > 0) {
                $query->where('shop_id', $shopId);
            }
        })->get();
        $shops = Shop::select('id', 'name')->whereHas('products')->get();
        return view('factoriel')->with(
            [
                'products' => $products,
                'shops' => $shops,
                'data' => [
                    'search' => $search,
                    'shop' => $shopId
                ]
            ]
        );
    }

    

}
