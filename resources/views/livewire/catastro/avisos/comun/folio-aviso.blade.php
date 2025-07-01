@if(isset($aviso->folio))

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2 text-right shadow-lg">

        <span class="bg-blue-400 text-white text-sm rounded-full px-2 py-1">Folio: {{ $aviso->año }}-{{ $aviso->folio }}-{{ $aviso->usuario }}</span>

    </div>

@endif