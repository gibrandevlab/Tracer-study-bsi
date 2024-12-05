<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventPengembanganKarir;
use App\Models\User;
use App\Models\ProfilAlumni;
use App\Models\ProfilAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController extends Controller
{
    public function index()
    {
        // Menggunakan pagination, ganti all() menjadi paginate()
        $event = EventPengembanganKarir::paginate(10);  // Membatasi jumlah event per halaman
        $profil = $this->getProfile(Auth::id(), Auth::user()->role);
        $peranPengguna = Auth::user()->role;

        // Hanya Admin yang dapat mengakses data Alumni
        if ($peranPengguna === 'admin') {
            $users = User::where('role', 'alumni')
                ->whereDoesntHave('profilAlumni')  // Menggunakan relasi Eloquent untuk menghindari query yang berlebihan
                ->orderByDesc('updated_at')
                ->get();
        } else {
            $users = collect();  // Kosongkan jika bukan admin
        }

        return view('pages.dashboard.event', compact('event', 'profil', 'peranPengguna', 'users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul_event' => 'required|string|max:255',
            'deskripsi_event' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'dilaksanakan_oleh' => 'required|string|max:255',
            'tipe_event' => 'required|string',
            'foto' => 'required|image|max:2048',
            'link' => 'required|url',
        ]);

        // Simpan Foto
        if ($request->hasFile('foto')) {
            $mediaPath = $request->file('foto')->store('images/events', 'public');
            $validatedData['foto'] = $mediaPath;
        }

        // Generate QR Code untuk Link
        $validatedData['link'] = $this->generateQrCode($validatedData['link']);

        // Simpan ke Database
        EventPengembanganKarir::create($validatedData);

        return redirect()->route('dashboard.events.index')->with('success', 'Event berhasil dibuat.');
    }

    public function update(Request $request, EventPengembanganKarir $event)
    {
        $validatedData = $request->validate([
            'judul_event' => 'required|string|max:255',
            'deskripsi_event' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'dilaksanakan_oleh' => 'required|string|max:255',
            'tipe_event' => 'required|string',
            'foto' => 'nullable|image|max:2048',
            'link' => 'required|url',
        ]);

        // Update Foto jika diunggah ulang
        if ($request->hasFile('foto')) {
            $this->deleteFile($event->foto);  // Hapus foto lama
            $mediaPath = $request->file('foto')->store('images/events', 'public');
            $validatedData['foto'] = $mediaPath;
        }

        // Generate QR Code baru untuk Link
        $this->deleteFile($event->link);  // Hapus QR Code lama
        $validatedData['link'] = $this->generateQrCode($validatedData['link']);

        // Update ke Database
        $event->update($validatedData);

        return redirect()->route('dashboard.events.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(EventPengembanganKarir $event)
    {
        // Hapus Foto dan QR Code
        $this->deleteFile($event->foto);
        $this->deleteFile($event->link);

        $event->delete();

        return redirect()->route('dashboard.events.index')->with('success', 'Event berhasil dihapus.');
    }

    // Fungsi untuk mendapatkan profil pengguna
    private function getProfile($userId, $userRole)
    {
        // Hanya mengizinkan admin untuk mengambil data profil Alumni
        if ($userRole === 'admin') {
            $profileClass = ProfilAdmin::class;
        } else {
            $profileClass = ProfilAlumni::class;
        }

        return $profileClass::select($this->getProfileColumns($userRole))
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    // Menentukan kolom yang perlu diambil berdasarkan peran pengguna
    private function getProfileColumns($role)
    {
        return [
            'admin' => ['nama', 'email', 'no_telepon', 'jabatan'],
            'alumni' => ['nama', 'tahun_lulus', 'linkedin', 'instagram', 'email', 'no_telepon'],
        ][$role] ?? [];
    }

    // Fungsi untuk menghapus file
    private function deleteFile($filePath)
    {
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }

    // Fungsi untuk generate QR Code
    private function generateQrCode($link)
    {
        $qrCodePath = 'images/events/qr/' . time() . '.png';
        $qrCodeContent = QrCode::format('png')->size(200)->generate($link);
        Storage::disk('public')->put($qrCodePath, $qrCodeContent);
        return $qrCodePath;
    }
}
