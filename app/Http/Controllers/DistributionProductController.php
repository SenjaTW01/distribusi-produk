<?php

namespace App\Http\Controllers;

use App\Models\DistributionDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistributionProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($request->product_id);
            $total = $product->price * $request->qty;

            $detail = DistributionDetail::create([
                'product_id' => $request->product_id,
                'qty' => $request->qty,
                'price' => $product->price,
                'total' => $total,
                'created_by' => auth()->id()
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $detail->load('product')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $detail = DistributionDetail::findOrFail($id);
            $detail->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
