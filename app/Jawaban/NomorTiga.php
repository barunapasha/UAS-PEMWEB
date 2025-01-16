<?php

namespace App\Jawaban;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class NomorTiga
{
	public function getData()
	{
		try {
			return Event::where('user_id', Auth::id())
				->orderBy('start', 'asc')
				->get();
		} catch (\Exception $e) {
			Log::error('Error in getData: ' . $e->getMessage());
			return collect();
		}
	}

	public function getSelectedData(Request $request)
	{
		try {
			Log::info('getSelectedData called with data:', $request->all());

			$validated = $request->validate([
				'id' => 'required|integer|exists:events,id'
			]);

			$event = Event::where('id', $validated['id'])
				->where('user_id', Auth::id())
				->first();

			if (!$event) {
				Log::warning('Event not found or unauthorized');
				return response()->json([
					'status' => false,
					'message' => 'Data tidak ditemukan'
				], 404);
			}

			Log::info('Sending event data:', [
				'id' => $event->id,
				'name' => $event->name,
				'start' => date('Y-m-d', strtotime($event->start)),
				'end' => date('Y-m-d', strtotime($event->end))
			]);

			return response()->json([
				'status' => true,
				'data' => [
					'id' => $event->id,
					'name' => $event->name,
					'start' => date('Y-m-d', strtotime($event->start)),
					'end' => date('Y-m-d', strtotime($event->end))
				]
			]);
		} catch (\Exception $e) {
			Log::error('Error in getSelectedData: ' . $e->getMessage());
			return response()->json([
				'status' => false,
				'message' => 'Terjadi kesalahan: ' . $e->getMessage()
			], 500);
		}
	}

	public function update(Request $request)
	{
		try {
			Log::info('Update called with data:', $request->all());

			$validated = $request->validate([
				'id' => 'required|integer|exists:events,id',
				'name' => 'required|string',
				'start' => 'required|date',
				'end' => 'required|date|after_or_equal:start'
			]);

			$event = Event::where('id', $validated['id'])
				->where('user_id', Auth::id())
				->first();

			if (!$event) {
				return response()->json([
					'status' => false,
					'message' => 'Data tidak ditemukan'
				], 404);
			}

			$event->update([
				'name' => $validated['name'],
				'start' => $validated['start'],
				'end' => $validated['end']
			]);

			return response()->json([
				'status' => true,
				'message' => 'Jadwal berhasil diupdate'
			]);
		} catch (\Exception $e) {
			Log::error('Error in update: ' . $e->getMessage());
			return response()->json([
				'status' => false,
				'message' => 'Gagal mengupdate jadwal: ' . $e->getMessage()
			], 500);
		}
	}

	public function delete(Request $request)
	{
		try {
			$request->validate([
				'id' => 'required|exists:events,id'
			]);

			$event = Event::where('id', $request->id)
				->where('user_id', Auth::id())
				->first();

			if (!$event) {
				return response()->json([
					'status' => false,
					'message' => 'Data tidak ditemukan'
				], 404);
			}

			$event->delete();

			return response()->json([
				'status' => true,
				'message' => 'Jadwal berhasil dihapus'
			]);
		} catch (\Exception $e) {
			Log::error('Error in delete: ' . $e->getMessage());
			return response()->json([
				'status' => false,
				'message' => 'Gagal menghapus jadwal'
			], 500);
		}
	}
}
