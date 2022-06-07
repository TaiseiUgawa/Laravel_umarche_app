<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use InterventionImage;
use App\Http\Requests\UploadImageRequest;

class ShopController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:owners');

        #クロージャー
        $this->middleware(function ($request, $next) {
            //文字列
            // dd($request->route()->parameter('shop'));

            //
            $id = $request->route()->parameter('shop');
            if(!is_null($id))
            {
                $shopsOwnerId = Shop::findOrFail($id)->owner->id;
                $shopId = (int)$shopsOwnerId;
                $ownerId = Auth::id();

                if($shopId !== $ownerId)
                {
                    abort(404);
                }
            }
            return $next($request);
        });
    }

    public function index()
    {


        $ownerId = Auth::id();
        $shops = Shop::where('owner_id', $ownerId)->get();

        return view('owner.shops.index',
        compact('shops'));
    }

    public function edit($id)
    {
        $shop = Shop::findOrFail($id);
        // dd(Shop::findOrFail($id));

        return view('owner.shops.edit', compact('shop'));
    }

    public function update(UploadImageRequest $request, $id)
    {
        // 画像アップロード処理
        $imageFile = $request->image;
        if(!is_null($imageFile) && $imageFile->isValid())
        {
            // Storage::putFile('public/shops', $imageFile);  リサイズなしの場合

            // ユニークな名前　＋　Fileの拡張子　で保存するファイル名作成
            $filename = uniqid(rand().'_');
            $extension = $imageFile->extension();
            $filenameToStore = $filename. '.' . $extension;

            // 指定のサイズにリサイズする
            $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();

            Storage::put('public/shops/' . $filenameToStore, $resizedImage);
        }

        return redirect()->route('owner.shops.index');
    }
}
