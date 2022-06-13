<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use App\Services\CartService;
use App\Jobs\SendThanksMail;

class CartController extends Controller
{
    //
    public function index()
    {
        // ログインユーザーが持っているカート情報
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

    public function delete($id)
    {
        // 対象データ削除
        Cart::where('product_id', $id)
        ->where('user_id', Auth::id())
        ->delete();

        return redirect()->route('user.cart.index');
    }

    // 決済処理
    public function checkout()
    {
        $items = Cart::where('user_id', Auth::id())->get();
        $products = CartService::getItemsInCart($items);
        $user = User::findOrFail(Auth::id());

        SendThanksMail::dispatch($products, $user);
        dd('メールテスト');
        // ログインユーザーが持っているカート情報
        $user = User::findOrFail(Auth::id());
        $products = $user->products;

        // Stripeライブラリに渡すデータ取得
        $lineItems = [];
        foreach($products as $product)
        {
            $quantity = Stock::where('product_id', $product->id)->sum('quantity');
            // 決済前在庫確認処理
            if($product->pivot->quantity > $quantity){
                return redirect()->route('user.cart.index');
            } else {

                $lineItem = [
                    'name' => $product->name,
                    'description' => $product->information,
                    'amount' => $product->price,
                    'currency' => 'jpy',
                    'quantity' => $product->pivot->quantity,
                ];
                array_push($lineItems, $lineItem);
            }

            foreach ($products as $product ) {

                Stock::create([
                    'product_id' => $product->id,
                    'type' => \Constant::PRODUCT_LIST['reduce'],
                    'quantity' => $product->pivot->quantity * -1,
                ]);
            }
            // This is your test secret API key.
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            // セッション情報
            $checkout_session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [$lineItems],
                'mode' => 'payment',
                'success_url' => route('user.cart.success'),
                'cancel_url' => route('user.cart.cancel'),
            ]);
            // 公開鍵
            $publicKey = env('STRIPE_PUBLIC_KEY');

            return view('user.checkout',
            compact('checkout_session','publicKey'));
        }

    }

    // 決済完了後の処理
    public function success()
    {
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('user.items.index');
    }

    // 決済キャンセル処理
    public function cancel()
    {
        $user = User::findOrFail(Auth::id());

        foreach ($user->products as $product ) {

            Stock::create([
                'product_id' => $product->id,
                'type' => \Constant::PRODUCT_LIST['add'],
                'quantity' => $product->pivot->quantity ,
            ]);
        }

        return redirect()->route('user.cart.index');
    }

}
