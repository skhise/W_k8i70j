<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class ProductPurchaseController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductPurchase::with(['product', 'vendor'])
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

        return view('purchases.index', $this->indexData($request));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', Rule::exists('products', 'Product_ID')],
            'vendor_input' => 'required|string|max:255',
            'quantity'   => 'required|integer|min:1',
            'purchase_date' => 'required|date',
            'reference_no'  => 'nullable|string|max:100',
            'notes'         => 'nullable|string|max:500',
        ], [
            'product_id.required' => 'Please select a product.',
            'product_id.exists'   => 'Selected product is invalid.',
            'vendor_input.required' => 'Please select or type a vendor name.',
        ]);

        $vendorName = trim($request->vendor_input);
        $vendor = Vendor::firstOrCreate(
            ['name' => $vendorName],
            ['name' => $vendorName]
        );
        $vendorId = $vendor->id;

        DB::beginTransaction();
        try {
            $purchase = ProductPurchase::create([
                'product_id'     => $request->product_id,
                'vendor_id'     => $vendorId,
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

    public function edit(Request $request, ProductPurchase $purchase)
    {
        $purchase->load(['product', 'vendor']);
        $indexData = $this->indexData($request);
        $indexData['editPurchase'] = $purchase;
        return view('purchases.index', $indexData);
    }

    private function indexData(Request $request): array
    {
        $query = ProductPurchase::with(['product', 'vendor'])
            ->orderBy('purchase_date', 'desc')
            ->orderBy('id', 'desc');
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->whereHas('product', fn($sub) => $sub->where('Product_Name', 'like', '%' . $term . '%'))
                    ->orWhere('reference_no', 'like', '%' . $term . '%');
            });
        }
        $products = Product::leftJoin('master_product_type', 'master_product_type.id', '=', 'products.Product_Type')
            ->orderBy('products.Product_Name')
            ->select('products.Product_ID', 'products.Product_Name', 'products.Product_Type', 'master_product_type.type_name as product_type_name')
            ->get();
        $vendors = Vendor::orderBy('name')->get(['id', 'name']);
        return [
            'purchases' => $query->paginate(15)->withQueryString(),
            'products' => $products,
            'vendors' => $vendors,
        ];
    }

    public function update(Request $request, ProductPurchase $purchase)
    {
        $request->validate([
            'product_id' => ['required', Rule::exists('products', 'Product_ID')],
            'vendor_input' => 'required|string|max:255',
            'quantity'   => 'required|integer|min:1',
            'purchase_date' => 'required|date',
            'reference_no'  => 'nullable|string|max:100',
            'notes'         => 'nullable|string|max:500',
        ], [
            'product_id.required' => 'Please select a product.',
            'vendor_input.required' => 'Please select or type a vendor name.',
        ]);

        $vendorName = trim($request->vendor_input);
        $vendor = Vendor::firstOrCreate(
            ['name' => $vendorName],
            ['name' => $vendorName]
        );
        $vendorId = $vendor->id;

        $oldProductId = $purchase->product_id;
        $oldQuantity = $purchase->quantity;
        $newProductId = (int) $request->product_id;
        $newQuantity = (int) $request->quantity;

        DB::beginTransaction();
        try {
            if (Schema::hasColumn('products', 'quantity')) {
                if ($oldProductId === $newProductId) {
                    $diff = $newQuantity - $oldQuantity;
                    if ($diff !== 0) {
                        Product::where('Product_ID', $newProductId)->increment('quantity', $diff);
                    }
                } else {
                    Product::where('Product_ID', $oldProductId)->decrement('quantity', $oldQuantity);
                    Product::where('Product_ID', $newProductId)->increment('quantity', $newQuantity);
                }
            }

            $purchase->update([
                'product_id'   => $newProductId,
                'vendor_id'    => $vendorId,
                'quantity'     => $newQuantity,
                'purchase_date' => $request->purchase_date,
                'reference_no' => $request->reference_no,
                'notes'        => $request->notes,
            ]);

            DB::commit();
            return redirect()->route('purchases')->with('success', 'Purchase updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Failed to update purchase: ' . $e->getMessage());
        }
    }

    public function destroy(ProductPurchase $purchase)
    {
        DB::beginTransaction();
        try {
            if (Schema::hasColumn('products', 'quantity')) {
                Product::where('Product_ID', $purchase->product_id)->decrement('quantity', $purchase->quantity);
            }
            $purchase->delete();
            DB::commit();
            return redirect()->route('purchases')->with('success', 'Purchase deleted successfully. Product quantity updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('purchases')->with('error', 'Failed to delete purchase: ' . $e->getMessage());
        }
    }
}
