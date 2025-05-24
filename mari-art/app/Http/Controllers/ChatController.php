<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getMessages(Order $order)
    {
        try {
            Log::info('Попытка получения сообщений', [
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'is_admin' => Auth::user()->is_admin
            ]);

            $this->authorize('viewMessages', $order);
            
            $messages = $order->messages()
                ->with('user')
                ->orderBy('created_at', 'asc')
                ->get();

            Log::info('Сообщения успешно получены', [
                'count' => $messages->count(),
                'order_id' => $order->id
            ]);
                
            return response()->json([
                'success' => true,
                'messages' => $messages->map(function ($message) {
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
                })
            ]);
        } catch (\Exception $e) {
            Log::error('Ошибка при получении сообщений: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'exception' => $e
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при получении сообщений'
            ], 403);
        }
    }

    public function sendMessage(Request $request, Order $order)
    {
        try {
            Log::info('Попытка отправки сообщения', [
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'is_admin' => Auth::user()->is_admin,
                'message' => $request->input('message')
            ]);

            $this->authorize('sendMessage', $order);
            
            $validated = $request->validate([
                'message' => 'required|string|max:1000'
            ]);
            
            $message = $order->messages()->create([
                'user_id' => Auth::id(),
                'message' => $validated['message'],
                'is_admin' => Auth::user()->is_admin
            ]);

            Log::info('Сообщение успешно создано', [
                'message_id' => $message->id,
                'order_id' => $order->id,
                'user_id' => Auth::id()
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
            Log::error('Ошибка при отправке сообщения: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'exception' => $e,
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при отправке сообщения'
            ], 403);
        }
    }
} 