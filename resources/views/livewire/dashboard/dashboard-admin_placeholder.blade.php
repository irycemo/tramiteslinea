<div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">

        <div class="flex md:block justify-evenly items-center space-x-2 border-t-4 border-blue-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

            <div class="  mb-2 items-center">

                <span class="font-semibold text-2xl text-blueGray-600 mb-2">

                    <img class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                </span>

                <h5 class="text-blueGray-400 uppercase  text-center  tracking-widest md:tracking-normal">Nuevos</h5>

            </div>

            <a href="{{ route('lista_avisos') . "?estado=nuevo" }}" class="mx-auto rounded-full border border-blue-600 py-1 px-4 text-blue-500 hover:bg-blue-600 hover:text-white transition-all ease-in-out"> Ver avisos</a>

        </div>

        <div class="flex md:block justify-evenly items-center space-x-2 border-t-4 border-green-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

            <div class="  mb-2 items-center">

                <span class="font-semibold text-2xl text-blueGray-600 mb-2">

                    <img class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                </span>

                <h5 class="text-blueGray-400 uppercase  text-center  tracking-widest md:tracking-normal">Cerrados</h5>

            </div>

            <a href="{{ route('lista_avisos') . "?estado=cerrado" }}" class="mx-auto rounded-full border border-green-600 py-1 px-4 text-green-500 hover:bg-green-600 hover:text-white transition-all ease-in-out"> Ver avisos</a>

        </div>

        <div class="flex md:block justify-evenly items-center space-x-2 border-t-4 border-indigo-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

            <div class="  mb-2 items-center">

                <span class="font-semibold text-2xl text-blueGray-600 mb-2">

                    <img class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                </span>

                <h5 class="text-blueGray-400 uppercase  text-center  tracking-widest md:tracking-normal">Autorizados</h5>

            </div>

            <a href="{{ route('lista_avisos') . "?estado=autorizado" }}" class="mx-auto rounded-full border border-indigo-600 py-1 px-4 text-indigo-500 hover:bg-indigo-600 hover:text-white transition-all ease-in-out"> Ver avisos</a>

        </div>

        <div class="flex md:block justify-evenly items-center space-x-2 border-t-4 border-gray-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

            <div class="  mb-2 items-center">

                <span class="font-semibold text-2xl text-blueGray-600 mb-2">

                    <img class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                </span>

                <h5 class="text-blueGray-400 uppercase  text-center  tracking-widest md:tracking-normal">Operados</h5>

            </div>

            <a href="{{ route('lista_avisos') . "?estado=operado" }}" class="mx-auto rounded-full border border-gray-600 py-1 px-4 text-gray-500 hover:bg-gray-600 hover:text-white transition-all ease-in-out"> Ver avisos</a>

        </div>

        <div class="flex md:block justify-evenly items-center space-x-2 border-t-4 border-red-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

            <div class="  mb-2 items-center">

                <span class="font-semibold text-2xl text-blueGray-600 mb-2">

                    <img class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                </span>

                <h5 class="text-blueGray-400 uppercase  text-center  tracking-widest md:tracking-normal">Rechazado</h5>

            </div>

            <a href="{{ route('lista_avisos') . "?estado=rechazado" }}" class="mx-auto rounded-full border border-red-600 py-1 px-4 text-red-500 hover:bg-red-600 hover:text-white transition-all ease-in-out"> Ver avisos</a>

        </div>

    </div>

</div>
