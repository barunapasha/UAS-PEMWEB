<?php

namespace App\Jawaban;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Event;

class NomorTiga
{
	public function getData()
	{
		// Mengambil semua data jadwal user yang sedang login
		$data = Event::where('user_id', Auth::id())
			->orderBy('start', 'asc')
			->get(); // Tidak perlu toArray() di sini
		return $data;
	}

	public function getSelectedData(Request $request)
	{
		try {
			// Validasi input
			$request->validate([
				'id' => 'required|exists:events,id'
			]);

			// Mengambil data event
			$event = Event::where('id', $request->id)
				->where('user_id', Auth::id())
				->first();

			if (!$event) {
				return response()->json([
					'status' => 'error',
					'error' => 'Data tidak ditemukan'
				], 404);
			}

			// Format tanggal ke Y-m-d untuk input date
			$event->start = date('Y-m-d', strtotime($event->start));
			$event->end = date('Y-m-d', strtotime($event->end));

			return response()->json([
				'status' => 'success',
				'data' => $event
			]);
		} catch (\Exception $e) {
			return response()->json([
				'status' => 'error',
				'error' => 'Terjadi kesalahan: ' . $e->getMessage()
			], 500);
		}
	}

	public function update(Request $request)
	{
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

	public function delete(Request $request)
	{
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
