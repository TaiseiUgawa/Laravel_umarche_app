<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;
use InterventionImage;

class ImageService
{
    public static function upload($imageFile, $folderName)
    {
        // dd($imageFile['image']);
        // $imageFileが配列で来た場合
        if(is_array($imageFile)){
            $file = $imageFile['image'];
        }else{
            $file = $imageFile;
        }

        // Storage::putFile('public/shops', $imageFile);  リサイズなしの場合

        // ユニークな名前　＋　Fileの拡張子　で保存するファイル名作成
        $filename = uniqid(rand().'_');
        $extension = $file->extension();
        $fileNameToStore = $filename . '.' . $extension;

        // 指定のサイズにリサイズする
        $resizedImage = InterventionImage::make($file)->resize(1920, 1080)->encode();

        Storage::put('public/'. $folderName . '/' . $fileNameToStore, $resizedImage);

        return $fileNameToStore;
    }
}
