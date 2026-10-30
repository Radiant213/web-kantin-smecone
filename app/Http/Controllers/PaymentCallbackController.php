<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use Exception;

class PaymentCallbackController extends Controller
{
    public function handle(Request $request)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);

        try {
            $notification = new Notification();

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            $paymentType = $notification->payment_type;

            // Search order by order_code
            $order = Order::where('order_code', $orderId)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $this->markAsPaid($order, $paymentType);
                }
            } elseif ($transactionStatus == 'settlement') {
                $this->markAsPaid($order, $paymentType);
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $order->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled',
                ]);
            }

            return response()->json(['message' => 'Notification handled successfully']);
        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::error('Midtrans Callback Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error handling notification: ' . $e->getMessage()], 500);
        }
    }

    private function markAsPaid(Order $order, $paymentType)
    {
        $order->update([
            'payment_status' => 'paid',
            'payment_type' => $paymentType,
            'status' => 'processing',
        ]);

        // Dispatch real-time websocket event
        \App\Events\OrderMasuk::dispatch($order);

        // Push notification to Kiosk vendor
        try {
            $kioskOwnerId = $order->kiosk->user_id;
            $pushService = new \App\Services\WebPushService();
            $pushService->sendToUser($kioskOwnerId, [
                'title' => '🔔 Pesanan Lunas Baru Masuk!',
                'body' => 'Pesanan #' . $order->order_code . ' (Rp ' . number_format($order->total_price, 0, ',', '.') . ') siap dimasak!',
                'url' => route('penjual.orders.index'),
                'tag' => 'order-' . $order->id,
            ]);
        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::error('WebPush Error: ' . $e->getMessage());
        }
    }
}
