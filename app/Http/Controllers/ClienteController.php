<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Cliente::all());
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validação de dados
            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|email|unique:clientes,email',
                'telefone' => 'nullable|string|max:20'
            ],
            
            // Mensagens de Erro
            [
                'nome.required' => 'O nome é obrigatório',
                'email.required' => 'O email é obrigatório',
                'telefone.nullable' => 'O telefone é obrigatório'
            ]);

            // Criar cliente
            $cliente = Cliente::create($validated);

            // Retornar resposta de sucesso
            return response()->json([
                'message' => 'Cliente criado com sucesso',
                'data' => $cliente
            ], 201);

        } catch (\Exception $e) {
            // Retornar mensagem de Erro
            return response()->json([
                'message' => 'Erro ao criar o cliente',
                'erro' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Procurar pelo ID
        try {
            $cliente = Cliente::with('enderecos')->where('id', $id)->first();

            // Verificar se existe o ID do cliente
            if(!$cliente) {
                return response()->json([
                    'message' => 'Cliente não encontrado'
                ], 404);
            }

            // Retornar mensagem de sucesso ao encontrar o livro
            return response()->json([
                'message' => 'Cliente encontrado com sucesso',
                'data' => $cliente
            ], 200);

        } catch (\Exception $e) {
            // Retornar erro
            return response()->json([
                'message' => 'Erro ao buscar o livro',
                'data' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        $cliente->update($request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email,'.$id,
            'telefone' => 'nullable|string|max:20'
        ]));

        return response()->json($cliente);
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        $cliente->delete();

        return response()->json(['message' => 'Cliente deletado com sucesso']);
    }
}
