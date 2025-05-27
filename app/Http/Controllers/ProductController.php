<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Listar todos
        return response()->json(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validação de dados
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'categoria' => 'required|string|nullable',
                'preco' => 'required|numeric|min:0',
            ],

            [
                // Mensagens de Erro
                'name.required' => 'O campo nome é obrigatório',
                'categoria.required' => 'Informa a categoria (ex: "Eletrônicos", "Roupas", "Livros")',
                'preco.required' => 'O campo preço é obrigatório',
                'preco.numeric' => 'O preço deve ser um número',
                'preco.min' => 'O preço não pode ser negativo'
            ]    
        );

        // Criar produto
        $product = Product::create($validated);

        // Retornar as respostas de sucesso
        return response()->json([
            'message' => 'Produto criado com sucesso',
            'data' => $product
        ], 201);

        } catch (\Exception $e) {
            // Retornar mensagem de erro
            return response()->json([
                'message' => 'Erro ao criar o produto',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->validated());

        return response()->json([
            'message' => 'Produto atualizado com sucesso',
            'data' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Produto deletado com sucesso'
        ]);
    }
}
