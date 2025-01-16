<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jawaban\NomorDua;
use App\Jawaban\NomorTiga;
use App\Jawaban\NomorEmpat;

class SchedulerController extends Controller {

    public function home() {
        try {
            $nomorTiga = new NomorTiga(); 
            $events = $nomorTiga->getData();
            
            return view('home.index', compact('events'));
        } catch (\Exception $e) {
            return view('home.index', ['events' => collect()]);
        }
    }

    public function submit(Request $request) {
        try {
            $nomorDua = new NomorDua();
            return $nomorDua->submit($request);
        } catch (\Exception $e) {
            return redirect()
                ->route('event.home')
                ->with('message', ['Gagal menambahkan jadwal!', 'danger']);
        }
    }

    public function getJson() {
        try {
            $nomorEmpat = new NomorEmpat();
            return $nomorEmpat->getJson(); 
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }

    public function getSelectedData(Request $request) {
        try {
            $nomorTiga = new NomorTiga(); 
            return $nomorTiga->getSelectedData($request);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengambil data'
            ], 500);
        }
    }

    public function update(Request $request) {
        try {
            $nomorTiga = new NomorTiga();
            return $nomorTiga->update($request);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengupdate jadwal'
            ], 500);
        }
    }

    public function delete(Request $request) {
        try {
            $nomorTiga = new NomorTiga();
            return $nomorTiga->delete($request);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus jadwal'
            ], 500);
        }
    }
}