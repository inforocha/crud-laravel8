@extends('layouts.main')

@section('title', 'Produtos')

@section('content')
	<a href="{{ route('home') }}">ir para home</a>
	<h1>Produtos</h1>
	<p><a href="{{ route('product.create') }}" class="btn btn-info pull-right">cadastrar novo</a></p>
	<div class="row">
		<form action="{{ route('product.search') }}" method="post">
			@csrf
			<div class="form-group col-md-8 col-sm-8 col-lg-8">
				<input type="text" name="search" class="form-control" placeholder="Digite o que deseja buscar">
			</div>
			<div class="form-group col-sm-2 col-md-2 col-lg-2">
				<input type="submit" class="btn btn-success" value="Buscar">
			</div>
		</form>
	</div>
    <div class="row">
		@if(!count($products))
			<h4>Nenhum produto cadastrado</h4>
		@else
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Img</th>
						<th>Qtd</th>
						<th>Produto</th>
						<th>Dt criação</th>
						<th>Dt atualizaão</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
					@foreach($products as $product)
					<tr>
						<td>{{ $product->id }}</td>
						<td><img src="{{ url("storage/{$product->image}") }}" alt="{{ $product->name }}" style="max-width:100px"></td>
						<td>{{ $product->qty }}</td>
						<td>{{ $product->name }}</td>
						<td>{{ \Carbon\Carbon::parse($product->created_at)->format('d/m/Y') }}</td>
						<td>{{ \Carbon\Carbon::parse($product->updated_at)->format('d/m/Y') }}</td>
						<td>
							<div class="col-lg-12 col-md-12">
								<div class="col-lg-4 col-md-4">
									<a href="{{ route('product.edit', $product->id) }}" class="btn btn-info btn-sm">editar2</a>&nbsp;
								</div>
								<div class="col-lg-4 col-md-4">
									<a href="{{ route('product.show', $product->id) }}" class="btn btn-success btn-sm">ver2</a>&nbsp;
								</div>
								<div class="col-lg-4 col-md-4">
									<form action="{{ route('product.destroy', $product->id) }}" method="post">
										@csrf
										@method('DELETE')
										<button class="btn btn-danger btn-sm" type="submit">excluir</button>
									</form>
								</div>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		@endif
    </div>
	<hr>
	@if(isset($filters))
		{{ $products->appends($filters)->links() }}
	@else
		{{ $products->links() }}
	@endif
@endsection