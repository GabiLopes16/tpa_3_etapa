<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pergunta extends Model
{
    use HasFactory;

    // Adicionado 'user_id' aqui para permitir o cadastro do autor
    protected $fillable = ['evento_id', 'user_id', 'texto', 'status'];

    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }

    // NOVA FUNÇÃO DO TICKET #003:
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
