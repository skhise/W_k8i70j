<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\ProductType;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductDashboardController extends Controller
{
    /** Low stock threshold (quantity <= this considered low stock). */
    const LOW_STOCK_THRESHOLD = 10;

    /**
     * Product dashboard: KPIs (total spares, low stock, pending purchases, technician stock,
     * utilize today/week/30d), contract status pie, product type utilized, recent spare utilization.
     */
    public function index(Request $request)
    {
        $dashboard = $this->getProductDashboardData();
        $productTypeUtilized = $this->getProductTypeUtilized();
        $recentSpareUtilization = $this->getRecentSpareUtilization(10);

        return view('product_dashboard', [
            'dashboard' => $dashboard,
            'productTypeUtilized' => $productTypeUtilized,
            'recentSpareUtilization' => $recentSpareUtilization,
        ]);
    }

    /**
     * KPIs: Total spares, low stock items, pending purchases, technician stock (reserved),
     * and utilize spares (today, this week, last 30 days) from service_dc.
     */
    protected function getProductDashboardData(): object
    {
        $today = date('Y-m-d');
        $weekStart = date('Y-m-d', strtotime('monday this week'));
        $weekEnd = date('Y-m-d', strtotime('sunday this week'));
        $thirtyDaysAgo = date('Y-m-d', strtotime('-30 days'));

        $productBase = Product::withoutGlobalScopes();
        $totalSpares = (clone $productBase)->count();
        $lowStockItems = (clone $productBase)->whereRaw('COALESCE(quantity, 0) <= ?', [self::LOW_STOCK_THRESHOLD])->count();
        $pendingPurchases = ProductPurchase::count();
        $technicianStock = (int) DB::table('product_assignment_items')->sum(DB::raw('COALESCE(quantity, 0)'));

        $utilizeBase = DB::table('service_dc_product')
            ->join('service_dc', 'service_dc.id', '=', 'service_dc_product.dc_id')
            ->whereNotNull('service_dc.issue_date');
        $sparesToday = (int) (clone $utilizeBase)->whereDate('service_dc.issue_date', $today)->sum(DB::raw('COALESCE(service_dc_product.quantity, 1)'));
        $sparesWeek = (int) (clone $utilizeBase)->whereBetween(DB::raw('DATE(service_dc.issue_date)'), [$weekStart, $weekEnd])->sum(DB::raw('COALESCE(service_dc_product.quantity, 1)'));
        $spares30 = (int) (clone $utilizeBase)->where('service_dc.issue_date', '>=', $thirtyDaysAgo)->sum(DB::raw('COALESCE(service_dc_product.quantity, 1)'));

        return (object) [
            'total_spares' => $totalSpares,
            'low_stock_items' => $lowStockItems,
            'pending_purchases' => $pendingPurchases,
            'technician_stock' => $technicianStock,
            'spares_today' => $sparesToday,
            'spares_week' => $sparesWeek,
            'spares_30' => $spares30,
        ];
    }

    /**
     * Count of AMC utilized / product used under contract, grouped by product type.
     * Shows all product types; count is 0 when none utilized under contract.
     */
    protected function getProductTypeUtilized(): array
    {
        $colors = ['bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-secondary', 'bg-dark'];
        $countsByType = Service::query()
            ->join('products', 'products.Product_ID', '=', 'services.product_id')
            ->leftJoin('master_product_type', 'master_product_type.id', '=', 'products.Product_Type')
            ->whereNull('services.deleted_at')
            ->whereNull('products.deleted_at')
            ->whereNotNull('services.product_id')
            ->where('services.product_id', '!=', 0)
            ->whereNotNull('services.contract_id')
            ->where('services.contract_id', '!=', 0)
            ->selectRaw('products.Product_Type as type_id, count(*) as value')
            ->groupBy('products.Product_Type')
            ->get()
            ->keyBy('type_id');

        $data = [];
        $allTypes = ProductType::orderBy('type_name')->get();
        foreach ($allTypes as $i => $type) {
            $value = isset($countsByType[$type->id]) ? (int) $countsByType[$type->id]->value : 0;
            $data[] = [
                'name' => $type->type_name ?? 'Unknown',
                'value' => $value,
                'color' => $colors[$i % count($colors)],
            ];
        }
        return $data;
    }

    /**
     * Recent spare utilization: service_dc_product rows with date, technician, spare name, qty, job card, status.
     */
    protected function getRecentSpareUtilization(int $limit = 10)
    {
        return DB::table('service_dc_product')
            ->join('service_dc', 'service_dc.id', '=', 'service_dc_product.dc_id')
            ->join('services', 'services.id', '=', 'service_dc.service_id')
            ->leftJoin('products', 'products.Product_ID', '=', 'service_dc_product.product_id')
            ->leftJoin('employees', 'employees.EMP_ID', '=', 'services.assigned_to')
            ->select([
                'service_dc.issue_date',
                'employees.EMP_Name as technician_name',
                'products.Product_Name as spare_name',
                'service_dc_product.quantity',
                'services.service_no as job_card',
            ])
            ->orderByDesc('service_dc.issue_date')
            ->limit($limit)
            ->get();
    }
}
