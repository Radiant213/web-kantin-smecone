<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $message;

    public function __construct(Order $order, $message = null)
    {
        $this->order = $order;
        $this->message = $message ?? 'Status pesanan Anda telah diperbarui menjadi: ' . str_replace('_', ' ', $order->status);
        
        // Log event broadcast in development environment
        if (config('app.debug')) {
            \Log::info('OrderStatusUpdated event broadcasting', [
                'event' => 'OrderStatusUpdated',
                'channel' => 'user.' . $order->user_id,
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'status' => $order->status,
                'message' => $this->message,
            ]);
        }
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->order->user_id),
        ];
    }
}
