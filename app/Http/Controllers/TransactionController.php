<?php

namespace App\Http\Controllers;

use App\Models\balance as Balance;
use App\Models\transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
// Add this line

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function processTransaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trx_id' => 'required|string|unique:transaction,trx_id',
            'user_id' => 'required|integer',
            'amount' => 'required|numeric',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $trxId = $request->input('trx_id');
        $userId = $request->input('user_id');
        $amount = $request->input('amount');

        // Jika amount adalah 0.00000001, tolak transaksi
        if ($amount == 0.00000001) {
            return response()->json(['message' => 'Transaksi ditolak karena jumlahnya terlalu kecil'], 400);
        }

        // Menggunakan database transaction untuk mengatur locking dan concurrency
        try {
            DB::beginTransaction();

            // Mengecek saldo yang tersedia
            $balance = Balance::where('user_id', $userId)->lockForUpdate()->first();

            if (!$balance || $balance->amount_available < $amount) {
                DB::rollBack();
                return response()->json(['message' => 'Transaksi ditolak karena saldo tidak mencukupi'], 400);
            }

            // Memasukkan data transaksi ke tabel transaksi
            $transaction = new Transaction();
            $transaction->trx_id = $trxId;
            $transaction->user_id = $userId;
            $transaction->amount = $amount;
            $transaction->created_at = Carbon::now();
            $transaction->updated_at = Carbon::now();
            $transaction->save();

            // Menambahkan delay selama 30 detik
            sleep(30);

            // Memperbarui saldo
            $balance->amount_available -= $amount;
            $balance->save();

            // Commit transaksi jika semua langkah berhasil
            DB::commit();

            // Mengembalikan data transaksi dan saldo dengan format yang diinginkan
            return response()->json([
                'transaction' => [
                    'trx_id' => $trxId,
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

    public function getById(Request $request)
    {
        $request->validate([
            'trx_id' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $trxId = $request->input('trx_id');
        $amount = $request->input('amount');

        $transaction = Transaction::where('trx_id', $trxId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        if ($transaction->amount != $amount) {
            return response()->json(['message' => 'Jumlah transaksi tidak sesuai'], 400);
        }

        return response()->json($transaction, 200);
    }

    public function getTransactions(Request $request)
    {
        $request->validate([
            'page' => 'required|integer',
        ]);

        $page = $request->input('page');
        $perPage = 10;

        $users = DB::table('users')
            ->leftJoin('balance', 'users.id', '=', 'balance.user_id')
            ->leftJoin('transaction', 'users.id', '=', 'transaction.user_id')
            ->select(
                'users.id as user_id',
                'users.name as user_name',
                'balance.amount_available as balance',
                'transaction.id as trx_id',
                'transaction.amount'
            )
            ->orderBy('users.id')
            ->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();

        $formattedData = [];
        foreach ($users as $user) {
            $userData = [
                'user_id' => $user->user_id,
                'user_name' => $user->user_name,
                'balance' => $user->balance,
                'transactions' => [],
            ];

            $userData['transactions'][] = [
                'trx_id' => $user->trx_id,
                'amount' => $user->amount,
            ];

            $formattedData[] = $userData;
        }

        return response()->json(['data' => $formattedData], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(transaction $transaction)
    {
        //
    }
}
