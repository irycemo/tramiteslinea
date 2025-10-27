<div>

    <x-header>Avisos aclaratorios</x-header>

    <div class="mb-5">

        <div class="grid grid-cols-2 sm:grid-cols-2 xl:grid-cols-5 gap-4">

            <div class="flex:col md:block justify-evenly items-center space-x-2 border-t-4 border-blue-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-semibold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $acalaratorios_nuevos }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase text-sm  text-center  tracking-widest md:tracking-normal">Nuevos</h5>

                </div>

                <a href="{{ route('lista_avisos') . "?estado=nuevo" }}" class="mx-auto rounded-full border border-blue-600 py-1 px-4 text-blue-500 hover:bg-blue-600 hover:text-white transition-all ease-in-out text-sm"> Ver avisos</a>

            </div>

            <div class="flex:col md:block justify-evenly items-center space-x-2 border-t-4 border-green-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-semibold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $acalaratorios_cerrados }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase text-sm  text-center  tracking-widest md:tracking-normal">Cerrados</h5>

                </div>

                <a href="{{ route('lista_avisos') . "?estado=cerrado" }}" class="mx-auto rounded-full border border-green-600 py-1 px-4 text-green-500 hover:bg-green-600 hover:text-white transition-all ease-in-out text-sm"> Ver avisos</a>

            </div>

            <div class="flex:col md:block justify-evenly items-center space-x-2 border-t-4 border-indigo-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-semibold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $acalaratorios_autorizados }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase text-sm  text-center  tracking-widest md:tracking-normal">Autorizados</h5>

                </div>

                <a href="{{ route('lista_avisos') . "?estado=autorizado" }}" class="mx-auto rounded-full border border-indigo-600 py-1 px-4 text-indigo-500 hover:bg-indigo-600 hover:text-white transition-all ease-in-out text-sm"> Ver avisos</a>

            </div>

            <div class="flex:col md:block justify-evenly items-center space-x-2 border-t-4 border-gray-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-semibold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $acalaratorios_operados }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase text-sm  text-center  tracking-widest md:tracking-normal">Operados</h5>

                </div>

                <a href="{{ route('lista_avisos') . "?estado=operado" }}" class="mx-auto rounded-full border border-gray-600 py-1 px-4 text-gray-500 hover:bg-gray-600 hover:text-white transition-all ease-in-out text-sm"> Ver avisos</a>

            </div>

            <div class="flex:col md:block justify-evenly items-center space-x-2 border-t-4 border-red-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-semibold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $acalaratorios_rechazados }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase text-sm  text-center  tracking-widest md:tracking-normal">Rechazado</h5>

                </div>

                <a href="{{ route('lista_avisos') . "?estado=rechazado" }}" class="mx-auto rounded-full border border-red-600 py-1 px-4 text-red-500 hover:bg-red-600 hover:text-white transition-all ease-in-out text-sm"> Ver avisos</a>

            </div>

        </div>

    </div>

    <x-header>Revisiones de avisos</x-header>

    <div class="mb-5">

        <div class="grid grid-cols-2 sm:grid-cols-2 xl:grid-cols-5 gap-4">

            <div class="flex:col md:block justify-evenly items-center space-x-2 border-t-4 border-blue-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-semibold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $revisiones_nuevas }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase text-sm text-center  tracking-widest md:tracking-normal">Nuevos</h5>

                </div>

                <a href="{{ route('lista_avisos') . "?estado=nuevo" }}" class="mx-auto rounded-full border border-blue-600 py-1 px-4 text-blue-500 hover:bg-blue-600 hover:text-white transition-all ease-in-out text-sm"> Ver avisos</a>

            </div>

            <div class="flex:col md:block justify-evenly items-center space-x-2 border-t-4 border-green-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-semibold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $revisiones_cerradas }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase  text-center  tracking-widest md:tracking-normal text-sm">Cerrados</h5>

                </div>

                <a href="{{ route('lista_avisos') . "?estado=cerrado" }}" class="mx-auto rounded-full border border-green-600 py-1 px-4 text-green-500 hover:bg-green-600 hover:text-white transition-all ease-in-out text-sm"> Ver avisos</a>

            </div>

            <div class="flex:col md:block justify-evenly items-center space-x-2 border-t-4 border-indigo-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-semibold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $revisiones_autorizadas }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase  text-center  tracking-widest md:tracking-normal text-sm">Autorizados</h5>

                </div>

                <a href="{{ route('lista_avisos') . "?estado=autorizado" }}" class="mx-auto rounded-full border border-indigo-600 py-1 px-4 text-indigo-500 hover:bg-indigo-600 hover:text-white transition-all ease-in-out text-sm"> Ver avisos</a>

            </div>

            <div class="flex:col md:block justify-evenly items-center space-x-2 border-t-4 border-gray-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-semibold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $revisiones_operadas }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase  text-center  tracking-widest md:tracking-normal text-sm">Operados</h5>

                </div>

                <a href="{{ route('lista_avisos') . "?estado=operado" }}" class="mx-auto rounded-full border border-gray-600 py-1 px-4 text-gray-500 hover:bg-gray-600 hover:text-white transition-all ease-in-out text-sm"> Ver avisos</a>

            </div>

            <div class="flex:col md:block justify-evenly items-center space-x-2 border-t-4 border-red-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-semibold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $revisiones_rechazadas }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase  text-center  tracking-widest md:tracking-normal text-sm">Rechazado</h5>

                </div>

                <a href="{{ route('lista_avisos') . "?estado=rechazado" }}" class="mx-auto rounded-full border border-red-600 py-1 px-4 text-red-500 hover:bg-red-600 hover:text-white transition-all ease-in-out text-sm"> Ver avisos</a>

            </div>

        </div>

    </div>

    <x-header>Certificados catastrales</x-header>

    <div class="grid grid-cols-2 sm:grid-cols-2 xl:grid-cols-5 gap-4 mb-5">

        @foreach ($certificados_catastrales as $certificado_catastral)

            <div class="flex:col md:block justify-evenly items-center space-x-2 border-t-4 border-{{ $certificado_catastral['color'] }}-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-semibold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $certificado_catastral['total'] }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase text-sm text-center  tracking-widest md:tracking-normal">{{ $certificado_catastral['estado'] == 'A' ? 'Pendientes' : ucfirst($certificado_catastral['estado']) }}</h5>

                </div>

                @if($certificado_catastral['estado'] == 'A')

                    <a href="{{ route('tramites_catastro') . "?estado=pagado" }}" class="mx-auto rounded-full border border-{{ $certificado_catastral['color'] }}-600 py-1 px-4 text-{{ $certificado_catastral['color'] }}-500 hover:bg-{{ $certificado_catastral['color'] }}-600 hover:text-white transition-all ease-in-out text-sm"> Ver avisos</a>

                @else

                    <a href="{{ route('certificados_catastro') . "?estado=" . $certificado_catastral['estado'] }}" class="mx-auto rounded-full border border-{{ $certificado_catastral['color'] }}-600 py-1 px-4 text-{{ $certificado_catastral['color'] }}-500 hover:bg-{{ $certificado_catastral['color'] }}-600 hover:text-white transition-all ease-in-out text-sm"> Ver avisos</a>

                @endif

            </div>

        @endforeach

    </div>

    <x-header>Certificados de gravamen</x-header>

    <div class="grid grid-cols-2 sm:grid-cols-2 xl:grid-cols-5 gap-4">

        @foreach ($certificados_gravamen as $certificado_gravamen)

            <div class="flex:col md:block justify-evenly items-center space-x-2 border-t-4 border-{{ $certificado_gravamen['color'] }}-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-semibold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $certificado_gravamen['total'] }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase text-sm text-center  tracking-widest md:tracking-normal">{{ $certificado_gravamen['estado'] == 'A' ? 'Pendientes' : ucfirst($certificado_gravamen['estado']) }}</h5>

                </div>

                <a href="{{ route('certificados_rpp') . "?estado=" . $certificado_gravamen['estado'] }}" class="mx-auto rounded-full border border-{{ $certificado_gravamen['color'] }}-600 py-1 px-4 text-{{ $certificado_gravamen['color'] }}-500 hover:bg-{{ $certificado_catastral['color'] }}-600 hover:text-white transition-all ease-in-out text-sm"> Ver avisos</a>

            </div>

        @endforeach

    </div>

</div>

