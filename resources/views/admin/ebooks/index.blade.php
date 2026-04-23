@extends('layouts.admin')

@section('title', 'Manage Ebooks')
@section('page-title', 'Manage Ebooks')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <form action="{{ route('admin.ebooks.index') }}" method="GET" class="d-flex gap-2" style="max-width: 400px;">
        <input type="text" name="search" class="form-control" placeholder="Search by title or author..."
            value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-primary px-3"><i class="bi bi-search"></i></button>
        @if(request('search'))
            <a href="{{ route('admin.ebooks.index') }}" class="btn btn-outline-secondary px-3"><i class="bi bi-x"></i></a>
        @endif
    </form>
    <a href="{{ route('admin.ebooks.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Add Ebook
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 py-3">Ebook</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Sales</th>
                        <th class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ebooks as $ebook)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    @if($ebook->cover_image)
                                        <img src="{{ asset('storage/' . $ebook->cover_image) }}"
                                            class="rounded-2" style="width: 42px; height: 55px; object-fit: cover;"
                                            alt="{{ $ebook->title }}">
                                    @else
                                        <div class="rounded-2 d-flex align-items-center justify-content-center flex-shrink-0"
                                            style="width: 42px; height: 55px; background: linear-gradient(135deg, #667eea, #764ba2);">
                                            <i class="bi bi-book text-white small"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold">{{ Str::limit($ebook->title, 35) }}</div>
                                        @if($ebook->file_path)
                                            <small class="text-success"><i class="bi bi-filetype-pdf me-1"></i>PDF uploaded</small>
                                        @else
                                            <small class="text-warning"><i class="bi bi-exclamation-triangle me-1"></i>No PDF</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="small">{{ $ebook->author }}</td>
                            <td><span class="badge rounded-pill" style="background-color: #e0e7ff; color: #4f46e5;">{{ $ebook->category }}</span></td>
                            <td class="fw-semibold text-success">${{ number_format($ebook->price, 2) }}</td>
                            <td>
                                @if($ebook->status === 'published')
                                    <span class="badge badge-published rounded-pill">
                                        <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>Published
                                    </span>
                                @else
                                    <span class="badge badge-draft rounded-pill">
                                        <i class="bi bi-circle me-1" style="font-size: 0.5rem;"></i>Draft
                                    </span>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $ebook->approvedPurchases()->count() }} sold</td>
                            <td class="pe-4 text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('ebooks.show', $ebook->slug) }}" class="btn btn-sm btn-outline-secondary" target="_blank" title="Preview">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.ebooks.edit', $ebook) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.ebooks.destroy', $ebook) }}" method="POST"
                                        onsubmit="return confirm('Delete \'{{ addslashes($ebook->title) }}\'? This cannot be undone.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                                No ebooks found.
                                <a href="{{ route('admin.ebooks.create') }}">Add your first ebook</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($ebooks->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $ebooks->withQueryString()->links() }}
    </div>
@endif
@endsection
