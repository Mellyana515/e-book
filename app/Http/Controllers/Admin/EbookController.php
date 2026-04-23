<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EbookController extends Controller
{
    public function index(Request $request)
    {
        $query = Ebook::query();

        if ($search = $request->get('search')) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
        }

        $ebooks = $query->latest()->paginate(15);
        return view('admin.ebooks.index', compact('ebooks'));
    }

    public function create()
    {
        return view('admin.ebooks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'author'      => ['required', 'string', 'max:255'],
            'price'       => ['required', 'numeric', 'min:0'],
            'category'    => ['required', 'string', 'max:100'],
            'status'      => ['required', 'in:draft,published'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'file_path'   => ['nullable', 'file', 'mimes:pdf', 'max:51200'],
        ]);

        $slug = Str::slug($data['title']);
        $original = $slug;
        $count = 1;
        while (Ebook::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count++;
        }
        $data['slug'] = $slug;

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        if ($request->hasFile('file_path')) {
            $data['file_path'] = $request->file('file_path')->store('ebooks', 'public');
        }

        Ebook::create($data);

        return redirect()->route('admin.ebooks.index')->with('success', 'Ebook created successfully.');
    }

    public function edit(Ebook $ebook)
    {
        return view('admin.ebooks.edit', compact('ebook'));
    }

    public function update(Request $request, Ebook $ebook)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'author'      => ['required', 'string', 'max:255'],
            'price'       => ['required', 'numeric', 'min:0'],
            'category'    => ['required', 'string', 'max:100'],
            'status'      => ['required', 'in:draft,published'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'file_path'   => ['nullable', 'file', 'mimes:pdf', 'max:51200'],
        ]);

        if ($request->hasFile('cover_image')) {
            if ($ebook->cover_image) {
                Storage::disk('public')->delete($ebook->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        } else {
            unset($data['cover_image']);
        }

        if ($request->hasFile('file_path')) {
            if ($ebook->file_path) {
                Storage::disk('public')->delete($ebook->file_path);
            }
            $data['file_path'] = $request->file('file_path')->store('ebooks', 'public');
        } else {
            unset($data['file_path']);
        }

        $ebook->update($data);

        return redirect()->route('admin.ebooks.index')->with('success', 'Ebook updated successfully.');
    }

    public function destroy(Ebook $ebook)
    {
        if ($ebook->cover_image) {
            Storage::disk('public')->delete($ebook->cover_image);
        }
        if ($ebook->file_path) {
            Storage::disk('public')->delete($ebook->file_path);
        }
        $ebook->delete();

        return redirect()->route('admin.ebooks.index')->with('success', 'Ebook deleted successfully.');
    }
}
