<div class="w-full px-4 lg:px-0 my-24 py-12 flex items-center justify-center flex-col bg-gray-100" id="event">
    <h1 class="text-3xl font-bold mb-6 text-[#003194]">Event Pengembangan Karir</h1>
    <div class="container mx-auto flex flex-col lg:flex-row justify-between items-start gap-6 h-auto rounded-lg">
        <div id="event-content" class="w-full lg:w-2/3 p-6 flex flex-col gap-6 rounded-lg">
            <h2 class="text-2xl font-bold">Event Terbaru</h2>

            <!-- Display first 3 events -->
            @foreach ($events->take(3) as $event)
                <div class="flex w-full bg-white shadow-md p-4 mb-4"
                    style="border-radius: 25px 0 25px 0; box-shadow: 0 0 10px 0 rgb(0 49 148 / 20%);">
                    <div class="w-full sm:w-1/4 lg:w-1/4 aspect-square">
                        <img src="{{ asset('images/perusahaan.jpg') }}" alt="Foto Acara"
                            class="object-cover w-full h-full rounded-lg">
                    </div>
                    <div class="w-2/4 flex flex-col gap-4 px-4">
                        <h3 class="text-lg font-bold">{{ $event->judul_event }}</h3>
                        <p class="text-sm text-gray-600">{{ $event->deskripsi_event }}</p>
                        <p class="text-xs">{{ $event->dilaksanakan_oleh }}</p>
                        <p class="text-xs"><span class="text-red-500">Acara berakhir pada
                                {{ date('d-m-Y', strtotime($event->tanggal_akhir)) }}</span></p>
                    </div>
                    <div class="w-full sm:w-1/4 lg:w-1/4 aspect-square">
                        <img src="{{ asset('images/qrcode.jpg') }}" alt="Foto Acara">
                    </div>
                </div>
            @endforeach

            <!-- Additional events (hidden initially) -->
            <div id="additional-cards" class="hidden">
                @foreach ($events->skip(3)->take(5) as $event)
                    <div class="flex w-full bg-white shadow-md p-4 mb-4"
                        style="border-radius: 25px 0 25px 0; box-shadow: 0 0 10px 0 rgb(0 49 148 / 20%);">
                        <div class="w-full sm:w-1/4 lg:w-1/4 aspect-square">
                            <img src="{{ asset('images/qrcode.jpg') }}" alt="Foto Acara"
                                class="object-cover w-full h-full rounded-lg">
                        </div>
                        <div class="w-2/4 flex flex-col gap-4 px-4">
                            <h3 class="text-lg font-bold">{{ $event->judul_event }}</h3>
                            <p class="text-sm text-gray-600">{{ $event->deskripsi_event }}</p>
                            <p class="text-xs">{{ $event->dilaksanakan_oleh }}</p>
                            <p class="text-xs"><span class="text-red-500">Acara berakhir pada
                                    {{ date('d-m-Y', strtotime($event->tanggal_akhir)) }}</span></p>
                        </div>
                        <div class="w-full sm:w-1/4 lg:w-1/4 aspect-square">
                            <canvas id="qrcode{{ $event->id }}"></canvas>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($events->count() > 3)
                <button id="see-all" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    See All
                </button>
                <button id="minimize-all"
                    class="mt-4 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 hidden">
                    Minimize
                </button>
            @endif
        </div>

        <div id="loker" class="w-full lg:w-1/3 p-6 p-6 flex flex-col gap-6 rounded-lg">
            <h2 class="text-2xl font-bold mb-4">Loker</h2>

            <!-- Display first 3 job listings -->
            @foreach ($loker->take(3) as $lokerItem)
                <div class="flex w-full bg-white p-4 mb-4"
                    style="border-radius: 25px 0 25px 0; box-shadow: 0 0 10px 0 rgb(0 49 148 / 20%);">
                    <div class="w-full sm:w-2/4 lg:w-2/4 aspect-square">
                        <img src="{{ asset('images/qrcode.jpg') }}" alt="Loker Photo"
                            class="object-cover w-full h-full rounded-lg">
                    </div>
                    <div class="w-2/4 flex flex-col px-4">
                        <h3 class="text-lg font-bold">{{ $lokerItem->judul_event }}</h3>
                        <p class="text-sm line-clamp-3">{{ Str::limit($lokerItem->deskripsi_event, 100) }}</p>
                        <p class="text-xs">Posted by {{ $lokerItem->dilaksanakan_oleh }}</p>
                    </div>
                </div>
            @endforeach

            <!-- Additional job listings (hidden initially) -->
            <div id="additional-loker" class="hidden">
                @foreach ($loker->skip(3)->take(5) as $lokerItem)
                    <div class="flex w-full bg-white p-4 mb-4"
                        style="border-radius: 25px 0 25px 0; box-shadow: 0 0 10px 0 rgb(0 49 148 / 20%);">
                        <div class="w-full sm:w-1/4 lg:w-1/4 aspect-square">
                            <img src="{{ asset('images/test.jpg') }}" alt="Loker Photo"
                                class="object-cover w-full h-full rounded-lg">
                        </div>
                        <div class="w-2/4 flex flex-col px-4">
                            <h3 class="text-lg font-bold">{{ $lokerItem->judul_event }}</h3>
                            <p class="text-sm line-clamp-3">{{ Str::limit($lokerItem->deskripsi_event, 100) }}</p>
                            <p class="text-xs">Posted by {{ $lokerItem->dilaksanakan_oleh }}</p>
                        </div>
                        <div class="w-full sm:w-1/4 lg:w-1/4 aspect-square">
                            <canvas id="qrcode{{ $lokerItem->id }}"></canvas>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($loker->count() > 3)
                <button id="see-all-loker" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    See All
                </button>
                <button id="minimize-all-loker"
                    class="mt-4 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 hidden">
                    Minimize
                </button>
            @endif
        </div>
    </div>
</div>
