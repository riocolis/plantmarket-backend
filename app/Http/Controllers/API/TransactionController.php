<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $plant_id = $request->input('plant_id');
        $status = $request->input('status');

        if ($id) {
            $transaction = Transaction::with(['plant', 'user'])->find($id);

            if ($transaction) {
                return ResponseFormatter::success(
                    $transaction,
                    'Data Transaction berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Transaction Tidak ada',
                    404
                );
            }
        }
        $transaction = Transaction::with(['plant', 'user'])->where('user_id', Auth::user()->id);

        if ($plant_id) {
            $transaction->where('plant_id', $plant_id);
        }

        if ($status) {
            $transaction->where('status', $status);
        }

        return ResponseFormatter::success(
            $transaction->paginate($limit),
            'Data List transaction berhasil diambil'
        );
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFailed($id);

        $transaction->update($request->all());

        return ResponseFormatter::success(
            $transaction,
            'Transaksi berhasil diperbaharui'
        );
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'plant_id' => 'required|exists:plant,id',
            'user_id' => 'required|exists:users,id',
            'quantity' => 'required',
            'total' => 'required',
            'status' => 'required',
        ]);

        $transaction = Transaction::create([
            'plant_id' => $request->plant_id,
            'user_id' => $request->user_id,
            'quantity' => $request->quantity,
            'total' => $request->total,
            'status' => $request->status,
            'payment_url' => '',
        ]);

        Config::$serverKey = config('services.midtrans.erverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        ///Call Transaction
        $transaction = Transaction::with(['plant', 'user'])->find($transaction->id);

        ///Make Transaksi midTrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => (int) $transaction->total,
            ],
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
            ],
            'enabled_payments' => ['gopay', 'bank_transafer'],
            'vtweb' => []
        ];

        ///Call Midtrans
        try {
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
            $transaction->payment_url = $paymentUrl;
            $transaction->save();

            return ResponseFormatter::success($transaction, 'transaksi berhasil');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Transaksi Gagal');
        }
    }
}
