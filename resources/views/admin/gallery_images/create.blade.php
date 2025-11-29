{{-- resources/views/admin/gallery_images/create.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Yeni Şəkil əlavə et</h1>

    <form action="{{ route('admin.gallery-images.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.gallery_images._form')
        <button type="submit" class="btn btn-primary mt-3">Yadda saxla</button>
        <a href="{{ route('admin.gallery-images.index') }}" class="btn btn-secondary mt-3">Geri</a>
    </form>
</div>
@endsection
