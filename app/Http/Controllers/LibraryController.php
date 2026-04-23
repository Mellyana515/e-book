<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('ebook')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('library.index', compact('purchases'));
    }

    public function download(Ebook $ebook)
    {
        $purchase = Purchase::where('user_id', auth()->id())
            ->where('ebook_id', $ebook->id)
            ->where('payment_status', 'approved')
            ->firstOrFail();

        if (!$ebook->file_path || !Storage::disk('public')->exists($ebook->file_path)) {
            return back()->with('error', 'File not available.');
        }

        return Storage::disk('public')->download($ebook->file_path, $ebook->title . '.pdf');
    }
}
