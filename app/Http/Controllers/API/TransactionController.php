<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $plant_id = $request->input('plant_id');
        $status = $request->input('status');

        if ($id) {
            $transaction = Transaction::with(['food', 'user'])->find($id);

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
            $transaction = Transaction::with(['food', 'user'])->where('user_id', Auth::user()->id);

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
}
