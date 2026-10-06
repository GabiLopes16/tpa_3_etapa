<?php

namespace App\Policies;

use App\Models\Pergunta;
use App\Models\User;

class PerguntaPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pergunta $pergunta): bool
    {
        // Regra original: Permite deletar se o usuário logado for o dono da pergunta 
        // OU se ele for o dono do evento associado a essa pergunta.
        return $user->id === $pergunta->user_id 
            || $user->id === $pergunta->evento->user_id;
    }
}
