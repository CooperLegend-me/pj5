<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        $canView = $user->id === $order->user_id || $user->is_admin;
        
        if (!$canView) {
            Log::warning('Unauthorized order view attempt', [
                'user_id' => $user->id,
                'order_id' => $order->id,
                'is_admin' => $user->is_admin
            ]);
        }
        
        return $canView;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return !$user->is_admin; // Only regular users can create orders
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order): bool
    {
        $canUpdate = $user->is_admin;
        
        if (!$canUpdate) {
            Log::warning('Unauthorized order update attempt', [
                'user_id' => $user->id,
                'order_id' => $order->id,
                'is_admin' => $user->is_admin
            ]);
        }
        
        return $canUpdate;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can send messages.
     */
    public function sendMessage(User $user, Order $order): bool
    {
        $canSendMessage = $user->id === $order->user_id || $user->is_admin;
        
        if (!$canSendMessage) {
            Log::warning('Unauthorized message send attempt', [
                'user_id' => $user->id,
                'order_id' => $order->id,
                'is_admin' => $user->is_admin
            ]);
        }
        
        return $canSendMessage;
    }

    /**
     * Determine whether the user can view messages.
     */
    public function viewMessages(User $user, Order $order): bool
    {
        $canViewMessages = $user->id === $order->user_id || $user->is_admin;
        
        if (!$canViewMessages) {
            Log::warning('Unauthorized message view attempt', [
                'user_id' => $user->id,
                'order_id' => $order->id,
                'is_admin' => $user->is_admin
            ]);
        }
        
        return $canViewMessages;
    }
}
