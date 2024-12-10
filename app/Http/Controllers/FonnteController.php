<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FonnteController extends Controller
{
    public function sendFonnteMessage($receiverWhatsapp, $text)
    {
        $tokenFonnte = env('FONNTE_TOKEN');  // Token Fonnte API Anda

        $url = "https://api.fonnte.com/send";

        // Kirim pesan ke user
        $response_user = Http::withHeaders([
            'Authorization' => $tokenFonnte,
        ])->post($url, [
            'target' => $receiverWhatsapp,
            'message' => $text
        ]);

        error_log($tokenFonnte);
        
        // Cek apakah request berhasil
        if ($response_user->successful()) {
            error_log('berhasil');
            return response()->json(['message' => 'Pesan berhasil dikirim'], 200);
        } else {
            error_log('gagal');
            return response()->json(['message' => 'Gagal mengirim pesan'], 500);
        }
    }
}
