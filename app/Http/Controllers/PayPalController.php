<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PayPalController extends Controller
{
    protected $clientId;
    protected $secret;
    protected $baseUrl;

    public function __construct()
    {
        $this->clientId = config('paypal.client_id');
        $this->secret = config('paypal.secret');
        $this->baseUrl = config('paypal.mode') === 'live'
            ? 'https://api-m.paypal.com'
            : 'https://api-m.sandbox.paypal.com';
    }

    /**
     * Step 1: Redirect employer to PayPal to pay for premium job
     */
    public function create($jobId)
    {
        $job = Job::findOrFail($jobId);

        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->post("{$this->baseUrl}/v2/checkout/orders", [
                "intent" => "CAPTURE",
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => 10.00 // Fixed price for premium job
                        ],
                        "description" => "Premium Job Posting: {$job->title}"
                    ]
                ],
                "application_context" => [
                    "return_url" => route('employer.paypal.success', $job->id),
                    "cancel_url" => route('employer.paypal.cancel', $job->id),
                ]
            ]);

        $order = $response->json();

        // Find the approve link and redirect
        foreach ($order['links'] as $link) {
            if ($link['rel'] === 'approve') {
                return redirect($link['href']);
            }
        }

        return back()->with('error', 'Unable to initiate PayPal payment.');
    }

    /**
     * Step 2: Handle success after PayPal payment
     */
    public function success(Request $request, $jobId)
    {
        $job = Job::findOrFail($jobId);
        $token = $request->query('token');

        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->post("{$this->baseUrl}/v2/checkout/orders/{$token}/capture");

        $result = $response->json();

        if (isset($result['status']) && $result['status'] === 'COMPLETED') {
            $job->update([
                'is_premium' => true,
                'premium_expires_at' => now()->addMonth(), // Premium lasts 1 month
            ]);

            return redirect()->route('employer.dashboard')
                             ->with('success', 'Payment successful! Your job is now premium.');
        }

        return redirect()->route('employer.dashboard')
                         ->with('error', 'Payment failed or canceled.');
    }

    /**
     * Step 3: Handle canceled PayPal payment
     */
    public function cancel($jobId)
    {
        return redirect()->route('employer.dashboard')
                         ->with('error', 'Payment canceled.');
    }

    /**
     * Helper: Get PayPal OAuth access token
     */
    public function getAccessToken()
    {
        $response = Http::withBasicAuth($this->clientId, $this->secret)
            ->asForm()
            ->post("{$this->baseUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials'
            ]);

        return $response->json()['access_token'] ?? null;
    }
}