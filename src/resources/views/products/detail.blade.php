@extends('layouts.app')

@section('title', '商品詳細')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')
        <div class="page page-detail">
            <h1 class="title">商品詳細</h1>

            <form class="form" method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="field">
                    <label class="label">商品名</label>
                    <input class="input input--wide" type="text" name="name" value="{{ old('name', $product->name) }}">
                    @foreach($errors->get('name') as $msg)
                        <div class="error">{{ $msg }}</div>
                    @endforeach
                </div>




                <div class="field">
                    <label class="label">値段</label>
                    <input class="input input--wide" type="text" name="price" value="{{ old('price', $product->price) }}">
                    @foreach($errors->get('price') as $msg)
                        <div class="error">{{ $msg }}</div>
                    @endforeach
                </div>




                <div class="field">
                    <label class="label">季節</label>

                    @php
    $selectedSeasons = old(
        'seasons',
        $product->seasons->pluck('id')->toArray()
    );
                       @endphp

                    @foreach($seasons as $season)
                        <label>
                            <input type="checkbox" name="seasons[]" value="{{ $season->id }}" {{ in_array($season->id, $selectedSeasons) ? 'checked' : '' }}>
                            {{ $season->name }}
                        </label>
                    @endforeach

                    @foreach($errors->get('seasons') as $msg)
                        <div class="error">{{ $msg }}</div>
                    @endforeach

                    @foreach($errors->get('seasons.*') as $msgs)
                        @foreach($msgs as $msg)
                            <div class="error">{{ $msg }}</div>
                        @endforeach
                    @endforeach
                </div>


                <div class="field">
                    <label class="label">現在の画像</label>
                    <div class="preview">
                        <img class="preview__img" src="{{ asset('storage/' . $product->image) }}" alt="">
                    </div>
                </div>
                @error('image')
                    <div class="error">{{ $message }}</div>
                @enderror

                <div class="field">
                    <label class="label">画像を変更する場合のみ選択</label>
                    <input class="input input--wide" type="file" name="image" accept=".png,.jpg,.jpeg">
                    @foreach($errors->get('image') as $msg)
                        <div class="error">{{ $msg }}</div>
                    @endforeach
                </div>

                <div class="field">
                    <label class="label">商品説明</label>
                    <textarea class="textarea" name="description">{{ old('description', $product->description) }}</textarea>
                    @foreach($errors->get('description') as $msg)
                        <div class="error">{{ $msg }}</div>
                    @endforeach
                </div>


                <div class="actions actions--split">
                    <a class="btn btn--ghost" href="/products">戻る</a>
                    <button class="btn btn--primary" type="submit">変更を保存</button>
                </div>
            </form>

            <form class="form form--danger" method="POST" action="{{ route('products.destroy', $product) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn--danger" type="submit" onclick="return confirm('削除しますか？')">削除</button>
            </form>
        </div>
@endsection