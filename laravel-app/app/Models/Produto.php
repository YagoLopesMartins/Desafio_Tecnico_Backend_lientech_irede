<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Produto extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nome', 'descricao', 'preco', 'data_validade', 'imagem', 'categoria_id'
    ];

    public function categorias()
    {
        return $this->belongsTo(Categoria::class);
    }
}
