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
                            <!-- Slider main container -->
                            <div class="swiper-container">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    <div class="swiper-slide">
                                        @if(isset($product->imageFirst->filename))
                                            <img src="{{ asset('storage/products/' . $product->imageFirst->filename) }}" >
                                        @else
                                            <img src="" >
                                        @endif
                                    </div>
                                    <div class="swiper-slide">
                                        @if(isset($product->imageSecond->filename))
                                            <img src="{{ asset('storage/products/' . $product->imageSecond->filename) }}" >
                                        @else
                                            <img src="" >
                                        @endif
                                    </div>
                                    <div class="swiper-slide">
                                        @if(isset($product->imageThird->filename))
                                            <img src="{{ asset('storage/products/' . $product->imageThird->filename) }}" >
                                        @else
                                            <img src="" >
                                        @endif
                                    </div>
                                    <div class="swiper-slide">
                                        @if(isset($product->imageFourth->filename))
                                            <img src="{{ asset('storage/products/' . $product->imageFourth->filename) }}" >
                                        @else
                                            <img src="" >
                                        @endif
                                    </div>
                                </div>
                                <!-- If we need pagination -->
                                <div class="swiper-pagination"></div>

                                <!-- If we need navigation buttons -->
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>

                                <!-- If we need scrollbar -->
                                <div class="swiper-scrollbar"></div>
                            </div>
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
                                <form method="post" action="{{ route('user.cart.add') }}">    {{-- formタグ　method=""で通信設定する --}}
                                    @csrf
                                    <div class="flex ml-6 items-center">
                                        <span class="mr-3">数量</span>
                                        <div class="relative">
                                        <select name="quantity" class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500 text-base pl-3 pr-10">
                                            @for($i = 0; $i <= $quantity ; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
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
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                </form>
                                {{-- お気に入りボタン --}}
                                <button class="rounded-full w-10 h-10 bg-gray-200 p-0 border-0 inline-flex items-center justify-center text-gray-500 ml-4">
                                  <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path>
                                  </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- 店舗情報 --}}
                    <div class="border-t border-gray-400 my-8"></div>
                    <div class="mb-4 text-center">この商品を販売しているショップ</div>
                    <div class="mb-4 text-center">{{ $product->shop->name }}</div>
                    {{-- 店舗画像 --}}
                    <div class="mb-4 text-center">
                        @if( optional($product->shop)->filename !== null)
                            <img class="mx-auto w-40 h-40 object-cover rounded-full" src="{{ asset('storage/shops/' . $product->shop->filename) }}" >
                        @else
                            <img src="" >
                        @endif
                    </div>
                    {{-- 店舗情報確認ボタン --}}
                    <div class="mb-4 text-center">
                        <button data-micromodal-trigger="modal-1" href='javascript:;' type="button" class=" text-white bg-blue-500 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 rounded">ショップの詳細をみる</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- 店舗情報modal --}}
    <div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
          <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header">
              <h2 class="modal__title" id="modal-1-title">
                {{ $product->shop->name }}
              </h2>
              <button type="button" class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-1-content">
              <p>
                {{ $product->shop->information }}
              </p>
            </main>
            <footer class="modal__footer">
              <button  type="button" class="modal__btn" data-micromodal-close aria-label="Close this dialog window">閉じる</button>
            </footer>
          </div>
        </div>
    </div>
    {{-- script --}}
    <script src="{{ mix('js/swiper.js') }}"></script>
</x-app-layout>
