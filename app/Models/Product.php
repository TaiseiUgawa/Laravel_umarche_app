<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;
use App\Models\SecondaryCategory;
use App\Models\Image;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'name',
        'information',
        'price',
        'is_selling',
        'sort_order',
        'secondary_category_id',
        'image1',
        'image2',
        'image3',
        'image4',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function category()
    {
        return $this->belongsTo(SecondaryCategory::class, 'secondary_category_id');
    }

    public function imageFirst()
    {
        return $this->belongsTo(Image::class, 'image1', 'id');
    }
    public function imageSecond()
    {
        return $this->belongsTo(Image::class, 'image2', 'id');
    }
    public function imageThird()
    {
        return $this->belongsTo(Image::class, 'image3', 'id');
    }
    public function imageFourth()
    {
        return $this->belongsTo(Image::class, 'image4', 'id');
    }



    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'carts')
        ->withPivot(['id', 'quantity']);
    }

    // 商品表示
    public function scopeAvailableItems($query)
    {
        // 在庫数が１より大きいデータ
        $stocks = DB::table('t_stocks')
        ->select('product_id',
        DB::raw('sum(quantity) as quantity'))
        ->groupby('product_id')
        ->having('quantity', '>', 1);

        return $query->joinSub($stocks, 'stock', function($join){
            $join->on('products.id', '=', 'stock.product_id');
        })
        ->join('shops', 'products.shop_id', '=', 'shops.id')
        ->join('secondary_categories', 'products.secondary_category_id', '=','secondary_categories.id')
        ->join('images as image1', 'products.image1', '=', 'image1.id')
        ->select('products.id as id', 'products.name as name', 'products.price','products.sort_order as sort_order','products.information','secondary_categories.name as category','image1.filename as filename')
        ->where('shops.is_selling', true)
        ->where('products.is_selling', true);
    }

    // 商品表示順
    public function scopeSortOrder($query, $sortOrder)
    {
        if($sortOrder === null || $sortOrder === \Constant::SORT_ORDER['recommend']){
            return $query->orderby('sort_order', 'asc');
        }
        if($sortOrder === \Constant::SORT_ORDER['higherPrice']){
            return $query->orderby('price', 'desc');
        }
        if($sortOrder === \Constant::SORT_ORDER['lowerPrice']){
            return $query->orderby('price', 'asc');
        }
        if($sortOrder === \Constant::SORT_ORDER['later']){
            return $query->orderby('products.created_at', 'desc');
        }
        if($sortOrder === \Constant::SORT_ORDER['older']){
            return $query->orderby('products.created_at', 'asc');
        }
    }
}
