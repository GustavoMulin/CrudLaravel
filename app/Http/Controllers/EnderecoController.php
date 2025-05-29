<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Endereco::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validação de dados
            $validated = $request->validate([
                'rua' => 'required|string|max:255',
                'cidade' => 'required|string|max:100',
                'estado' => 'required|string|max:100',
                'cep' => 'required|string|max:20',
                'cliente_id' => 'required|exists:clientes,id'
            ],

            // Mensagens de Erro
            [
                'rua.required' => 'A rua é obrigatório', 
                'cidade.required' => 'A cidade é obrigatório', 
                'estado.required' => 'O estado é obrigatório', 
                'cep.required' => 'O cep é obrigatório', 
                'cliente_id.required' => 'O cliente é obrigatório'
            ]);

            // Criar Endereço
            $endereco = Endereco::create($validated);

            // Retornar resposta de sucesso
            return response()->json([
                'message' => 'Endereço criado com sucesso',
                'data' => $endereco
            ], 201);

        } catch (\Exception $e) {
            // Retornar mensagem de Erro
            return response()->json([
                'message' => 'Erro ao criar o Endereço!',
                'data' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $endereco = Endereco::with('clientes')->where('id', $id)->first();

            // Verificar se existe o ID do Endereço
            if(!$endereco) {
                return response()->json([
                    'message' => 'Endereço não encontrado'
                ], 404);
            }

            // Retornar mensagem de sucesso ao encontrar o Endereço
            return response()->json([
                'message' => 'Endereço encontrado com sucesso',
                'data' => $endereco
            ], 200);

        } catch (\Exception $e) {
            // Retornar Erro
            return response()->json([
                'message' => 'Erro ao buscar o Endereço!',
                'data' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $endereco = Endereco::find($id);

        if (!$endereco) {
            return response()->json(['message' => 'Endereço não encontrado'], 404);
        }

        $endereco->update($request->validate([
            'rua' => 'required|string|max:255',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|max:100',
            'cep' => 'required|string|max:20',
            'cliente_id' => 'required|exists:clientes,id'
        ]));

        return response()->json($endereco);
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
    {
        $endereco = Endereco::find($id);

        if (!$endereco) {
            return response()->json(['message' => 'Endereço não encontrado'], 404);
        }

        $endereco->delete();

        return response()->json(['message' => 'Endereço deletado com sucesso']);
    }

}
