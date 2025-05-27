<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Valadição dos dados
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8'
            ],
        
            // Mensagens de Erros
            [
                'name.required' => 'O campo nome é obrigatório!',
                'email.required' => 'O campo e-mail é obrigatório!',
                'email.email' => 'Informe um e-mail válido!',
                'email.unique' => 'Este e-mail já está cadastrado!',
                'password.required' => 'O campo senha é obrigatório!',
                'password.min' => 'A senha deve ter pelo menos :min caracteres!'
            ]);

            // Criar usuário
            $user = User::create($validated);

            // Retornar respostar de sucesso
            return response()->json([
                'message' => 'Usuário criado com sucesso',
                'data' => $user
            ], 201);

        } catch (\Exception $e) {
            // Retornar erro genérico
            return response()->json([
                'message' => 'Erro ao criar usuário',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
