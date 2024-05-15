<div x-data="{openRoles:true, openDistritos:true}">

    <p class="uppercase text-md text-rojo mb-4 tracking-wider">RPP</p>

    @can('Avisos')

        @can('Trámite nuevo rpp')

            <a href="{{ route('tramite_nuevo_rpp') }}" class="mb-3 capitalize font-medium text-md hover:text-red-600 transition ease-in-out duration-500 flex items-center hover  hover:bg-gray-100 p-2 px-4 rounded-xl focus:outline-rojo focus:outline-offset-2 w-full">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>

                Nuevo Trámite
            </a>

        @endcan

        @can('Trámites rpp')

            <a href="{{ route('tramites_rpp') }}" class="mb-3 capitalize font-medium text-md hover:text-red-600 transition ease-in-out duration-500 flex items-center hover  hover:bg-gray-100 p-2 px-4 rounded-xl focus:outline-rojo focus:outline-offset-2 w-full">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m-6 3.75l3 3m0 0l3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75" />
                </svg>

                Mis Trámites
            </a>
        @endcan

    @endcan

</div>
