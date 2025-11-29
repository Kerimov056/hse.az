{{-- resources/views/admin/gallery_images/edit.blade.php --}}
@extends('layouts.admin')
@section('content')
<div class="container">
    <h1>Şəkli redaktə et</h1>

    <form action="{{ route('admin.gallery-images.update', $image) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.gallery_images._form')
        <button type="submit" class="btn btn-primary mt-3">Yenilə</button>
        <a href="{{ route('admin.gallery-images.index') }}" class="btn btn-secondary mt-3">Geri</a>
    </form>
</div>
@endsection
