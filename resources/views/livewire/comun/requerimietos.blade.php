<div class="">

    <x-header>Requermientos</x-header>

    <div class="">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 ">

            <div class="lg:col-span-3 bg-white rounded-lg p-4 shadow-xl overflow-auto h-menu2">

                @forelse ($requerimientos as $requerimiento)

                    <div
                        wire:click="verRequerimiento({{ json_encode($requerimiento) }})"
                        wire:loading.attr="disabled"
                        class="border-gray-200 rounded-lg p-2 mb-2 cursor-pointer hover:shadow-md border @if($requerimiento['estado'] == 'finalizado') bg-gray-50 @else  bg-blue-50 @endif">

                        <div class="text-sm">
                            {{ $requerimiento['descripcion'] }}
                        </div>

                        <div class="text-xs text-right">

                            <div>

                                @if($requerimiento['usuario_stl'])

                                    <p>{{ $requerimiento['usuario_stl'] }}</p>

                                @else

                                    <p>{{ $requerimiento['creado_por'] }}</p>

                                @endif

                                <p>{{ $requerimiento['created_at'] }}</p>

                            </div>

                        </div>

                    </div>

                @empty

                @endforelse

            </div>

            <div class="lg:col-span-6 bg-white rounded-lg p-4 shadow-xl overflow-auto h-menu2">

                @if($requerimiento_seleccionado)

                    <div class="border-gray-200 rounded-lg p-2 mb-2 border ">

                        <div class="text-sm">
                            {{ $requerimiento_seleccionado['descripcion'] }}
                        </div>

                        <div class="text-xs text-right">

                            <div>

                                @if(isset($requerimiento_seleccionado['archivo_url']))

                                    <a class="text-blue-600 underline" href="{{ $requerimiento_seleccionado['archivo_url'] }}" target="_blank">Archivo</a>

                                @endif

                            </div>

                            <div>

                                @if($requerimiento_seleccionado['usuario_stl'])

                                    <p>{{ $requerimiento_seleccionado['usuario_stl'] }}</p>

                                @else

                                    <p>{{ $requerimiento_seleccionado['creado_por'] }}</p>

                                @endif

                                <p>{{ $requerimiento_seleccionado['created_at'] }}</p>

                            </div>

                        </div>

                    </div>

                @endif

                <div class="">

                    @forelse ($respuestas as $respuesta)

                        <div class="bg-gray-100 rounded-lg p-2 mb-2">

                            <div>
                                {{ $respuesta['descripcion'] }}
                            </div>

                            <div class="text-xs text-right">

                                <div>

                                    @if(isset($respuesta['archivo_url']))

                                        <a class="text-blue-600 underline" href="{{ $respuesta['archivo_url'] }}" target="_blank">Archivo</a>

                                    @endif

                                </div>

                                <div>

                                    @if($respuesta['usuario_stl'])

                                        <p>{{ $respuesta['usuario_stl'] }}</p>

                                    @else

                                        <p>{{ $respuesta['creado_por'] }}</p>

                                    @endif

                                    <p>{{ $respuesta['created_at'] }}</p>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div>
                            <p class="text-center tracking-widest p-8">Sin respuesta</p>
                        </div>

                    @endforelse

                </div>

            </div>

            <div class="lg:col-span-3 bg-white rounded-lg p-4 shadow-xl h-menu2">

                <div class="flex justify-end mb-3">

                    <span
                        class="text-blue-400 cursor-pointer"
                        wire:click="resetRequerimientos"
                        wire:loading.attr="disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </span>

                </div>

                @if($requerimiento_seleccionado)

                    <p class="tracking-widest text-center mb-5">Responder</p>

                @else

                    <p class="tracking-widest text-center mb-5">Generar nuevo requerimiento</p>

                @endif

                <x-input-group for="observacion" label="Observación" :error="$errors->first('observacion')">

                    <textarea class="bg-white rounded text-xs w-full " rows="4" wire:model="observacion" placeholder="Se lo más especifico sobre la corrección que solicitas"></textarea>

                </x-input-group>

                <div>

                    <div>

                        <x-filepond wire:model.live="documento" accept="['application/pdf']"/>

                    </div>

                    <div>

                        @error('documento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="py-5">

                    @if($requerimiento_seleccionado)

                        <x-button-blue
                            wire:click="responderRequerimiento"
                            wire:loading.attr="disabled"
                            wire:target="responderRequerimiento"
                            class="inline-block w-full">
                            Responder
                        </x-button-blue>

                    @else

                        <x-button-blue
                            wire:click="hacerRequerimiento"
                            wire:loading.attr="disabled"
                            wire:target="hacerRequerimiento"
                            class="inline-block w-full">
                            Requerir
                        </x-button-blue>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>
