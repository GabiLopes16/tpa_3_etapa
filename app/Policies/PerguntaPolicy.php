<?php

namespace App\Policies;

use App\Models\Pergunta;
use App\Models\User;

class PerguntaPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Pergunta $pergunta): bool
    {
        // Retorna true temporariamente para forçar o botão a aparecer na tela para testes
        return true;
    }
}
