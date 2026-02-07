<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class ProductPurchaseController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductPurchase::with('product')
            ->orderBy('purchase_date', 'desc')
            ->orderBy('id', 'desc');

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->whereHas('product', function ($sub) use ($term) {
                    $sub->where('Product_Name', 'like', '%' . $term . '%');
                })->orWhere('reference_no', 'like', '%' . $term . '%');
            });
        }

        $purchases = $query->paginate(15)->withQueryString();

        $products = Product::leftJoin('master_product_type', 'master_product_type.id', '=', 'products.Product_Type')
            ->orderBy('products.Product_Name')
            ->select('products.Product_ID', 'products.Product_Name', 'products.Product_Type', 'master_product_type.type_name as product_type_name')
            ->get();

        return view('purchases.index', [
            'purchases' => $purchases,
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', Rule::exists('products', 'Product_ID')],
            'quantity'   => 'required|integer|min:1',
            'purchase_date' => 'required|date',
            'reference_no'  => 'nullable|string|max:100',
            'notes'         => 'nullable|string|max:500',
        ], [
            'product_id.required' => 'Please select a product.',
            'product_id.exists'   => 'Selected product is invalid.',
        ]);

        DB::beginTransaction();
        try {
            $purchase = ProductPurchase::create([
                'product_id'     => $request->product_id,
                'quantity'      => $request->quantity,
                'purchase_date' => $request->purchase_date,
                'reference_no'  => $request->reference_no,
                'notes'         => $request->notes,
            ]);

            if (Schema::hasColumn('products', 'quantity')) {
                Product::where('Product_ID', $request->product_id)->increment('quantity', $request->quantity);
            }

            DB::commit();
            return redirect()->route('purchases')->with('success', 'Purchase added successfully. Product quantity updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('purchases')->with('error', 'Failed to save purchase: ' . $e->getMessage());
        }
    }
}
