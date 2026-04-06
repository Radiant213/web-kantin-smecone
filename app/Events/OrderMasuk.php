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

class OrderMasuk implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        
        // Log event broadcast in development environment
        if (config('app.debug')) {
            \Log::info('OrderMasuk event broadcasting', [
                'event' => 'OrderMasuk',
                'channel' => 'kios.' . $order->kiosk_id,
                'order_id' => $order->id,
                'kiosk_id' => $order->kiosk_id,
                'user_id' => $order->user_id,
                'status' => $order->status,
                'total' => $order->total,
            ]);
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('kios.' . $this->order->kiosk_id),
        ];
    }
}
