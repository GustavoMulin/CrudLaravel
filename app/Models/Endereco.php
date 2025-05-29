<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'rua',
        'cidade',
        'estado',
        'cep',
        'cliente_id'
    ];

    public function clientes()
    {
        return $this->belongsTo(Cliente::class);
    }
}
