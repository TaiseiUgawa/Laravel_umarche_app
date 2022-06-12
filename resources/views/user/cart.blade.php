<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            カート情報
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(count($products) > 0)
                        @foreach ($products as $product)
                        <div class="mb:flex mb:items-center mb-2">
                            <div class="mb:w-3/12">
                                @if(isset($product->imageFirst->filename))
                                    <img src="{{ asset('storage/products/' . $product->imageFirst->filename) }}" >
                                @else
                                    <img src="" >
                                @endif
                            </div>
                            <div class="mb:w-4/12 mb:ml-2">{{ $product->name }}</div>
                            <div class="mb:w-3/12 flex justify-around">
                                <div>{{ $product->pivot->quantity }}個</div>
                                <div>{{ number_format($product->pivot->quantity * $product->price) }}
                                    <span class="text-sm text-gray-700">円(税込)</span>
                                </div>
                            </div>
                            <div class="mb:w-2/12">
                                <form method='post' action="{{ route('user.cart.delete' , ['item' => $product->id]) }}">
                                    @csrf
                                    <button>
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    @else
                        カートに商品が入っていません
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
