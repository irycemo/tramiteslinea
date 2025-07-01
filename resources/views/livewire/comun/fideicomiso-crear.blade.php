<div>

    <div class="mb-2 flex justify-end">

        <x-button-blue wire:click="abrirModal">Agregar actor</x-button-blue>

    </div>

    <x-dialog-modal wire:model="modal">

        <x-slot name="title">Nuevo actor</x-slot>

        <x-slot name="content">

            @if($flag_agregar)

                @include('livewire.comun.modal-content-form')

            @else

                @include('livewire.comun.modal-content-search')

                @include('livewire.comun.modal-content-table')

            @endif

        </x-slot>

        <x-slot name="footer">

            @include('livewire.comun.modal-footer')

        </x-slot>

    </x-dialog-modal>

</div>
