<div>

    <x-header>

         @if($aviso?->aviso_original)
            Aviso aclaratorio
        @else
            Aviso
        @endif

    </x-header>

    <div class="tab-wrapper max-h-full" x-data="{ activeTab: 0 }">

        <div class="flex py-4 space-x-4 items-center border-b-2 border-gray-500 mb-6 flex-wrap justify-center">

            <label
                @click="activeTab = 0"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 0 }"
            >Acto / Escritura
            </label>

            <label
                @click="activeTab = 1"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 1 }"
            >Identificación del inmueble
            </label>

            <label
                @click="activeTab = 2"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 2 }"
            >Transmitentes
            </label>

            <label
                @click="activeTab = 3"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 3 }"
            >Adquirientes
            </label>

            <label
                @click="activeTab = 4"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 4 }"
            >Antecedentes
            </label>

            <label
                @click="activeTab = 5"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 5 }"
            >Fideicomisos
            </label>

            <label
                @click="activeTab = 6"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 6 }"
            >ISAI
            </label>

            <label
                @click="activeTab = 7"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 7 }"
            >Archivo
            </label>

        </div>

        <div class="tab-panel" :class="{ 'active': activeTab === 0 }" x-show.transition.in.opacity.duration.800="activeTab === 0"  wire:key="tab-0">

           @livewire('usuarios.aviso.acto-escritura', ['avisoId' => $aviso?->id])

        </div>

        <div x-cloak class="tab-panel" :class="{ 'active': activeTab === 1 }" x-show.transition.in.opacity.duration.800="activeTab === 1"  wire:key="tab-1">

            @livewire('usuarios.aviso.identificacion-inmueble', ['avisoId' => $aviso?->id])

        </div>

        <div x-cloak class="tab-panel" :class="{ 'active': activeTab === 2 }" x-show.transition.in.opacity.duration.800="activeTab === 2"  wire:key="tab-2">

            @livewire('usuarios.aviso.transmitentes', ['avisoId' => $aviso?->id])

        </div>

        <div x-cloak class="tab-panel" :class="{ 'active': activeTab === 3 }" x-show.transition.in.opacity.duration.800="activeTab === 3"  wire:key="tab-3">

            @livewire('usuarios.aviso.adquirientes', ['avisoId' => $aviso?->id])

         </div>

         <div x-cloak class="tab-panel" :class="{ 'active': activeTab === 4 }" x-show.transition.in.opacity.duration.800="activeTab === 4"  wire:key="tab-4">

            @livewire('usuarios.aviso.antecedentes', ['avisoId' => $aviso?->id])

         </div>

         <div x-cloak class="tab-panel" :class="{ 'active': activeTab === 5 }" x-show.transition.in.opacity.duration.800="activeTab === 5"  wire:key="tab-5">

            @livewire('usuarios.aviso.fideicomisos', ['avisoId' => $aviso?->id])

         </div>

         <div x-cloak class="tab-panel" :class="{ 'active': activeTab === 6 }" x-show.transition.in.opacity.duration.800="activeTab === 6"  wire:key="tab-6">

            @livewire('usuarios.aviso.isai', ['avisoId' => $aviso?->id])

         </div>

         <div x-cloak class="tab-panel" :class="{ 'active': activeTab === 7 }" x-show.transition.in.opacity.duration.800="activeTab === 7"  wire:key="tab-7">

            @livewire('usuarios.aviso.archivo', ['avisoId' => $aviso?->id])

         </div>

    </div>

</div>
