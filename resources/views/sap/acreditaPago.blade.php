<x-app-layout>

    <div class="max-w-7xl mx-auto p-6 lg:p-8">

        <div class="flex justify-center mb-10">
            <a href="{{ route('login') }}">
                <img src="{{ asset('storage/img/logo2.png') }}" alt="Logo" class="w-96">
            </a>

        </div>

        @if($status === 'success')

            <div class="flex justify-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 w-full lg:w-1/2 mx-auto shadow-lg" role="alert">

                <svg class="flex-shrink-0 inline w-5 h-5 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>

                <span class="sr-only">Info</span>

                <div class="">

                    <span class="font-medium text-lg">El pago del trámite se registró con éxito</span>

                    <ul class="mt-1.5 list-disc list-inside">
                        <li><strong>Número de trámite: </strong>{{ $data['año'] }}-{{ $data['folio'] }}-{{ $data['usuario'] }}</li>
                        <li><strong>Servicio:</strong> {{ $data['servicio'] }}</li>
                        <li><strong>Línea de captura:</strong> {{ $data['linea_de_captura'] }}</li>
                        <li><strong>Tipo de servicio:</strong> {{ $data['tipo_servicio'] }}</li>
                        <li><strong>Monto:</strong> ${{ number_format($data['monto'], 2) }}</li>
                    </ul>

                </div>

            </div>

        @else

            <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 w-full lg:w-1/4 mx-auto shadow-lg" role="alert">

                <svg class="flex-shrink-0 inline w-5 h-5 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>

                <span class="sr-only">Info</span>

                <div>

                    <span class="font-medium text-lg">El pago no pudo ser registrado</span>

                    <ul class="mt-1.5 list-disc list-inside">

                        @if(isset($data['error']))

                            <li><strong>Error: </strong>{{ $data['error'] }}</li>

                        @else

                            <li class="text-justify">
                                <strong>Error: </strong>
                                <p>
                                    La información proveniente de la secretaría de finanzas y administración ha sido insuficiente para poder acreditar el pago.
                                </p>
                                <p>
                                    Favor de comunicarse al departamento de operación y desarrollo de sistemas teniendo su comprobante de pago y número de trámite disponibles para ser acreditado.
                                </p>
                            </li>

                        @endif

                    </ul>

                </div>

            </div>

        @endif

    </div>

</x-app-layout>
