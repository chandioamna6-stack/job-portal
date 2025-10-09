<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Show payment form (upload screenshot, enter transaction ID).
     * Includes a random dummy account number for payment instructions.
     */
    public function create(Job $job)
    {
        // Only job owner (employer) can upgrade
        if (Auth::id() !== $job->user_id || Auth::user()->role !== 'employer') {
            abort(403, 'Unauthorized action.');
        }

        // Generate a random dummy account number (does not need DB)
        $dummyAccount = 'ACC-' . strtoupper(Str::random(8));

        return view('employer.payments.create', compact('job', 'dummyAccount'));
    }

    /**
     * Store payment proof (screenshot, reference, notes).
     */
    public function store(Request $request, Job $job)
    {
        $request->validate([
            'transaction_id' => 'required|string|max:255',
            'screenshot' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048', // allow pdf too
            'notes' => 'nullable|string|max:500',
        ]);

        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store('payments', 'public');
        }

        Payment::create([
            'user_id' => Auth::id(),
            'job_id' => $job->id,
            'amount' => config('payment.premium_fee', 10.00), // configurable
            'transaction_id' => $request->transaction_id,
            'screenshot' => $screenshotPath,
            'notes' => $request->notes,
            'status' => 'pending', // admin will verify later
        ]);

        return redirect()->route('employer.dashboard')
                         ->with('info', 'Payment submitted. Admin will verify and approve.');
    }

    /**
     * Admin approves the payment and activates premium.
     */
    public function approve(Payment $payment)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($payment->status !== 'pending') {
            return back()->with('error', 'This payment has already been processed.');
        }

        $payment->update(['status' => 'approved']);

        $payment->job->update([
            'is_premium' => true,
            'premium_expires_at' => now()->addDays(30),
        ]);

        return back()->with('success', 'Payment approved. Job upgraded to premium!');
    }

    /**
     * Admin rejects the payment.
     */
    public function reject(Payment $payment)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($payment->status !== 'pending') {
            return back()->with('error', 'This payment has already been processed.');
        }

        $payment->update(['status' => 'rejected']);

        return back()->with('error', 'Payment rejected.');
    }

    /**
     * Show all payments for admin review.
     */
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Get latest payments with job & user info
        $payments = Payment::with(['job', 'user'])->latest()->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }
}