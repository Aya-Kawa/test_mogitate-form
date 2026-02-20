@extends('layouts.app')

@section('title', '商品登録')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')
    <div class="formpage">
        <h1 class="formtitle">商品登録</h1>

        <form class="form" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="field">
                <label class="label">商品名</label>
                <input class="input input--wide" type="text" name="name" value="{{ old('name') }}">

                @foreach($errors->get('name') as $msg)
                    <div class="error">{{ $msg }}</div>
                @endforeach

            </div>

            <div class="field">
                <label class="label">値段</label>
                <input class="input input--wide" type="text" name="price" value="{{ old('price') }}">

                @foreach($errors->get('price') as $msg)
                    <div class="error">{{ $msg }}</div>
                @endforeach

            </div>

            <div class="field">
                <label class="label">季節</label>

                @php
                    $selected = old('seasons', []);
                    $seasonsSafe = $seasons ?? collect();
                 @endphp

                <div class="checks">
                    @foreach($seasonsSafe as $season)
                        <label class="check">
                            <input type="checkbox" name="seasons[]" value="{{ $season->id }}" {{ in_array($season->id, $selected) ? 'checked' : '' }}>
                            <span>{{ $season->name }}</span>
                        </label>
                    @endforeach
                </div>

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
                <label class="label">商品画像（png / jpeg）</label>
                <input class="input input--wide" type="file" name="image" accept=".png,.jpeg,.jpg">
                @foreach($errors->get('image') as $msg)
                    <div class="error">{{ $msg }}</div>
                @endforeach
            </div>

            <div class="field">
                <label class="label">商品説明</label>
                <textarea class="textarea" name="description">{{ old('description') }}</textarea>
                @foreach($errors->get('description') as $msg)
                    <div class="error">{{ $msg }}</div>
                @endforeach
            </div>

            <div class="actions">
                <a class="btn btn--ghost" href="/products">戻る</a>
                <button class="btn btn--accent" type="submit">登録</button>
            </div>
        </form>
    </div>
@endsection