<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\PaymentGateway;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Initialize payment for a contribution.
     */
    public function initialize(Contribution $contribution)
    {
        $this->authorize('view', $contribution);

        if ($contribution->status === 'completed') {
            return redirect()->route('contributions.show', $contribution)
                ->with('info', __('contributions.already_paid'));
        }

        try {
            $result = $this->paymentService->initializePayment($contribution);

            if ($result['status'] === 'success') {
                // Update contribution with gateway info
                $contribution->update([
                    'gateway_transaction_id' => $result['transaction_id'],
                    'payment_gateway_id' => PaymentGateway::active()->id,
                ]);

                if (isset($result['checkout_url']) && $result['checkout_url']) {
                    return redirect()->away($result['checkout_url']);
                }

                return redirect()->route('contributions.show', $contribution)
                    ->with('success', __('contributions.payment_initiated_check_phone'));
            }

            return back()->with('error', __('contributions.payment_failed_to_initialize'));

        } catch (\Exception $e) {
            Log::error("Payment Error: " . $e->getMessage());
            return back()->with('error', "Payment Error: " . $e->getMessage());
        }
    }

    /**
     * Handle payment callback (redirect).
     */
    public function callback(Request $request)
    {
        // For Flutterwave, check status in request
        $status = $request->status;
        $txRef = $request->tx_ref;

        if ($status === 'successful') {
            return redirect()->route('contributions.my')
                ->with('success', __('contributions.payment_successful_processing'));
        }

        return redirect()->route('contributions.my')
            ->with('error', __('contributions.payment_cancelled_or_failed'));
    }

    /**
     * Handle gateway webhook.
     */
    public function webhook(Request $request, string $slug)
    {
        Log::info("Webhook received for {$slug}: ", $request->all());
        
        $success = $this->paymentService->handleWebhook($slug, $request->all());

        if ($success) {
            return response()->json(['status' => 'ok']);
        }

        return response()->json(['status' => 'failed'], 400);
    }
}
