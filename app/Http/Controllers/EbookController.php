<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Http\Request;

class EbookController extends Controller
{
    public function show(Ebook $ebook)
    {
        if ($ebook->status !== 'published') {
            abort(404);
        }

        $isPurchased = false;
        if (auth()->check()) {
            $isPurchased = $ebook->isPurchasedBy(auth()->user());
        }

        return view('ebooks.show', compact('ebook', 'isPurchased'));
    }
}
