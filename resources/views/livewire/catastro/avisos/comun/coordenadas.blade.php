<div class="space-y-2 mb-5 bg-white rounded-lg p-3 shadow-xl">

    <h4 class="text-lg mb-5 text-center">Coordenadas geografícas</h4>

    <div class="flex-auto ">

        <div class="">

            <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                <div class="text-left">

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">UTM</Label>

                </div>

                <div class="space-y-1">

                    <input placeholder="X" type="text" class="bg-white rounded text-xs lg:w-40" value="{{ $aviso->predio->xutm }}" readonly>

                    <input placeholder="Y" type="text" class="bg-white rounded text-xs lg:w-40" value="{{ $aviso->predio->yutm }}" readonly>

                    <input placeholder="Z" type="text" class="bg-white rounded text-xs lg:w-40" value="{{ $aviso->predio->zutm }}" readonly>

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

                    <input placeholder="Lat" type="number" class="bg-white rounded text-xs lg:w-40" value="{{ $aviso->predio->lat }}" readonly>

                    <input placeholder="Lon" type="number" class="bg-white rounded text-xs lg:w-40" value="{{ $aviso->predio->lon }}" readonly>

                </div>

            </div>

        </div>

    </div>

</div>