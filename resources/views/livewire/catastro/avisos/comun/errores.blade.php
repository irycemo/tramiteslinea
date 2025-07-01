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