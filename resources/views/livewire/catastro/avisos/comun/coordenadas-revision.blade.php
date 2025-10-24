<div class="space-y-2 mb-5 bg-white rounded-lg p-3 shadow-xl">

    <h4 class="text-lg mb-5 text-center">Coordenadas geografícas</h4>

    <div class="flex-auto ">

        <div class="">

            <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                <div class="text-left">

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">UTM</Label>

                </div>

                <div class="space-y-1">

                    <input placeholder="X" type="text" class="bg-white rounded text-xs lg:w-40 @error('aviso.predio.xutm') border-red-500 @enderror" wire:model.blur="aviso.predio.xutm">

                    <input placeholder="Y" type="text" class="bg-white rounded text-xs lg:w-40 @error('aviso.predio.yutm') border-red-500 @enderror" wire:model.blur="aviso.predio.yutm">

                    <select class="bg-white rounded text-xs lg:w-40" wire:model.blur="aviso.predio.zutm">

                        <option value="" selected>Z</option>
                        <option value="13" selected>13</option>
                        <option value="14" selected>14</option>

                    </select>

                    <input placeholder="Norte" type="text" class="bg-white rounded text-xs lg:w-40" readonly>

                </div>

            </div>

        </div>

        <div class="">

            <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                <div class="text-left">

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">GEO</Label>

                </div>

                <div class="space-y-1">

                    <input placeholder="Lat" type="number" class="bg-white rounded text-xs lg:w-40 @error('aviso.predio.lat') border-red-500 @enderror" wire:model.blur="aviso.predio.lat">

                    <input placeholder="Lon" type="number" class="bg-white rounded text-xs lg:w-40 @error('aviso.predio.lon') border-red-500 @enderror" wire:model.blur="aviso.predio.lon">

                </div>

                <button
                    wire:click="resetearCoordenadas"
                    wire:loading.attr="disabled"
                    wire:target="resetearCoordenadas"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>

                </button>

            </div>

        </div>

    </div>

</div>