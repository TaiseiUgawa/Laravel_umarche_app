<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:owners');

        #クロージャー
        $this->middleware(function ($request, $next) {
            //文字列
            // dd($request->route()->parameter('shop'));

            //
            $id = $request->route()->parameter('image');

            if(!is_null($id))
            {
                $imageOwnerId = Image::findOrFail($id)->owner->id;
                $imageId = (int)$imageOwnerId;

                if($imageId !== Auth::id())
                {
                    abort(404);
                }
            }
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $images = Image::where('owner_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        // IndexViewに遷移
        return view('owner.images.index',
        compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //作成画面に飛ばすだけ
        return view('owner.images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadImageRequest $request)
    {
        $iamgefiles = $request->file('files');

        if(!is_null($iamgefiles))
        {
            foreach ($iamgefiles as $imagefile) {
                // アップロード保存先処理
                $fileNameToStore = ImageService::upload($imagefile, 'products');
                //                               保存先   ファイル名,   フォルダ名
                Image::create([
                    'owner_id' => Auth::id(),
                    'filename' => $fileNameToStore,
                ]);
            }
            // dd('作成完了');
            //リダイレクト処理
            return redirect()
            ->route('owner.images.index')
            ->with(['message' => '画像登録を実施しました。',
            'status' => 'info']);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // DBデータ取得
        $image = Image::findOrFail($id);

        // EditViewに遷移
        return view('owner.images.edit', compact('image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //更新情報バリデーション
        $request->validate([
            // 今回はタイトルのみ
            'title' => ['required', 'string', 'max:50'],
        ]);

        // ID取得しているDB情報持ってくる && 変更保存処理
        $image = Image::findOrFail($id);
        $image->title = $request->title;
        $image->save();

        // リダイレクト && フラメ処理
        return redirect()
        ->route('owner.images.index')
        ->with(['message' => '画像タイトルを更新しました。',
        'status' => 'info']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // フォルダ内画像削除
        $image = Image::findOrFail($id);
        $filePath = 'public/products/' . $image->filename;

        //画像削除
        if(Storage::exists($filePath))
        {
            Storage::delete($filePath);
        }

        //DB情報削除
        Image::findOrFail($id)->delete();

        // リダイレクト処理
        return redirect()->route('owner.images.index')
        ->with(['message' => '画像情報を削除しました。',
        'status' => 'alert']);
    }
}
