<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Exception;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isSanitized = true;
        Config::$is3ds = true;
        Config::$isProduction = !filter_var(
            config('services.midtrans.is_sandbox'),
            FILTER_VALIDATE_BOOLEAN
        );
    }

    /**
     * Create Snap transaction token
     * 
     * @param array $params
     * @return object
     */
    public function createSnapToken(array $params)
    {
        try {
            return Snap::getSnapToken($params);
        } catch (Exception $e) {
            report($e);
            throw $e;
        }
    }

    /**
     * Get transaction status
     * 
     * @param string $orderId
     * @return object
     */
    public function getTransactionStatus(string $orderId)
    {
        try {
            return Transaction::status($orderId);
        } catch (Exception $e) {
            report($e);
            throw $e;
        }
    }

    /**
     * Validate webhook signature
     * 
     * @param array $notifBody
     * @return bool
     */
    public function validateSignature(array $notifBody): bool
    {
        $orderId = $notifBody['order_id'] ?? null;
        $statusCode = $notifBody['status_code'] ?? null;
        $grossAmount = $notifBody['gross_amount'] ?? null;
        $serverKey = config('services.midtrans.server_key');
        $signature = $notifBody['signature_key'] ?? null;

        $input = $orderId . $statusCode . $grossAmount . $serverKey;
        $hash = hash('sha512', $input);

        return hash_equals($hash, $signature);
    }
}
