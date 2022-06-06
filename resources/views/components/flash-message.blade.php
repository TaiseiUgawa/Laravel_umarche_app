@props(['status' => 'info'])
{{-- switch文でも実装可能 --}}

{{-- ステータスの状態によって背景色変更 --}}
@php
    if($status === 'info'){ $bgColor = 'bg-blue-300';}
    if($status === 'error'){ $bgColor = 'bg-red-500';}
@endphp

{{-- セッションでメッセージ来たら --}}
@if(session('message'))
    <div class="{{ $bgColor }} w-1/2 mx-auto p-2 text-white">
        {{ session('message') }}
    </div>
@endif
