<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //
    public function index()
    {
        // ログインユーザーが持っている商品情報
        $user = User::findOrFail(Auth::id());
        $products = $user->products;
        // カート内の商品合計金額　
        $totalPrice = 0;

        foreach ($products as $product) {
            $totalPrice += $product->price * $product->pivot->quantity;
        }
        // dd($products, $totalPrice);
        return view('user.cart', compact('products', 'totalPrice'));
    }

    public function add(Request $request)
    {
        //判定に必要なデータを一件格納する
        $itemInCart = Cart::where('user_id', Auth::id())
        ->where('product_id', $request->product_id)
        ->first();

        // 格納データ判定処理
        if($itemInCart){
            // あった場合　カート情報の数量を新たに変更
            $itemInCart->quantity += $request->quantity;
            $itemInCart->save();
        }else{
            // なかった場合テーブルに情報作成
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('user.cart.index');

    }

}
