@extends('layouts.main')

@section('title', 'Produtos')

@section('content')
	<a href="{{ route('home') }}">ir para home</a>
	<a href="{{ route('product.index') }}">ir para produtos</a>
	<h1>Produto - visualização</h1>
    <div class="col-md-12 collg-12">
    	<p><img src="{{ url("storage/{$product->image}") }}" alt="Imagem do produto {{ $product->name }}" style="max-width:300px;"></p>
    	<p>NOME:{{ $product->name }}</p>
    	<p>QUANTIDADE: {{ $product->qty }}</p>
    </div>
@endsection
