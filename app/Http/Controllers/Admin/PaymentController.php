<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Purchase::with(['user', 'ebook']);

        if ($status = $request->get('status')) {
            $query->where('payment_status', $status);
        }

        $purchases = $query->latest()->paginate(15);
        return view('admin.payments.index', compact('purchases'));
    }

    public function approve(Purchase $purchase)
    {
        $purchase->update(['payment_status' => 'approved']);
        return back()->with('success', "Payment for \"{$purchase->ebook->title}\" approved.");
    }

    public function reject(Request $request, Purchase $purchase)
    {
        $request->validate(['notes' => ['nullable', 'string', 'max:500']]);
        $purchase->update([
            'payment_status' => 'rejected',
            'notes'          => $request->notes ?? $purchase->notes,
        ]);
        return back()->with('success', "Payment for \"{$purchase->ebook->title}\" rejected.");
    }
}
