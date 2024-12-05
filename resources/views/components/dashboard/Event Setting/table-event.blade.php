<div class="flex justify-end mb-4">
    <button onclick="showCreateModal()" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-700">Tambah Event</button>
</div>
<h2 class="text-2xl font-semibold mb-4 dark:bg-gray-800 dark:text-gray-200">Data Events</h2>

<!-- Search Form -->
<form id="searchForm" method="GET" action="{{ route('dashboard.events.index') }}" class="flex items-center mb-4">
    <div class="bg-white rounded flex items-center w-full max-w-xl mr-4 p-2 shadow-sm border border-gray-200">
        <button type="button" class="outline-none focus:outline-none" id="searchButton">
            <svg class="w-5 text-gray-600 h-5 cursor-pointer" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </button>
        <input type="search" name="search" id="searchInput" placeholder="Search" class="w-full pl-3 text-sm text-black outline-none focus:outline-none bg-transparent" value="{{ request()->input('search') }}">
    </div>
</form>

<!-- Event Table -->
<table class="min-w-full leading-normal">
    <thead>
        <tr>
            <th scope="col" class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-left text-sm uppercase font-semibold">No</th>
            <th scope="col" class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-left text-sm uppercase font-semibold">Judul</th>
            <th scope="col" class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-left text-sm uppercase font-semibold">Tanggal</th>
            <th scope="col" class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-left text-sm uppercase font-semibold">Dilaksanakan Oleh</th>
            <th scope="col" class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-left text-sm uppercase font-semibold">Foto</th>
            <th scope="col" class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-left text-sm uppercase font-semibold">QR Code</th>
            <th scope="col" class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-left text-sm uppercase font-semibold">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($event as $item)
        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" data-id="{{ $item->id }}">
            <td class="px-5 py-4 border-b border-gray-200 text-sm">{{ ($event->currentPage() - 1) * $event->perPage() + $loop->iteration }}</td>
            <td class="px-5 py-4 border-b border-gray-200 text-sm">{{ $item->judul_event }}</td>
            <td class="px-5 py-4 border-b border-gray-200 text-sm">{{ $item->tanggal_mulai }} - {{ $item->tanggal_akhir }}</td>
            <td class="px-5 py-4 border-b border-gray-200 text-sm">{{ $item->dilaksanakan_oleh }}</td>
            <td class="px-5 py-4 border-b border-gray-200 text-sm">
                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Event" width="100">
            </td>
            <td class="px-5 py-4 border-b border-gray-200 text-sm">
                <img src="{{ asset('storage/' . $item->link) }}" alt="QR Code" width="100">
            </td>
            <td class="px-5 py-4 border-b border-gray-200 text-sm space-x-2">
                <button onclick="showDetail({{ $item->id }})" class="text-blue-500 hover:text-blue-700 font-semibold">View</button>
                <button onclick="showEditModal({{ $item->id }})" class="text-yellow-500 hover:text-yellow-700 font-semibold">Edit</button>
                <button onclick="deleteDetail({{ $item->id }})" class="text-red-500 hover:text-red-700 font-semibold">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination -->
<div class="mt-4">
    {{ $event->links() }}
</div>

<!-- Modal Konfirmasi -->
<div id="confirmModal" class="hidden fixed inset-0 flex items-center justify-center z-50 backdrop-blur-sm shadow-xl">
    <div class="dark:bg-gray-800 p-8 rounded-lg text-center max-w-sm w-full">
        <h2 class="text-lg font-semibold mb-6 text-white">Anda yakin ingin menghapus data ini?</h2>
        <div class="flex justify-center gap-6">
            <button id="confirmDeleteBtn" class="bg-red-500 text-white px-5 py-2 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">Hapus</button>
            <button id="cancelDeleteBtn" class="bg-blue-500 text-white px-5 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">Batal</button>
        </div>
    </div>
</div>
