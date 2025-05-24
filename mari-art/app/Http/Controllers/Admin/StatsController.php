<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $timeRange = $request->get('timeRange', 'month');
        $dateFrom = $this->getDateFrom($timeRange);

        $houseTypes = Order::where('created_at', '>=', $dateFrom)
            ->select('house_type', DB::raw('count(*) as count'))
            ->groupBy('house_type')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $this->getHouseTypeName($item->house_type),
                    'count' => $item->count
                ];
            });

        $statuses = Order::where('created_at', '>=', $dateFrom)
            ->select('status_id', DB::raw('count(*) as count'))
            ->groupBy('status_id')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => OrderStatus::find($item->status_id)->name,
                    'count' => $item->count
                ];
            });

        $averageCost = Order::where('created_at', '>=', $dateFrom)
            ->avg('total_cost');

        $totalOrders = Order::where('created_at', '>=', $dateFrom)
            ->count();

        return response()->json([
            'houseTypes' => $houseTypes,
            'statuses' => $statuses,
            'averageCost' => round($averageCost),
            'totalOrders' => $totalOrders
        ]);
    }

    private function getDateFrom($timeRange)
    {
        return match ($timeRange) {
            'week' => now()->subWeek(),
            'month' => now()->subMonth(),
            'year' => now()->subYear(),
            default => now()->subMonth(),
        };
    }

    private function getHouseTypeName($type)
    {
        return match ($type) {
            'brevna' => 'Бревенчатый дом',
            'kirpich' => 'Кирпичный дом',
            'brus' => 'Брусчатый дом',
            default => $type,
        };
    }
} 