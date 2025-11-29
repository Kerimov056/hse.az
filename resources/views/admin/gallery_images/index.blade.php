@extends('layouts.admin')


@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Qalereya şəkilləri</h1>
        <a href="{{ route('admin.gallery-images.create') }}" class="btn btn-primary">Yeni şəkil</a>
    </div>

    @if(session('ok'))
        <div class="alert alert-success">
            {{ session('ok') }}
        </div>
    @endif

    @if($images->count())
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Şəkil</th>
                    <th>URL</th>
                    <th>Tarix</th>
                    <th style="width: 180px;">Əməliyyatlar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($images as $img)
                    <tr>
                        <td>{{ $img->id }}</td>
                        <td>
                            <img src="{{ $img->image }}" alt="" style="max-width: 100px; height: auto;">
                        </td>
                        <td>
                            <a href="{{ $img->image }}" target="_blank">
                                {{ \Illuminate\Support\Str::limit($img->image, 40) }}
                            </a>
                        </td>
                        <td>{{ $img->created_at?->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.gallery-images.show', $img) }}" class="btn btn-sm btn-info">Bax</a>
                            <a href="{{ route('admin.gallery-images.edit', $img) }}" class="btn btn-sm btn-warning">Redaktə</a>
                            <form action="{{ route('admin.gallery-images.destroy', $img) }}"
                                  method="POST"
                                  class="d-inline-block"
                                  onsubmit="return confirm('Silinsin?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Sil</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $images->links() }}
    @else
        <p>Hələ ki, şəkil yoxdur.</p>
    @endif
</div>
@endsection
