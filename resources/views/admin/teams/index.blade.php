@extends('layouts.admin')

@section('content')
<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 m-0">Komanda</h1>
    <a href="{{ route('admin.teams.create') }}" class="btn btn-primary">Yeni əlavə et</a>
  </div>

  <form method="GET" class="row g-2 mb-3">
    <div class="col-md-5">
      <input type="search" class="form-control" name="q" value="{{ $q ?? '' }}" placeholder="Ad və ya vəzifə üzrə axtar…">
    </div>
    <div class="col-md-3">
      <select name="gender" class="form-select">
        <option value="">Bütün cinslər</option>
        <option value="male"   @selected(($gender??'')==='male')>Kişi</option>
        <option value="female" @selected(($gender??'')==='female')>Qadın</option>
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-outline-secondary w-100">Axtar</button>
    </div>
  </form>

  @php
    // Gender-ə uyğun 3×4 default avatar URL-ləri
    $defaultMaleUrl   = 'https://t4.ftcdn.net/jpg/14/05/81/37/360_F_1405813706_e7f6ONwQ8KD8bRbinELfD1jazaXGB5q3.jpg';
    $defaultFemaleUrl = 'https://img.freepik.com/premium-vector/portrait-business-woman_505024-2793.jpg?semt=ais_hybrid&w=740&q=80';
  @endphp

  @if($teams->count())
    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Şəkil</th>
            <th>Ad Soyad</th>
            <th>Vəzifə</th>
            <th>Cins</th>
            <th>Yaradıldı</th>
            <th class="text-end">Əməliyyat</th>
          </tr>
        </thead>
        <tbody>
          @foreach($teams as $i => $t)
            @php
              // Real şəkil varsa onu göstər, yoxdursa gender-ə görə default URL seç
              $thumb = $t->imageUrl
                ? $t->imageUrl
                : ($t->gender === 'female' ? $defaultFemaleUrl : $defaultMaleUrl);
              $fallback = $t->gender === 'female' ? $defaultFemaleUrl : $defaultMaleUrl;
            @endphp
            <tr>
              <td>{{ $teams->firstItem() + $i }}</td>
              <td>
                <img
                  src="{{ $thumb }}"
                  alt="{{ $t->full_name }}"
                  loading="lazy"
                  style="width:48px;height:64px;object-fit:cover;border-radius:6px;border:1px solid #eee"
                  onerror="this.onerror=null; this.src='{{ $fallback }}';"
                >
              </td>
              <td>{{ $t->full_name }}</td>
              <td>{{ $t->position ?: '—' }}</td>
              <td>{{ $t->gender === 'female' ? 'Qadın' : 'Kişi' }}</td>
              <td>{{ optional($t->created_at)->format('d.m.Y H:i') }}</td>
              <td class="text-end">
                <a href="{{ route('admin.teams.show', $t) }}" class="btn btn-sm btn-outline-secondary">Bax</a>
                <a href="{{ route('admin.teams.edit', $t) }}" class="btn btn-sm btn-outline-primary">Redaktə</a>
                <form action="{{ route('admin.teams.destroy', $t) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Silmək istəyirsiniz?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">Sil</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $teams->appends(['q' => $q ?? null, 'gender' => $gender ?? null])->links() }}
    </div>
  @else
    <div class="text-muted">Məlumat yoxdur.</div>
  @endif
</div>
@endsection
