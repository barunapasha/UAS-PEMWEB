<?php

namespace App\Jawaban;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Event;

class NomorEmpat {
    public function getJson() {
        // Mengambil semua data jadwal
        $events = Event::with('user')->get();
        
        $data = [];
        foreach($events as $event) {
            $data[] = [
                'id' => $event->id,
                'title' => $event->name . ' (' . $event->user->name . ')', // Gabungan nama jadwal dan pembuat
                'start' => $event->start,
                'end' => $event->end,
                'color' => $event->user_id === Auth::id() ? '#0d6efd' : '#6c757d' // Biru untuk user yang login, abu-abu untuk lainnya
            ];
        }

        return response()->json($data);
    }
}