@csrf
<input type="hidden" name="id" value="{{ $product->id ?? old('id')}}">
<idv class="form-group">
	<label>Imagem</label>
	<input type="file" name="image">
</idv>
<div class="form-group">
	<label>Nome do produto</label>
	<input type="text" name="name" value="{{ $product->name ?? old('name') }}" class="form-control">
</div>
<div class="form-group">
	<label>Qtd do produto</label>
	<input type="number" name="qty" value="{{ $product->qty ?? old('qty') }}" class="form-control">
</div>
<input type="submit" value="Salvar" class="btn btn-info">