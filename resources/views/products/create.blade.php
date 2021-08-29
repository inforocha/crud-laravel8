@extends('layouts.main')

@section('title', 'produtos - form')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<a href="{{ route('home')}}">ir para home</a>
			<a href="{{ route('product.index') }}">ir para produtos</a>
			<h1>Produtos - formalário</h1>
		</div>
		@include('layouts.objectErrors')
		<div class="col-md-12">
			<form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
				@include('products._partials.form')
			</form>
		</div>
	</div>
@endsection