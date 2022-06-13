<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Cart;

class CartService
{
    public static function getItemsInCart($items)
    {
        $products = [];
        foreach($items as $item)
        {
            // オーナー情報取得
            $product = Product::findOrFail($item->product_id);
            $owner = $product->shop->owner->select('name', 'email')->first()->toArray();
            $ownerValues = array_values($owner);
            $keys = ['ownerName', 'email'];
            $ownerInfo = array_combine($keys, $ownerValues);
            // 商品情報
            $product = Product::where('id', $item->product_id)
            ->select('id', 'name', 'price')->get()->toArray();
            // カート情報
            $quantity = Cart::where('product_id', $item->product_id)
            ->select('quantity')->get()->toArray();
            // 配列作成
            $result = array_merge($product[0],$ownerInfo,$quantity[0]);
            array_push($products, $result);
        }

        return $products;
    }
}

?>
