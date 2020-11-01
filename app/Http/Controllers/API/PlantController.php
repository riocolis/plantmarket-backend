<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $name = $request->input('name');
        $types = $request->input('types');

        $price_form = $request->input('price_from');
        $price_to = $request->input('price_to');

        $rate_form = $request->input('rate_from');
        $rate_to = $request->input('rate_to');

        if ($id) {
            $plant = Plant::find($id);

            if ($plant) {
                return ResponseFormatter::success(
                    $plant,
                    'Data Produk berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Produk Tidak ada',
                    404
                );
            }
            $plant = Plant::query();

            if ($name) {
                $plant->where('name', 'like', '%' . $name . '%');
            }

            if ($types) {
                $plant->where('types', 'like', '%' . $types . '%');
            }

            if ($price_form) {
                $plant->where('price', '>=', $price_form);
            }

            if ($price_to) {
                $plant->where('price', '<=', $price_to);
            }

            if ($rate_form) {
                $plant->where('rate', '>=', $rate_form);
            }

            if ($rate_to) {
                $plant->where('rate', '<=', $rate_to);
            }

            return ResponseFormatter::success(
                $plant->paginate($limit),
                'Data List produk berhasil diambil'
            );
        }
    }
}
