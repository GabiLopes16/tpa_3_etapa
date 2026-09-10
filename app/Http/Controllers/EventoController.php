<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Pergunta;
use App\Http\Requests\StorePerguntaRequest;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::all();
        return view('eventos.index', compact('eventos'));
    }

    /**
     * TICKET #002 & TICKET #004:
     * Adicionado o carregamento ansioso with('user') para resolver o N+1.
     * Mantém os filtros do evento, ordenação decrescente e paginação de 10 em 10.
     */
    public function show($id)
    {
        $evento = Evento::findOrFail($id);

        $perguntas = Pergunta::where('evento_id', $evento->id)
        ->with('user')
        ->latest()
        ->paginate(10);


        return view('eventos.show', compact('evento', 'perguntas'));
    }

    /**
     * TICKET #001 & TICKET #003:
     * Salva a pergunta vinculando ao usuário logado (se houver).
     */
    public function storePergunta(StorePerguntaRequest $request, $id)
    {
        $evento = Evento::findOrFail($id);

        Pergunta::create([
            'evento_id' => $evento->id,
            'user_id'   => auth()->id(), // Vincula a pergunta ao ID do usuário autenticado
            'texto'     => $request->input('texto'),
            'status'    => 'pendente',
        ]);

        return redirect()->route('eventos.show', $evento->id)
            ->with('sucesso', 'Sua pergunta foi enviada com sucesso!');
    }
}
