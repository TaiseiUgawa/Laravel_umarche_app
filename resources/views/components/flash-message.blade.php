@props(['status' => 'info'])
{{-- switch文でも実装可能 --}}

{{-- ステータスの状態によって背景色変更 --}}
@php
    if(session('status') === 'info'){ $bgColor = 'bg-blue-300';}
    if(session('status') === 'alert'){ $bgColor = 'bg-red-500';}
@endphp

{{-- セッションでメッセージ来たら --}}
@if(session('message'))
    <div class="{{ $bgColor }} w-1/2 mx-auto p-2 my-4 text-white">
        {{ session('message') }}
    </div>
@endif
