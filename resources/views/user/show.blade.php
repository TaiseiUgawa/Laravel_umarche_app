<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品の詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="md:flex md:justify-around">
                        <div class="md:w-1/2">
                            <x-thumbnail filename="{{ $product->imageFirst->filename ?? ''}}" type="products" />
                        </div>
                        <div class="md:w-1/2 ml-4">
                            {{-- カテゴリーネーム --}}
                            <h2 class=" mb-4 text-sm title-font text-gray-500 tracking-widest">{{ $product->category->name }}</h2>
                            {{-- 商品名 --}}
                            <h1 class="mb-4 text-gray-900 text-3xl title-font font-medium ">{{ $product->name }}</h1>
                            {{-- 商品詳細 --}}
                            <p class="mb-4 leading-relaxed">{{ $product->information }}</p>
                            {{-- 金額　--}}
                            <div class="flex justify-around">
                                <div>
                                    <span class="title-font font-medium text-2xl text-gray-900">{{ number_format($product->price) }}</span>
                                    <span class="text-sm text-gray-700">円(税込)</span>
                                </div>
                                {{-- 数量 --}}
                                <div class="flex ml-6 items-center">
                                    <span class="mr-3">Size</span>
                                    <div class="relative">
                                      <select class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500 text-base pl-3 pr-10">
                                        <option>SM</option>
                                        <option>M</option>
                                        <option>L</option>
                                        <option>XL</option>
                                      </select>
                                      <span class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4" viewBox="0 0 24 24">
                                          <path d="M6 9l6 6 6-6"></path>
                                        </svg>
                                      </span>
                                    </div>
                                  </div>
                                </div>
                                {{-- カートボタン --}}
                                <button class="flex ml-auto text-white bg-blue-500 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 rounded">カートに入れる</button>
                                {{-- お気に入りボタン --}}
                                <button class="rounded-full w-10 h-10 bg-gray-200 p-0 border-0 inline-flex items-center justify-center text-gray-500 ml-4">
                                  <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path>
                                  </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
