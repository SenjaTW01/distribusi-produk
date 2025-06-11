<?php

namespace App\Http\Controllers;

use App\Models\Distribution;
use App\Models\User;
use App\Models\Product;
use App\Models\DistributionDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class DistributionController extends Controller
{
    public function index()
    {
        return view('distributions.index');
    }

    public function getData(Request $request)
    {
        $distributions = Distribution::with(['barista', 'details']);

        // Apply date filters
        if ($request->filled('start_date')) {
            $distributions->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $distributions->whereDate('created_at', '<=', $request->end_date);
        }

        // Apply sales filters
        if ($request->filled('min_sales')) {
            $distributions->where('estimated_result', '>=', $request->min_sales);
        }
        if ($request->filled('max_sales')) {
            $distributions->where('estimated_result', '<=', $request->max_sales);
        }
        
        return DataTables::of($distributions->get())
            ->addColumn('date', function($distribution) {
                return $distribution->created_at->format('d/m/Y');
            })
            ->addColumn('barista_name', function($distribution) {
                return $distribution->barista->name;
            })
            ->addColumn('total_qty', function($distribution) {
                return $distribution->total_qty;
            })
            ->addColumn('estimated_result', function($distribution) {
                return $distribution->estimated_result;
            })
            ->addColumn('notes', function($distribution) {
                return $distribution->notes;
            })
            ->addColumn('action', function($distribution) {
                return '<button class="btn btn-info btn-sm detail-btn" data-id="'.$distribution->id.'">Detail</button> '.
                       '<button class="btn btn-danger btn-sm delete-btn" data-id="'.$distribution->id.'">Hapus</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getDetail($id)
    {
        $distribution = Distribution::with(['details.product'])->findOrFail($id);
        return response()->json($distribution);
    }

    public function create()
    {
        $baristas = User::where('active', true)->get();
        return view('distributions.create', compact('baristas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barista_id' => 'required|exists:users,id',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Hitung total qty dan estimated result dari detail sementara
            $details = DistributionDetail::whereNull('distribution_id')
                ->where('created_by', auth()->id())
                ->get();

            if ($details->isEmpty()) {
                throw new \Exception('Tidak ada produk yang ditambahkan');
            }

            $totalQty = $details->sum('qty');
            $estimatedResult = $details->sum('total');

            // Buat distribusi baru
            $distribution = Distribution::create([
                'barista_id' => $request->barista_id,
                'total_qty' => $totalQty,
                'estimated_result' => $estimatedResult,
                'notes' => $request->notes,
                'created_by' => auth()->id()
            ]);

            // Update detail dengan distribution_id
            DistributionDetail::whereNull('distribution_id')
                ->where('created_by', auth()->id())
                ->update(['distribution_id' => $distribution->id]);

            DB::commit();
            return redirect()->route('distributions.index')
                ->with('success', 'Distribusi berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Distribution $distribution)
    {
        try {
            DB::beginTransaction();
            
            // Hapus semua detail distribusi terkait
            $distribution->details()->delete();
            
            // Hapus distribusi itu sendiri
            $distribution->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Distribusi berhasil dihapus.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus distribusi: ' . $e->getMessage()], 500);
        }
    }

    public function getAvailableProducts()
    {
        $products = Product::where('active', true)->get(['id', 'name', 'price']);
        return response()->json($products);
    }
}
