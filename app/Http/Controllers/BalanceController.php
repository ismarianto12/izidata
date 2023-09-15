<?php

namespace App\Http\Controllers;

use App\Models\balance as Balance;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    public function processTransaction(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|integer',
            'amount' => 'required|numeric',
        ]);

        $userId = $request->input('user_id');
        $amount = $request->input('amount');

        // Jika amount adalah 0.00000001, tolak transaksi
        if ($amount == 0.00000001) {
            return response()->json(['message' => 'Transaksi ditolak , jumlahnya terlalu kecil'], 400);
        }

        try {
            DB::beginTransaction();

            // Mengecek saldo yang tersedia
            $balance = Balance::where('user_id', $userId)->lockForUpdate()->first();

            if (!$balance || $balance->amount_available < $amount) {
                DB::rollBack();
                return response()->json(['message' => 'Transaksi ditolak , saldo tidak mencukupi'], 400);
            }

            // Memasukkan data transaksi ke tabel transaksi
            $transaction = new Transaction();
            $transaction->user_id = $userId;
            $transaction->amount = $amount;
            $transaction->created_at = Carbon::now();
            $transaction->updated_at = Carbon::now();
            $transaction->save();

            // Menambahkan delay selama 30 detik
            sleep(30);

            // Jika trx_id sudah ada, tolak transaksi dan rollback
            if (Transaction::where('trx_id', $transaction->id)->exists()) {
                DB::rollBack();
                return response()->json(['message' => 'Transaksi ditolak karena trx_id sudah ada'], 400);
            }

            // Memperbarui saldo
            $balance->amount_available -= $amount;
            $balance->save();

            // Commit transaksi jika semua langkah berhasil
            DB::commit();

            // Mengembalikan data transaksi dan saldo dengan format yang diinginkan
            return response()->json([
                'transaction' => [
                    'trx_id' => $transaction->id,
                    'amount' => number_format($amount, 6, '.', ''),
                ],
                'balance' => [
                    'user_id' => $userId,
                    'amount_available' => number_format($balance->amount_available, 6, '.', ''),
                ],
            ], 200);
        } catch (\Exception $e) {
            // Rollback transaksi jika ada kesalahan
            DB::rollBack();
            return response()->json(['message' => 'Transaksi ditolak karena terjadi kesalahan'], 500);
        }
    }

    public function jokesRandom()
    {

        $ch = curl_init();
        $url = "https://api.chucknorris.io/jokes/random";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            echo $response;
        }

        curl_close($ch);
    }
}
