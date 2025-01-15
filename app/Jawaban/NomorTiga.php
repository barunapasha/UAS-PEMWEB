<?php

namespace App\Jawaban;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Event;

class NomorTiga {
    public function getData() {
        // Mengambil semua data jadwal user yang sedang login
        $data = Event::where('user_id', Auth::id())
                    ->orderBy('start', 'asc')
                    ->get(); // Tidak perlu toArray() di sini
        return $data;
    }

    public function getSelectedData(Request $request) {
        // Validasi input
        $request->validate([
            'id' => 'required|exists:events,id'
        ]);

        // Mengambil 1 data jadwal berdasarkan ID
        $data = Event::where('id', $request->id)
                    ->where('user_id', Auth::id())
                    ->first();

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }

    public function update(Request $request) {
        // Validasi input
        $request->validate([
            'id' => 'required|exists:events,id',
            'name' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start'
        ]);

        try {
            $event = Event::where('id', $request->id)
                         ->where('user_id', Auth::id())
                         ->first();

            if (!$event) {
                return redirect()
                    ->route('event.home')
                    ->with('message', ['Jadwal tidak ditemukan!', 'danger']);
            }

            $event->update([
                'name' => $request->name,
                'start' => $request->start,
                'end' => $request->end
            ]);

            return redirect()
                ->route('event.home')
                ->with('message', ['Jadwal berhasil diupdate!', 'success']);
        } catch (\Exception $e) {
            return redirect()
                ->route('event.home')
                ->with('message', ['Gagal mengupdate jadwal!', 'danger']);
        }
    }

    public function delete(Request $request) {
        // Validasi input
        $request->validate([
            'id' => 'required|exists:events,id'
        ]);

        try {
            $event = Event::where('id', $request->id)
                         ->where('user_id', Auth::id())
                         ->first();

            if (!$event) {
                return response()->json(['error' => 'Jadwal tidak ditemukan'], 404);
            }

            $event->delete();

            return response()->json(['success' => 'Jadwal berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus jadwal'], 500);
        }
    }
}