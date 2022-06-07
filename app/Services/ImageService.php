<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;
use InterventionImage;

class ImageService
{
    public static function upload($imageFile, $folderName)
    {
        // Storage::putFile('public/shops', $imageFile);  リサイズなしの場合

        // ユニークな名前　＋　Fileの拡張子　で保存するファイル名作成
        $filename = uniqid(rand().'_');
        $extension = $imageFile->extension();
        $fileNameToStore = $filename . '.' . $extension;

        // 指定のサイズにリサイズする
        $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();

        Storage::put('public/'. $folderName . '/' . $fileNameToStore, $resizedImage);

        return $fileNameToStore;
    }
}
