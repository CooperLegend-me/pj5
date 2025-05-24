<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $orders = Order::where('user_id', Auth::id())->latest()->get();
            return view('orders.index', compact('orders'));
        } catch (\Exception $e) {
            Log::error('Error retrieving orders: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'exception' => $e
            ]);
            return redirect()->back()->with('error', 'Error retrieving orders');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $this->authorize('create', Order::class);
            return view('orders.create');
        } catch (\Exception $e) {
            Log::error('Error accessing create order page: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'exception' => $e
            ]);
            return redirect()->route('orders.index')->with('error', 'Unauthorized access');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('create', Order::class);
            
            Log::info('Received order creation request', [
                'request_data' => $request->all()
            ]);

            $validated = $request->validate([
                'house_type' => 'required|string',
                'roof_type' => 'required|string',
                'foundation_type' => 'required|string',
                'finishing_material' => 'required|string',
                'windows_type' => 'required|string',
                'heating_type' => 'required|string',
                'sewage_type' => 'required|string',
                'construction_time' => 'required|string',
                'additional_services' => 'nullable|array',
                'total_cost' => 'required|numeric|min:0'
            ]);

            Log::info('Data validated successfully', [
                'validated_data' => $validated
            ]);

            $order = Order::create(array_merge($validated, [
                'user_id' => Auth::id(),
                'status' => 'pending'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Заказ успешно создан',
                'redirect' => route('orders.show', $order)
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating order: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'request_data' => $request->all(),
                'exception' => $e
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при создании заказа'
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        try {
            $this->authorize('view', $order);
            return view('orders.show', compact('order'));
        } catch (\Exception $e) {
            Log::error('Error viewing order: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'exception' => $e
            ]);
            return redirect()->route('orders.index')->with('error', 'Unauthorized access');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $this->authorize('update', $order);
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'status' => 'required|in:not_processed,in_progress,completed'
        ]);

        $order->update($validated);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Статус заказа обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('update', $order);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
            'admin_notes' => 'nullable|string'
        ]);

        $order->update($validated);

        return redirect()->back()->with('success', 'Статус заказа обновлен');
    }

    private function calculateTotalCost($data)
    {
        $baseCost = $data['area'] * 15000; // Базовая стоимость за квадратный метр
        $floorMultiplier = 1 + ($data['floors'] - 1) * 0.3; // Множитель за этажи
        $materialMultiplier = $this->getMaterialMultiplier($data['wall_material']);
        
        $totalCost = $baseCost * $floorMultiplier * $materialMultiplier;

        // Добавляем стоимость дополнительных услуг
        if (!empty($data['additional_services'])) {
            foreach ($data['additional_services'] as $service) {
                $totalCost += $this->getServiceCost($service);
            }
        }

        return $totalCost;
    }

    private function getMaterialMultiplier($material)
    {
        $multipliers = [
            'brick' => 1.2,
            'wood' => 1.0,
            'concrete' => 1.1,
            'foam' => 0.9,
            'aeratedConcrete' => 0.95,
            'sipPanels' => 0.85
        ];

        return $multipliers[$material] ?? 1.0;
    }

    private function getServiceCost($service)
    {
        $costs = [
            'designProject' => 50000,
            'landscapeDesign' => 75000,
            'interiorDesign' => 60000,
            'smartHome' => 120000,
            'securitySystem' => 45000,
            'fireplace' => 85000
        ];

        return $costs[$service] ?? 0;
    }

    public function getMessages(Order $order)
    {
        $this->authorize('viewMessages', $order);
        
        $messages = $order->messages()->with('user')->latest()->get();
        
        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    public function sendMessage(Request $request, Order $order)
    {
        try {
            $this->authorize('sendMessage', $order);
            
            $validated = $request->validate([
                'message' => 'required|string|max:1000'
            ]);
            
            $message = $order->messages()->create([
                'user_id' => Auth::id(),
                'message' => $validated['message'],
                'is_admin' => Auth::user()->is_admin
            ]);
            
            $message->load('user');
            
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            \Log::error('Ошибка при отправке сообщения: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при отправке сообщения'
            ], 500);
        }
    }
}
