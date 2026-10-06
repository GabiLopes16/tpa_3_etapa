@extends('layouts.app')

@section('title', $evento->titulo . ' — FalaQ')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-10">

    @if(session('sucesso'))
        <div class="mb-6 flex items-center gap-3 bg-green-500/10 border border-green-500/30 text-green-400 px-5 py-4 rounded-xl">
            <span class="text-xl">✓</span>
            <span class="font-medium">{{ session('sucesso') }}</span>
        </div>
    @endif

    {{-- CABEÇALHO DO EVENTO --}}
    <div class="mb-8">

        <div class="flex items-center gap-2 mb-3">
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">
                EVENTO
            </span>
        </div>

        <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">
            {{ $evento->titulo }}
        </h1>

        <p class="text-gray-400 text-base">
            Participe do evento e envie sua pergunta para o palestrante.
        </p>

    </div>


    {{-- CONTEÚDO PRINCIPAL --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

        {{-- FORMULÁRIO --}}
        <div class="lg:col-span-2">

            <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-xl overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-800">

                    <div class="flex items-center gap-3">

                        <div class="w-11 h-11 rounded-xl bg-blue-600/20 flex items-center justify-center">
                            <span class="text-2xl">💬</span>
                        </div>

                        <div>
                            <h2 class="text-lg font-bold text-white">
                                Faça sua pergunta
                            </h2>

                            <p class="text-sm text-gray-500">
                                Participe da conversa
                            </p>
                        </div>

                    </div>

                </div>


                <div class="p-6">

                    <form
                        action="{{ route('eventos.perguntas.store', $evento->id) }}"
                        method="POST"
                    >

                        @csrf

                        <input
                            type="hidden"
                            name="evento_id"
                            value="{{ $evento->id }}"
                        >

                        <div class="mb-5">

                            <label
                                for="texto"
                                class="block text-sm font-semibold text-gray-300 mb-2"
                            >
                                Sua pergunta
                            </label>

                            {{-- TEXTAREA ALTERADO --}}
                            <textarea
                                name="texto"
                                id="texto"
                                rows="7"
                                maxlength="255"
                                placeholder="Digite sua dúvida ou comentário para o palestrante..."
                                class="w-full !bg-gray-800 !text-white placeholder-gray-400 border border-gray-700 rounded-xl px-4 py-4 resize-none outline-none transition focus:!border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                            >{{ old('texto') }}</textarea>

                            @error('texto')
                                <div class="flex items-center gap-2 mt-2 text-red-400 text-sm">
                                    <span>⚠</span>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror

                            <div class="flex justify-between mt-2">

                                <span class="text-xs text-gray-500">
                                    Mínimo de 10 caracteres
                                </span>

                                <span class="text-xs text-gray-500">
                                    Máximo de 255
                                </span>

                            </div>

                        </div>


                        <button
                            type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-3 px-5 rounded-xl transition duration-200 shadow-lg shadow-blue-900/20"
                        >
                            <span>Enviar pergunta</span>
                            <span>🚀</span>
                        </button>

                    </form>

                </div>

            </div>

        </div>


        {{-- MURAL DE PERGUNTAS --}}
        <div class="lg:col-span-3">

            <div class="flex items-center justify-between mb-5">

                <div>

                    <div class="flex items-center gap-2">

                        <span class="text-2xl">📋</span>
            {{-- Início da Listagem de Perguntas --}}
            <div class="space-y-4">

                @forelse($perguntas as $pergunta)

                    {{-- CARD DA PERGUNTA --}}
                    <div class="ml-3 bg-blue-50 border border-blue-100 rounded-2xl p-5 shadow-sm transition duration-200 hover:bg-blue-100 hover:shadow-md">

                        <div class="flex gap-4">

                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-blue-100 border border-blue-200 flex items-center justify-center">
                                    <span class="text-lg">💬</span>
                                </div>
                            </div>

                            <div class="flex-1 min-w-0">

                                <p class="text-gray-800 leading-relaxed text-base mb-4">
                                    {{ $pergunta->texto }}
                                </p>

                                <div class="flex flex-wrap items-center gap-3">

                                    <span class="text-sm text-gray-500">
                                        Por: <span class="text-gray-700 font-medium">Anônimo</span>
                                    </span>

                                    <span class="text-gray-300">•</span>

                                    <span class="text-xs text-gray-500">
                                        {{ $pergunta->created_at->format('d/m/Y H:i') }}
                                    </span>

                                    <div class="ml-auto flex items-center gap-2">

                                        <span class="inline-flex items-center gap-1.5 bg-green-100 border border-green-200 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                            {{ $pergunta->status }}
                                        </span>

                                        {{-- Ticket 4: Botão de exclusão protegido pela Policy --}}
                                        @can('delete', $pergunta)
                                            <form action="{{ route('perguntas.destroy', $pergunta) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja deletar esta pergunta?');">
                                                @csrf
                                                @method('DELETE')
                                                
                                                <button type="submit" class="inline-flex items-center px-4 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-full transition duration-150 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                    Excluir
                                                </button>
                                            </form>
                                        @endcan

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div> {{-- Fim do Card da Pergunta --}}

                @empty

                    <div class="bg-gray-900 border border-gray-800 border-dashed rounded-2xl p-10 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-blue-600/10 flex items-center justify-center">
                            <span class="text-3xl">💭</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-300 mb-2">Nenhuma pergunta ainda</h3>
                        <p class="text-sm text-gray-500 max-w-sm mx-auto">
                            Seja a primeira pessoa a enviar uma pergunta para este evento!
                        </p>
                    </div>

                @endforelse

            </div> {{-- Fim do bloco space-y-4 --}}


            {{-- Paginação externa e isolada --}}
            @if($perguntas->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $perguntas->links() }}
                </div>
            @endif

        </div> {{-- Fecha o container principal da página --}}
    </div>
</div>

@endsection
