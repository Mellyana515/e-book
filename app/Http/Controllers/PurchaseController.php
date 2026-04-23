<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends Controller
{
    public function create(Ebook $ebook)
    {
        if ($ebook->status !== 'published') {
            abort(404);
        }

        if ($ebook->isPurchasedBy(auth()->user())) {
            return redirect()->route('library')->with('info', 'You already own this ebook.');
        }

        // Check for pending purchase
        $existingPurchase = Purchase::where('user_id', auth()->id())
            ->where('ebook_id', $ebook->id)
            ->where('payment_status', 'pending')
            ->first();

        return view('purchases.create', compact('ebook', 'existingPurchase'));
    }

    public function store(Request $request, Ebook $ebook)
    {
        if ($ebook->status !== 'published') {
            abort(404);
        }

        if ($ebook->isPurchasedBy(auth()->user())) {
            return redirect()->route('library')->with('info', 'You already own this ebook.');
        }

        // Prevent duplicate pending
        $exists = Purchase::where('user_id', auth()->id())
            ->where('ebook_id', $ebook->id)
            ->whereIn('payment_status', ['pending', 'approved'])
            ->exists();

        if ($exists) {
            return redirect()->route('library')->with('info', 'You already have a pending or approved purchase for this ebook.');
        }

        $request->validate([
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'notes'         => ['nullable', 'string', 'max:500'],
        ]);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        Purchase::create([
            'user_id'        => auth()->id(),
            'ebook_id'       => $ebook->id,
            'payment_proof'  => $path,
            'payment_status' => 'pending',
            'amount'         => $ebook->price,
            'notes'          => $request->notes,
        ]);

        return redirect()->route('library')->with('success', 'Payment proof submitted! Please wait for admin approval.');
    }
}
