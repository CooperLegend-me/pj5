<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $orders = \App\Models\Order::with('user')->latest()->get();

        // Статистика по типу дома
        $houseTypes = [
            'brevna' => 'Бревенчатый дом',
            'brus' => 'Брусчатый дом',
            'kirpich' => 'Кирпичный дом',
            'block' => 'Блочный дом',
        ];
        $stats = [
            'labels' => [],
            'data' => []
        ];
        foreach ($houseTypes as $key => $label) {
            $stats['labels'][] = $label;
            $stats['data'][] = $orders->where('house_type', $key)->count();
        }

        // Группировка сообщений по пользователям и заказам
        $chatMessages = [];
        foreach ($orders as $order) {
            $messages = $order->messages()
                ->with('user')
                ->orderBy('created_at', 'asc')
                ->get();
            
            if ($messages->isNotEmpty()) {
                $chatMessages[$order->user_id] = $messages;
            }
        }

        return view('admin.orders.index', compact('orders', 'stats', 'chatMessages'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
            'admin_notes' => 'nullable|string'
        ]);

        $order->update($validated);

        return redirect()->back()->with('success', 'Статус заказа обновлен');
    }

    public function sendChatMessage(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);
        $userId = $request->user_id;
        $messageText = $request->message;

        // Найти любой заказ пользователя (для привязки сообщения)
        $order = \App\Models\Order::where('user_id', $userId)->latest()->first();
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'У пользователя нет заказов']);
        }
        $message = $order->messages()->create([
            'user_id' => auth()->id(),
            'message' => $messageText,
            'is_admin' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => $message->load('user')
        ]);
    }

    public function getMessages(Order $order)
    {
        $messages = $order->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'order_id' => $message->order_id,
                    'user_id' => $message->user_id,
                    'message' => $message->message,
                    'is_admin' => $message->is_admin,
                    'created_at' => $message->created_at,
                    'updated_at' => $message->updated_at,
                    'user' => [
                        'id' => $message->user->id,
                        'name' => $message->user->name,
                        'email' => $message->user->email,
                        'is_admin' => $message->user->is_admin
                    ]
                ];
            });

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    public function sendMessage(Request $request, Order $order)
    {
        try {
            $validated = $request->validate([
                'message' => 'required|string|max:1000'
            ]);
            
            $message = $order->messages()->create([
                'user_id' => auth()->id(),
                'message' => $validated['message'],
                'is_admin' => true
            ]);
            
            $message->load('user');
            
            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'order_id' => $message->order_id,
                    'user_id' => $message->user_id,
                    'message' => $message->message,
                    'is_admin' => $message->is_admin,
                    'created_at' => $message->created_at,
                    'updated_at' => $message->updated_at,
                    'user' => [
                        'id' => $message->user->id,
                        'name' => $message->user->name,
                        'email' => $message->user->email,
                        'is_admin' => $message->user->is_admin
                    ]
                ]
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

    public function getChatMessages(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $userId = $request->user_id;
        $order = Order::where('user_id', $userId)->latest()->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'У пользователя нет заказов'
            ]);
        }

        $messages = $order->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }
} 