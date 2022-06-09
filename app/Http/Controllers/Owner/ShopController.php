<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use InterventionImage;
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;

class ShopController extends Controller
{
    //
    public function __construct()
    {
        // 認証情報
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

    // インデックス処理
    public function index()
    {

        $ownerId = Auth::id();
        $shops = Shop::where('owner_id', $ownerId)->get();

        return view('owner.shops.index',
        compact('shops'));
    }

    // 編集処理
    public function edit($id)
    {
        
        $shop = Shop::findOrFail($id);
        // dd(Shop::findOrFail($id));

        return view('owner.shops.edit', compact('shop'));
    }

    public function update(UploadImageRequest $request, $id)
    {
        // バリデーション
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'information' => ['required', 'string', 'max:1000'],
            'is_selling' => ['required'],
        ]);

        // 画像アップロード処理
        $imageFile = $request->image;
        if(!is_null($imageFile) && $imageFile->isValid())
        {
            $fileNameToStore = ImageService::upload($imageFile, 'shops');
        }

        // 保存処理
        $shop = Shop::findOrFail($id);
        $shop->name = $request->name;
        $shop->information = $request->information;
        $shop->is_selling = $request->is_selling;
        if(!is_null($imageFile) && $imageFile->isValid())
        {
            $shop->filename = $fileNameToStore;
        }
        $shop->save();

        return redirect()
        ->route('owner.shops.index')
        ->with(['message' => '店舗登録を実施しました。',
        'status' => 'info']);
    }
}
