@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="page">
        <div class="page__inner">

            <aside class="sidebar">
                <form class="search" method="GET" action="/products">
                    <input class="search__input" type="text" name="keyword" value="{{ request('keyword') }}"
                        placeholder="商品名で検索">
                    <button class="btn btn--primary" type="submit">検索</button>

                    <div class="selectbox">
                        <label class="selectbox__label">価格順で表示</label>
                        <select name="sort">
                            <option value="">並び替え</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>価格の安い順</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>価格の高い順</option>
                        </select>
                    </div>
                </form>
            </aside>

            <section class="content">
                <div class="content__top">
                    <h1 class="title">商品一覧</h1>
                    <a class="btn btn--accent" href="/products/register">＋ 商品を追加</a>
                </div>

                @if(request()->filled('keyword'))
                    <p class="subtitle">“{{ request('keyword') }}”の商品一覧</p>
                @endif

                <div class="grid">
                    @foreach($products as $product)
                        <a class="card" href="/products/detail/{{ $product->id }}">
                            <div class="card__imgwrap">
                                <img class="card__img" src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}">
                            </div>
                            <div class="card__row">
                                <p class="card__name">{{ $product->name }}</p>
                                <p class="card__price">¥{{ number_format($product->price) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="pager">
                    @if ($products->onFirstPage())
                        <span class="pager__arrow pager__arrow--disabled">‹</span>
                    @else
                        <a class="pager__arrow" href="{{ $products->previousPageUrl() }}">‹</a>
                    @endif

                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        @if ($page == $products->currentPage())
                            <span class="pager__dot pager__dot--active">{{ $page }}</span>
                        @else
                            <a class="pager__dot" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($products->hasMorePages())
                        <a class="pager__arrow" href="{{ $products->nextPageUrl() }}">›</a>
                    @else
                        <span class="pager__arrow pager__arrow--disabled">›</span>
                    @endif
                </div>
            </section>

        </div>
    </div>
@endsection