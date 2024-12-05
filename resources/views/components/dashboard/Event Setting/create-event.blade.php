<div id="createModal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 backdrop-blur-sm shadow-xl">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-4xl mx-auto">
        <h3 class="text-2xl font-semibold mb-4 text-white dark:text-gray-200">Tambah Event</h3>
        <form id="createEventForm" action="{{ route('events.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Judul Event -->
                <div>
                    <label for="createJudulEvent" class="block text-white dark:text-gray-300">Judul Event</label>
                    <input type="text" id="createJudulEvent" name="judul_event" required
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
                        placeholder="Masukkan Judul Event">
                    @error('judul_event')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Mulai -->
                <div>
                    <label for="createTanggalMulai" class="block text-white dark:text-gray-300">Tanggal Mulai</label>
                    <input type="date" id="createTanggalMulai" name="tanggal_mulai" required
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                    @error('tanggal_mulai')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Akhir -->
                <div>
                    <label for="createTanggalAkhir" class="block text-white dark:text-gray-300">Tanggal Akhir</label>
                    <input type="date" id="createTanggalAkhir" name="tanggal_akhir" required
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                    @error('tanggal_akhir')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dilaksanakan Oleh -->
                <div>
                    <label for="createDilaksanakanOleh" class="block text-white dark:text-gray-300">Dilaksanakan Oleh</label>
                    <input type="text" id="createDilaksanakanOleh" name="dilaksanakan_oleh" required
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
                        placeholder="Masukkan Penyelenggara">
                    @error('dilaksanakan_oleh')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Foto Event -->
                <div>
                    <label for="createFoto" class="block text-white dark:text-gray-300">Foto Event</label>
                    <input type="file" id="createFoto" name="foto" required
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                    @error('foto')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- QR Code -->
                <div>
                    <label for="createQRCode" class="block text-white dark:text-gray-300">QR Code</label>
                    <input type="file" id="createQRCode" name="qrcode" required
                        class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white">
                    @error('qrcode')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" onclick="closeModal('createModal')" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-800">Batal</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-800">Simpan</button>
            </div>
        </form>
    </div>
</div>
