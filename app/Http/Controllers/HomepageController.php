<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EventPengembanganKarir;

class HomepageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data event dengan tipe 'event'
        $events = EventPengembanganKarir::where('tipe_event', 'event')->get();

        // Ambil data loker dengan tipe 'loker'
        $loker = EventPengembanganKarir::where('tipe_event', 'loker')->get();

        // Mengirimkan data ke view
        return view('pages.welcome', [
            'id' => $user?->id ?? null,
            'role' => $user?->role ?? null,
            'status' => $user?->status ?? null,
            'events' => $events,
            'loker' => $loker,
        ]);
    }
}
