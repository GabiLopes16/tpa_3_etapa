<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Pergunta;
use App\Http\Requests\StorePerguntaRequest;
use Illuminate\Support\Facades\Gate; // Importação necessária para a proteção

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::all();

        return view('eventos.index', compact('eventos'));
    }

    public function show(string $id)
    {
        $evento = Evento::findOrFail($id);

        $perguntas = Pergunta::where('evento_id', $evento->id)
            ->latest()
            ->paginate(10);

        return view('eventos.show', compact('evento', 'perguntas'));
    }

    public function storePergunta(StorePerguntaRequest $request, string $id)
    {
        $evento = Evento::findOrFail($id);

        Pergunta::create([
            'evento_id' => $evento->id,
            'texto'     => $request->input('texto'),
            'status'    => 'pendente',
            'is_public' => true,
        ]);

        return redirect()
            ->route('eventos.show', $evento->id)
            ->with('sucesso', 'Sua pergunta foi enviada com sucesso!');
    }

    /**
     * Remove a pergunta especificada do banco de dados.
     * (Ticket 3)
     */
    public function destroyPergunta(Pergunta $pergunta)
    {
        // Protege o Back-end usando a Facade Gate (Evita o erro de método indefinido)
        Gate::authorize('delete', $pergunta);

        // Se autorizado, deleta do banco
        $pergunta->delete();

        // Redireciona de volta com mensagem de sucesso
        return redirect()
            ->back()
            ->with('sucesso', 'Pergunta excluída com sucesso!');
    }
}
