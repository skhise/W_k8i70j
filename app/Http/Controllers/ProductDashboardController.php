<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contract;
use App\Models\ContractStatus;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductDashboardController extends Controller
{
    /**
     * Product dashboard: KPIs (spares utilized today/week/30d, total products),
     * contract status pie, service status (utilize spares), last updates table.
     */
    public function index(Request $request)
    {
        $dashboard = $this->getProductDashboardData();
        $contractdonut = $this->getContractData();
        $productTypeUtilized = $this->getProductTypeUtilized();
        $lastUpdates = $this->getLastUpdates(10);

        return view('product_dashboard', [
            'dashboard' => $dashboard,
            'contractdonut' => $contractdonut,
            'productTypeUtilized' => $productTypeUtilized,
            'lastUpdates' => $lastUpdates,
        ]);
    }

    /**
     * KPIs: Product used under contract (today, this week, last 30 days), Total products.
     */
    protected function getProductDashboardData(): object
    {
        $today = date('Y-m-d');
        $weekStart = date('Y-m-d', strtotime('monday this week'));
        $weekEnd = date('Y-m-d', strtotime('sunday this week'));
        $thirtyDaysAgo = date('Y-m-d', strtotime('-30 days'));

        $base = Service::query()
            ->whereNull('services.deleted_at')
            ->whereNotNull('services.product_id')
            ->where('services.product_id', '!=', 0)
            ->whereNotNull('services.contract_id')
            ->where('services.contract_id', '!=', 0);

        $sparesToday = (clone $base)->whereDate('services.service_date', $today)->count();
        $sparesWeek = (clone $base)->whereBetween('services.service_date', [$weekStart, $weekEnd])->count();
        $spares30 = (clone $base)->where('services.service_date', '>=', $thirtyDaysAgo)->count();
        $totalProducts = Product::count();

        return (object) [
            'spares_today' => $sparesToday,
            'spares_week' => $sparesWeek,
            'spares_30' => $spares30,
            'total_products' => $totalProducts,
        ];
    }

    protected function getContractData(): array
    {
        $data = [];
        $statuses = ContractStatus::all();
        foreach ($statuses as $s) {
            $count = Contract::where('CNRT_Status', $s->id)->count();
            $data[] = ['name' => $s->contract_status_name, 'value' => $count];
        }
        return $data;
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
     * Last 10 products from products table (same as Products / Spares), ordered by updated_at DESC.
     */
    protected function getLastUpdates(int $limit = 10)
    {
        return Product::query()
            ->leftJoin('master_product_type', 'master_product_type.id', 'products.Product_Type')
            ->orderBy('products.updated_at', 'DESC')
            ->limit($limit)
            ->select([
                'products.Product_ID',
                'products.Product_Name',
                'products.Product_Description',
                'products.Product_Price',
                'products.updated_at',
                'master_product_type.type_name',
            ])
            ->get();
    }
}
