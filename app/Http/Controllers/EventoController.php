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
     * TICKET #002, TICKET #004 & TICKET #006:
     * Adicionado o filtro where('is_public', true), Eager Loading with('user'), 
     * ordenação decrescente e paginação de 10 em 10.
     */
    public function show($id)
    {
        $evento = Evento::findOrFail($id);

        $perguntas = Pergunta::where('evento_id', $evento->id)
            ->where('is_public', true)
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('eventos.show', compact('evento', 'perguntas'));
    }

    /**
     * TICKET #001 & TICKET #003:
     * Salva a pergunta vinculando ao usuário logado.
     */
    public function storePergunta(StorePerguntaRequest $request, $id)
    {
        $evento = Evento::findOrFail($id);

        Pergunta::create([
            'evento_id' => $evento->id,
            'user_id'   => auth()->id(),
            'texto'     => $request->input('texto'),
            'status'    => 'pendente',
        ]);

        return redirect()->route('eventos.show', $evento->id)
            ->with('sucesso', 'Sua pergunta foi enviada com sucesso!');
    }
}