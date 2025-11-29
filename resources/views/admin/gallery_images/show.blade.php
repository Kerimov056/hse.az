{{-- resources/views/admin/gallery_images/show.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Şəkilə bax</h1>

    <div class="mb-3">
        <img src="{{ $image->image }}" alt="" style="max-width: 400px; height: auto;">
    </div>

    <p><strong>URL:</strong> <a href="{{ $image->image }}" target="_blank">{{ $image->image }}</a></p>

    <a href="{{ route('admin.gallery-images.edit', $image) }}" class="btn btn-warning">Redaktə et</a>
    <a href="{{ route('admin.gallery-images.index') }}" class="btn btn-secondary">Geri</a>

    <form action="{{ route('admin.gallery-images.destroy', $image) }}" method="POST" class="d-inline-block ms-2" onsubmit="return confirm('Silinsin?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Sil</button>
    </form>
</div>
@endsection
