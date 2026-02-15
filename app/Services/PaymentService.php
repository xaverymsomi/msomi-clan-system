<?php

namespace App\Services;

use App\Models\PaymentGateway;
use App\Models\Contribution;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected $gateway;

    public function __construct()
    {
        $this->gateway = PaymentGateway::active();
    }

    /**
     * Initialize a payment transaction.
     */
    public function initializePayment(Contribution $contribution)
    {
        if (!$this->gateway) {
            throw new \Exception("No active payment gateway configured.");
        }

        // Logic based on gateway slug
        switch ($this->gateway->slug) {
            case 'mpesa':
                return $this->initializeMpesa($contribution);
            case 'flutterwave':
                return $this->initializeFlutterwave($contribution);
            default:
                // Generic implementation using base_url from DB
                return $this->initializeGeneric($contribution);
        }
    }

    protected function initializeMpesa(Contribution $contribution)
    {
        // Placeholder for M-Pesa STK Push logic
        // Use $this->gateway->base_url, $this->gateway->api_key, etc.
        Log::info("Initializing M-Pesa payment for contribution #{$contribution->id}");
        
        return [
            'status' => 'success',
            'checkout_url' => null, // M-Pesa usually triggers STK push directly
            'transaction_id' => 'MPESA_' . uniqid()
        ];
    }

    protected function initializeFlutterwave(Contribution $contribution)
    {
        $response = Http::withToken($this->gateway->api_secret)
            ->post($this->gateway->base_url . '/payments', [
                'tx_ref' => 'MSOMI_' . $contribution->id . '_' . time(),
                'amount' => $contribution->amount,
                'currency' => 'TZS',
                'redirect_url' => route('payments.callback'),
                'customer' => [
                    'email' => $contribution->member->user->email ?? 'info@msomiclan.com',
                    'phonenumber' => $contribution->member->phone,
                    'name' => $contribution->member->full_name,
                ],
                'customizations' => [
                    'title' => 'Msomi Clan Contribution',
                    'description' => 'Payment for ' . $contribution->contribution_type,
                ]
            ]);

        if ($response->successful()) {
            return [
                'status' => 'success',
                'checkout_url' => $response->json('data.link'),
                'transaction_id' => $response->json('data.tx_ref')
            ];
        }

        throw new \Exception("Flutterwave initialization failed: " . $response->body());
    }

    protected function initializeGeneric(Contribution $contribution)
    {
        // Custom logic using dynamic URL from DB
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->gateway->api_key,
        ])->post($this->gateway->base_url . '/initiate', [
            'amount' => $contribution->amount,
            'reference' => 'MSOMI_' . $contribution->id,
            'callback' => route('payments.webhook', ['slug' => $this->gateway->slug]),
        ]);

        return $response->json();
    }

    /**
     * Handle webhook from payment gateway.
     */
    public function handleWebhook(string $slug, array $data)
    {
        $gateway = PaymentGateway::where('slug', $slug)->first();
        if (!$gateway) return false;

        // Verify signature if webhook_secret exists
        // ... (Verification logic)

        // Find contribution and update status
        // This is a simplified version
        $transactionId = $data['transaction_id'] ?? null;
        if ($transactionId) {
            $contribution = Contribution::where('gateway_transaction_id', $transactionId)->first();
            if ($contribution) {
                $status = $data['status'] === 'successful' ? 'completed' : 'failed';
                $contribution->update([
                    'status' => $status,
                    'gateway_response' => $data
                ]);
                return true;
            }
        }

        return false;
    }
}
