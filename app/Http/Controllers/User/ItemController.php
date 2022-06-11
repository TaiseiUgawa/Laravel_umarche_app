<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    //
    public function index()
    {
        // 在庫数が１より大きいデータ
        $stocks = DB::table('t_stocks')
        ->select('product_id',
        DB::raw('sum(quantity) as quantity'))
        ->groupby('product_id')
        ->having('quantity', '>', 1);

        // 画面表示データ取得
        $products = DB::table('products')
        ->joinSub($stocks, 'stock', function($join){
            $join->on('products.id', '=', 'stock.product_id');
        })
        ->join('shops', 'products.shop_id', '=', 'shops.id')
        ->join('secondary_categories', 'products.secondary_category_id', '=','secondary_categories.id')
        ->join('images as image1', 'products.image1', '=', 'image1.id')
        ->join('images as image2', 'products.image2', '=', 'image2.id')
        ->join('images as image3', 'products.image3', '=', 'image3.id')
        ->join('images as image4', 'products.image4', '=', 'image4.id')
        ->select('products.id as id', 'products.name as name', 'products.price','products.sort_order as sort_order','products.information','secondary_categories.name as category','image1.filename as filename')
        ->where('shops.is_selling', true)
        ->where('products.is_selling', true)
        ->get();

        // dd($stocks,$products);

        // $products = Product::all();
        return view('user.index', compact('products'));
    }
}
