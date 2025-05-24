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
            // Проверяем, что пользователь имеет доступ к заказу
            if (Auth::id() !== $order->user_id && !Auth::user()->is_admin) {
                Log::warning('Unauthorized attempt to view messages', [
                    'user_id' => Auth::id(),
                    'order_id' => $order->id
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            $messages = $order->messages()
                ->with('user')
                ->orderBy('created_at', 'asc')
                ->get();

            Log::info('Messages retrieved successfully', [
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'message_count' => $messages->count()
            ]);

            return response()->json([
                'success' => true,
                'messages' => $messages
            ]);
        } catch (\Exception $e) {
            Log::error('Error retrieving messages: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error retrieving messages'
            ], 500);
        }
    }

    public function sendMessage(Request $request, Order $order)
    {
        try {
            // Проверяем, что пользователь имеет доступ к заказу
            if (Auth::id() !== $order->user_id && !Auth::user()->is_admin) {
                Log::warning('Unauthorized attempt to send message', [
                    'user_id' => Auth::id(),
                    'order_id' => $order->id
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            $validated = $request->validate([
                'message' => 'required|string|max:1000'
            ]);

            $message = $order->messages()->create([
                'user_id' => Auth::id(),
                'message' => $validated['message'],
                'is_admin' => Auth::user()->is_admin
            ]);

            $message->load('user');

            Log::info('Message sent successfully', [
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'message_id' => $message->id
            ]);

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            Log::error('Error sending message: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error sending message'
            ], 500);
        }
    }
} 