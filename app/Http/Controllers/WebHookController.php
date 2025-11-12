<?php

namespace App\Http\Controllers;

use App\Models\PaymentOrder;
use App\Models\UserSubscription;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Midtrans\Notification;
use Midtrans\Config;

class WebhookController extends Controller
{
    public function __invoke(Request $request, MidtransService $midtransService)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = !filter_var(config('services.midtrans.is_sandbox'), FILTER_VALIDATE_BOOLEAN);

        $payload = $request->getContent();
        $notif = json_decode($payload);

        // Validate signature
        if (!$midtransService->validateSignature((array) $notif)) {
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        $orderId = $notif->order_id;
        $transactionStatus = $notif->transaction_status;
        $fraudStatus = $notif->fraud_status ?? null;

        // Find payment order
        $paymentOrder = PaymentOrder::where('order_id', $orderId)->first();

        if (!$paymentOrder) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Handle transaction status
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            if ($fraudStatus == 'challenge') {
                $paymentOrder->update(['status' => 'pending']);
            } else if ($fraudStatus == 'accept') {
                $this->activateSubscription($paymentOrder);
            }
        } else if ($transactionStatus == 'pending') {
            $paymentOrder->update(['status' => 'pending']);
        } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $paymentOrder->update(['status' => 'failed']);
        }

        return response()->json(['status' => 'ok']);
    }

    private function activateSubscription(PaymentOrder $paymentOrder)
    {
        $paymentOrder->update(['status' => 'settlement']);

        // Create user subscription
        UserSubscription::create([
            'user_id' => $paymentOrder->user_id,
            'subscription_plan_id' => $paymentOrder->subscription_plan_id,
            'start_date' => now(),
            'end_date' => now()->addDays($paymentOrder->plan->duration_days),
            'is_active' => true,
            'midtrans_order_id' => $paymentOrder->order_id,
            'payment_status' => 'success',
        ]);

        // Send email notification (opsional)
        // Mail::send(...);
    }
}
