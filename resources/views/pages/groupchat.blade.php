<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Komunitas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 h-screen flex flex-col">
    <!-- Chat Container -->
    <div class="flex-1 overflow-y-auto p-4 space-y-4">
        @foreach ($messages as $msg)
            @if ($msg->user_id == auth()->id())
                <!-- Pesan dari user -->
                <div class="flex items-end space-x-4 justify-end">
                    <div>
                        <p class="text-sm text-blue-500 font-semibold text-right">Saya</p>
                        @if ($msg->message)
                            <div class="bg-blue-500 text-white rounded-lg p-3 max-w-xs">
                                {{ $msg->message }}
                            </div>
                        @endif
                        @if ($msg->media_path)
                            @if ($msg->media_type === 'image')
                                <!-- Menampilkan gambar -->
                                <img src="{{ Storage::url($msg->media_path) }}" alt="Image"
                                    class="mt-2 rounded-lg max-w-[250px] max-h-[250px] object-cover">
                            @elseif ($msg->media_type === 'video')
                                <!-- Menampilkan video -->
                                <video src="{{ Storage::url($msg->media_path) }}" controls
                                    class="mt-2 rounded-lg max-w-[250px] max-h-[250px]">
                                    Video tidak didukung di browser ini.
                                </video>
                            @endif
                        @endif
                    </div>
                    <img src="https://via.placeholder.com/40" alt="User Avatar" class="w-10 h-10 rounded-full">
                </div>
            @else
                <!-- Pesan dari orang lain -->
                <div class="flex items-start space-x-4">
                    <img src="https://via.placeholder.com/40" alt="User Avatar" class="w-10 h-10 rounded-full">
                    <div>
                        @if ($msg->user->role === 'alumni')
                            <p class="text-sm text-green-600 font-semibold">{{ $msg->user->profil->nama ?? 'Pengguna' }}</p>
                        @elseif ($msg->user->role === 'admin')
                            <p class="text-sm text-red-600 font-semibold">{{ $msg->user->profil->nama ?? 'Pengguna' }}</p>
                        @endif
                        @if ($msg->message)
                            <div class="bg-gray-200 text-gray-800 rounded-lg p-3 max-w-xs">{{ $msg->message }}</div>
                        @endif
                        @if ($msg->media_path)
                            @if ($msg->media_type === 'image')
                                <!-- Menampilkan gambar -->
                                <img src="{{ Storage::url($msg->media_path) }}" alt="Image"
                                    class="mt-2 rounded-lg max-w-[250px] max-h-[250px] object-cover">
                            @elseif ($msg->media_type === 'video')
                                <!-- Menampilkan video -->
                                <video src="{{ Storage::url($msg->media_path) }}" controls
                                    class="mt-2 rounded-lg max-w-[250px] max-h-[250px]">
                                    Video tidak didukung di browser ini.
                                </video>
                            @endif
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Input Container -->
    <form method="POST" action="{{ route('group-chat.store') }}" enctype="multipart/form-data"
        class="flex items-center space-x-4 p-4 bg-white border-t">
        @csrf
        <input type="file" id="file-input" name="media" accept="image/*,video/*" class="hidden"
            onchange="previewMedia()">
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        <input type="text" name="message" placeholder="Ketik pesan..."
            class="flex-1 px-4 py-2 border rounded-full focus:outline-none focus:ring focus:ring-blue-300">
        <label for="file-input" class="bg-gray-200 text-gray-800 p-2 rounded-full cursor-pointer hover:bg-gray-300">
            📎
        </label>


        <!-- Media Preview -->
        <div id="media-preview-container" class="mt-2 mb-2"></div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600">
            Kirim
        </button>
    </form>

    <script>
        function previewMedia() {
            const fileInput = document.getElementById('file-input');
            const previewContainer = document.getElementById('media-preview-container');
            previewContainer.innerHTML = ""; // Clear existing previews

            const files = fileInput.files;

            Array.from(files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('rounded-lg', 'object-contain', 'max-h-[100px]', 'max-w-[100px]');
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    </script>
</body>

</html>
