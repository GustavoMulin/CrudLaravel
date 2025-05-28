<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Recupera todos os autores do banco de dados
        return Autor::all();
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
                'nacionalidade' => 'required|string|max:255'
            ],
        
            // Mensagem de Erro
            [
                'name.required' => 'O nome do autor e obrigatório!',
                'nacionalidade.required' => 'A nacionalidade é obrigatório'
            ]);

            // Criar autor
            $autor = Autor::create($validated);

            // Retornar resposta de sucesso
            return response()->json([
                'message' => 'Autor criado com sucesso',
                'data' => $autor
            ], 201);
            
        } catch (\Exception $e) {
            // Retornar Erro
            return response()->json([
                'message' => 'Erro ao criar o usuário',
                'erro' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
 public function show($id)
{
    try {
        $autor = Autor::with('livros')->findOrFail($id);

        return response()->json([
            'message' => 'Autor encontrado com sucesso!',
            'data' => $autor
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Autor não encontrado.',
            'error' => $e->getMessage()
        ], 404);
    }
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Autor $autor)
    {
        $autor->update($request->Validated());

        return response()->json([
            'message' => 'Autor atualizado com sucesso',
            'data' => $autor
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Autor $autor)
    {
        $autor->delete();

        return response()->json([
            'message' => 'Autor deletado com sucesso'
        ]);
    }
}
