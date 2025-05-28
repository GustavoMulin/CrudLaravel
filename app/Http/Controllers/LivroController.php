<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Livro::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validação de Dados
            $validated = $request->validate([
                'titulo' => 'required|string|max:255',
                'paginas' => 'required|integer|min:1',
                'autor_id' => 'required|exists:autors,id'
            ],

            // Mensagens de Erro
            [
                'titulo.required' => 'O título do livro é obrigatório!',
                'paginas.required' => 'O número de páginas é obrigatório!',
                'paginas.integer' => 'As páginas dever ser um número inteiro!',
                'paginas.min' => 'O livro deve no mínimo ter 1 página.',
                'autor_id.required' => 'O autor é obrigatório!',
                'autor_id.exists' => 'Autor não encontrado.'
            ]);

            // Criar livro
            $livro = Livro::create($validated);

            // Retornar Resposta de sucesso
            return response()->json([
                'message' => 'Livro criado com sucesso',
                'data' => $livro
            ], 201);

        } catch (\Exception $e) {
            // Retornar mensagem de erro
            return response()->json([
                'message' => 'Erro ao criar o livro',
                'erro' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
public function show($id)
{
    try {
        $livro = Livro::with('autor')->where('id', $id)->first();

        if (!$livro) {
            return response()->json([
                'message' => 'livro não encontrado.'
            ], 404);
        }

        return response()->json([
            'message' => 'livro encontrado com sucesso!',
            'data' => $livro
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Erro ao buscar o livro.',
            'error' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Livro $livro)
    {
        $livro->update($request->validated());
        
        return response()->json([
            'message' => 'Livro autualizado com sucesso.',
            'data' => $livro
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Livro $livro)
    {
        $livro->delete();

        return response()->json([
            'message' => 'Livro deletedao com sucessco'
        ]);
    }
}
