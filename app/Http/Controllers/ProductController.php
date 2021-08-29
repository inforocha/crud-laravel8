<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller {
    private $paginateQtyPerPage = 3;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        // $products = Product::All(); // retorna todos
        $products = Product::orderBy('name','ASC')
            ->paginate($this->paginateQtyPerPage); // default da paginacao sao 15 registros.

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $product = new Product;
        return view('products.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateProduct $request) {
        $data = $request->all();
        $product = new Product;

        if($request->has('image') && $request->image->isValid()) {
            $imageName = Str::of($request->name)->slug('-').'.'.$request->image->getClientOriginalExtension();
            $product->image = $request->image->storeAs('products', $imageName);
        }

        // if($request->filled('id')) $product->name = $request->id;
        $product->name = $request->name;
        $product->qty = $request->qty;
        $product->save();

        return redirect()
            ->route('product.index')
            ->with('msg_success', 'Produto criado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        // $product = Product::findOrFail($id); // dessa forma ja manda pra 404
        if(!$product = Product::find($id)) {
            return redirect()
                ->route('product.index')
                ->with('msg_info', 'Produto não existe.');
        }
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        // $product = Product::findOrFail($id); // dessa forma ja manda pra 404
        if(!$product = Product::find($id)) {
            return redirect()
                ->route('product.index')
                ->with('msg_info', 'Produto não existe.');
        }
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateProduct $request, $id) {
        try {
            if(!$product = Product::find($id)) {
                return redirect()
                    ->route('product.index')
                    ->with('msg_info', 'Produto não existe.');
            }

            if($request->has('image') && $request->image->isValid()) {
                if(Storage::exists($product->image)) {
                    Storage::delete($product->image);
                }

                $imageName = Str::of($request->name)->slug('-').'.'.$request->image->getClientOriginalExtension();
                $product->image = $request->image->storeAs('products', $imageName);
            }
            $product->name = $request->name;
            $product->qty = $request->qty;
            $product->save();
            // $product->update($request->except('_token', '_method', 'id')); // nesse caso os campos que serao inseridos devem ser fillable

            return redirect()
                ->route('product.index')
                ->with('msg_success', 'Produto atualizado com sucesso.');
        } catch (Exception $e) {
            return redirect()
                ->route('product.index')
                ->with('msg_error', 'Erro inesperado ao tentar deletar o Produto!');            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // $product = Product::findOrFail($id)->delete(); // dessa forma ele gera erro 404 caso o registro nao exista
        if(!$product = Product::find($id)) {
            return redirect()
                ->route('product.index')
                ->with('msg_info', 'Produto não existe.');
        }

        if(Storage::exists($product->image)) {
            Storage::delete($product->image);
        }
        $product->delete();

        return redirect()
            ->route('product.index')
            ->with('msg_success', 'Produto excluido com sucesso.');
    }

    public function search(Request $request) {
        $filters = $request->only('search');
        $search = $request->search;
        $products = Product::where('name', 'like', "%{$search}%")
            ->orWhere('qty', (int) $search)
            ->paginate($this->paginateQtyPerPage);
            // ->toSql(); // debugar a consulta
        // dd($products); // debugando o retorno da consulta
        return view('products.index', compact('products', 'filters'));
    }
}
