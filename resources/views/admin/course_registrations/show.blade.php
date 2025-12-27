@extends('layouts.admin')

@section('title', 'Registration Details')

@push('styles')
<style>
  .box { border:1px solid rgba(148,163,184,.25); border-radius: .75rem; padding: 16px; background:#fff; }
  .k { font-size:12px; opacity:.7; margin-bottom:6px; }
  .v { font-weight:800; }
  .sep { height:1px; background:rgba(148,163,184,.25); margin:14px 0; }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">

  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
      <h1 class="h3 m-0">Registration Details</h1>
      <div class="text-muted small">
        #{{ $it->id }} • {{ optional($it->created_at)->format('d.m.Y H:i') }}
      </div>
    </div>

    <div class="d-flex gap-2">
      <a href="{{ route('admin.course-registrations.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Geri
      </a>

      @if($it->course)
        <a href="{{ route('course-details', $it->course->id) }}" target="_blank" class="btn btn-outline-primary">
          <i class="bi bi-box-arrow-up-right"></i> Course page
        </a>
      @endif

      <form action="{{ route('admin.course-registrations.destroy', $it) }}"
            method="POST" onsubmit="return confirm('Silmək istəyirsiniz?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger"><i class="bi bi-trash"></i> Sil</button>
      </form>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-lg-8">
      <div class="box">
        <div class="h5 mb-3">Participant info</div>

        <div class="row g-3">
          <div class="col-md-4">
            <div class="k">Name</div>
            <div class="v">{{ $it->first_name }}</div>
          </div>
          <div class="col-md-4">
            <div class="k">Surname</div>
            <div class="v">{{ $it->surname }}</div>
          </div>
          <div class="col-md-4">
            <div class="k">Patronymic</div>
            <div class="v">{{ $it->patronymic }}</div>
          </div>

          <div class="col-12">
            <div class="k">Certificate name</div>
            <div class="v">{{ $it->certificate_name }}</div>
          </div>

          <div class="col-md-4">
            <div class="k">Birth date</div>
            <div class="v">{{ optional($it->birth_date)->format('d.m.Y') }}</div>
          </div>

          <div class="col-md-4">
            <div class="k">Gender</div>
            <div class="v">{{ ucfirst($it->gender) }}</div>
          </div>

          <div class="col-md-4">
            <div class="k">ID card number</div>
            <div class="v">{{ $it->id_card_number }}</div>
          </div>

          <div class="sep"></div>

          <div class="col-md-6">
            <div class="k">Business email</div>
            <div class="v">{{ $it->business_email }}</div>
          </div>

          <div class="col-md-3">
            <div class="k">Telephone</div>
            <div class="v">{{ $it->telephone ?: '—' }}</div>
          </div>

          <div class="col-md-3">
            <div class="k">Mobile phone</div>
            <div class="v">{{ $it->mobile_phone }}</div>
          </div>

          <div class="col-md-4">
            <div class="k">Postal code</div>
            <div class="v">{{ $it->postal_code ?: '—' }}</div>
          </div>

          <div class="col-md-4">
            <div class="k">Company</div>
            <div class="v">{{ $it->company ?: '—' }}</div>
          </div>

          <div class="col-md-4">
            <div class="k">Position</div>
            <div class="v">{{ $it->position ?: '—' }}</div>
          </div>
        </div>

        <div class="sep"></div>

        <div class="h5 mb-2">Request</div>
        <div class="k">Requested product/service</div>
        <div class="v mb-3">{{ $it->requested_product_service }}</div>

        <div class="k">Additional requirements</div>
        <div class="mb-3">{{ $it->requirements ?: '—' }}</div>

        <div class="k">Additional notes</div>
        <div>{{ $it->notes ?: '—' }}</div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="box">
        <div class="h5 mb-3">Course</div>
        @if($it->course)
          <div class="k">Course name</div>
          <div class="v mb-2">{{ $it->course->name }}</div>

          @if(!empty($it->course->courseUrl))
            <div class="k">Course URL</div>
            <div class="mb-2">
              <a href="{{ $it->course->courseUrl }}" target="_blank">{{ $it->course->courseUrl }}</a>
            </div>
          @endif
        @else
          <div class="text-muted">Course not found.</div>
        @endif

        <div class="sep"></div>

        <div class="k">Remember me</div>
        <div class="v">{{ $it->remember_me ? 'Yes' : 'No' }}</div>

        <div class="k mt-3">Status</div>
        <div class="v">{{ $it->status }}</div>
      </div>
    </div>

  </div>
</div>
@endsection
