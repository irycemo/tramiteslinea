<div>

    @if(isset($aviso->folio))

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 text-right shadow-lg">

            <span class="bg-blue-400 text-white text-sm rounded-full px-2 py-1">Folio: {{ $aviso->año }}-{{ $aviso->folio }}-{{ $aviso->usuario }}</span>

        </div>

    @endif

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2">

        @if($aviso->archivo()->first())

            <div class="flex justify-center">

                <x-link-blue
                    href="{{ Storage::disk('avisos')->url($aviso->archivo()->first()->url) }}"
                    target="_blank"
                    >
                    Descargar archivo actual
                </x-link-blue>

            </div>

        @endif

        <div class="w-full md:w-1/2 lg:w-1/4 mx-auto items-center text-center">

            <div class="mb-5">

                <x-filepond wire:model.live="documento" accept="['application/pdf']"/>

            </div>

            <div>

                @error('documento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

    </div>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

        <x-input-group for="aviso.observaciones" label="Observaciones generales del aviso" :error="$errors->first('aviso.observaciones')" class="w-full lg:w-1/2 mx-auto">

            <textarea class="bg-white rounded text-xs w-full " rows="4" wire:model="aviso.observaciones"></textarea>

        </x-input-group>

    </div>

    @if(count($errors) > 0)

        <div class="mb-5 bg-white rounded-lg p-2 shadow-lg flex gap-2 flex-wrap ">

            <ul class="flex gap-2 felx flex-wrap list-disc ml-5">
            @foreach ($errors->all() as $error)

                <li class="text-red-500 text-xs md:text-sm ml-5">
                    {{ $error }}
                </li>

            @endforeach

        </ul>

        </div>

    @endif

    @if($aviso->estado === 'nuevo')

        <div class="mb-5 bg-white rounded-lg p-2 shadow-lg flex justify-end items-center gap-3">

            <x-button-green
                wire:click="guardar"
                wire:loading.attr="disabled"
                wire:target="guardar">

                <img wire:loading wire:target="guardar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Guardar

            </x-button-green>

            <x-button-blue
                wire:click="$toggle('modal')"
                wire:loading.attr="disabled"
                wire:target="$toggle('modal')">

                <img wire:loading wire:target="$toggle('modal')" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Cerrar

            </x-button-blue>

        </div>

    @endif

    <x-dialog-modal wire:model="modal" maxWidth="sm">

        <x-slot name="title">

            Cerrar aviso

            {{ $errors }}

        </x-slot>

        <x-slot name="content">

            @if(!$this->aviso->tramite_sgc)

                <div class="flex-auto text-center mb-3">

                    <div >

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Trámite del aviso</Label>

                    </div>

                    <div class="inline-flex">

                        <select class="bg-white rounded-l text-sm border border-r-transparent  focus:ring-0" wire:model="año_tramite">
                            @foreach ($años as $año)

                                <option value="{{ $año }}">{{ $año }}</option>

                            @endforeach
                        </select>

                        <input type="number" class="bg-white text-sm w-20 focus:ring-0 @error('folio_tramite') border-red-500 @enderror" wire:model="folio_tramite">

                        <input type="number" class="bg-white text-sm w-20 border-l-0 rounded-r focus:ring-0 @error('usuario_tramite') border-red-500 @enderror" wire:model="usuario_tramite">

                    </div>

                </div>

            @endif

            @if(!$aviso->aviso_original)

                @if(!$this->aviso->certificado_sgc)

                    <div class="flex-auto text-center mb-3">

                        <div >

                            <Label class="text-base tracking-widest rounded-xl border-gray-500">Trámite del certificado</Label>

                        </div>

                        <div class="inline-flex">

                            <select class="bg-white rounded-l text-sm border border-r-transparent  focus:ring-0" wire:model="año_certificado">
                                @foreach ($años as $año)

                                    <option value="{{ $año }}">{{ $año }}</option>

                                @endforeach
                            </select>

                            <input type="number" class="bg-white text-sm w-20 focus:ring-0 @error('folio_certificado') border-red-500 @enderror" wire:model="folio_certificado">

                            <input type="number" class="bg-white text-sm w-20 border-l-0 rounded-r focus:ring-0 @error('usuario_certificado') border-red-500 @enderror" wire:model="usuario_certificado">

                        </div>

                    </div>

                @endif

                <div class="flex-auto text-center mb-3">

                    <div >

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Folio del avalúo</Label>

                    </div>

                    <div class="inline-flex">

                        <select class="bg-white rounded-l text-sm border border-r-transparent  focus:ring-0" wire:model="año_avaluo">
                            @foreach ($años as $año)

                                <option value="{{ $año }}">{{ $año }}</option>

                            @endforeach
                        </select>

                        <input type="number" class="bg-white text-sm w-20 focus:ring-0 rounded-r @error('folio_avaluo') border-red-500 @enderror" wire:model="folio_avaluo">

                    </div>

                </div>

            @endif

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-blue
                    wire:click="cerrar"
                    wire:loading.attr="disabled"
                    wire:target="cerrar">

                    <img wire:loading wire:target="cerrar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    <span>Cerrar</span>
                </x-button-blue>

                <x-button-red
                    wire:click="$toggle('modal')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modal')">
                    Cancelar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>
