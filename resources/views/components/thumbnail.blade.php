@php
    // 渡される属性によってパス変更
    if($type === 'products'){
        $path = 'storage/products/';
    }
    if($type === 'shops'){
        $path = '/storage/shops/';
    }
    // dd($path);
@endphp

<div>
    @if(empty($filename))
        <img src="{{ asset('images/no_image.jpg') }}" >
    @else
        <img src="{{ asset($path.$filename) }}" >
    @endif
</div>
