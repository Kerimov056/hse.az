@extends('layouts.app')

@php
  $courseTitle = $course->name ?? 'Course';

  // Sağ tərəf menu (istəsən bunu settings ilə də edə bilərik)
  $sideMenu = [
    ['title' => 'E-learning', 'url' => url('az/courses')],
    ['title' => 'International Courses', 'url' => url('az/courses')],
    ['title' => 'Local courses', 'url' => url('az/courses')],
  ];
@endphp

<style>
  .reg-wrap{background:#fff}
  .reg-card{
    background:#fff;
    border:1px solid rgba(0,0,0,.08);
    border-radius: 12px;
    padding: 18px;
  }
  .reg-title{
    display:inline-block;
    background:#c63a46;
    color:#fff;
    padding:10px 14px;
    border-radius: 8px;
    font-weight:700;
    font-size:14px;
    text-transform:none;
  }
  .reg-label{font-weight:700;font-size:13px;margin-bottom:6px}
  .req-star{color:#c63a46}

  .side-box{
    border:1px solid rgba(0,0,0,.08);
    border-radius: 12px;
    overflow:hidden;
    background:#fff;
  }
  .side-link{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:16px 16px;
    text-decoration:none;
    color:#111;
    border-bottom:1px solid rgba(0,0,0,.06);
    font-weight:700;
  }
  .side-link:last-child{border-bottom:0}
  .contact-card{
    background:#c63a46;
    color:#fff;
    border-radius: 12px;
    padding:22px;
  }
  .contact-card .btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border-radius:999px;
    padding:12px 18px;
    text-decoration:none;
    font-weight:800;
    background:#222;
    color:#fff;
    border:0;
  }

  .form-control, .form-select{
    height:44px;
    border-radius:10px;
  }
  textarea.form-control{
    height:auto;
    min-height:120px;
  }

  .submit-btn{
    border-radius:10px;
    padding:12px 18px;
    font-weight:800;
  }
  .note-muted{opacity:.75;font-size:13px}
</style>

<section class="reg-wrap" style="margin-top: 150px">
  <div class="td_height_60 td_height_lg_40"></div>
  <div class="container">
    <div class="row td_gap_y_30">
      <div class="col-lg-8">

        @if(session('ok'))
          <div class="alert alert-success">{{ session('ok') }}</div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger">
            <strong>Fix these:</strong>
            <ul class="mb-0">
              @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="reg-card">
          <div class="mb-3">
            <span class="reg-title">Participant's/student's personal information</span>
          </div>

          <form method="POST" action="{{ route('courses.register.store', $course->id) }}">
            @csrf

            <div class="row g-3">
              <div class="col-md-4">
                <div class="reg-label">Name (as in ID card) <span class="req-star">*</span></div>
                <input class="form-control" name="first_name" value="{{ old('first_name') }}" required>
              </div>
              <div class="col-md-4">
                <div class="reg-label">Surname (as in ID card) <span class="req-star">*</span></div>
                <input class="form-control" name="surname" value="{{ old('surname') }}" required>
              </div>
              <div class="col-md-4">
                <div class="reg-label">Patronymic (as in ID card) <span class="req-star">*</span></div>
                <input class="form-control" name="patronymic" value="{{ old('patronymic') }}" required>
              </div>

              <div class="col-12">
                <div class="reg-label">Name and surname for certificate <span class="req-star">*</span></div>
                <input class="form-control" name="certificate_name" value="{{ old('certificate_name') }}" required>
                <div class="note-muted mt-1">Example: John Smith</div>
              </div>

              <div class="col-md-6">
                <div class="reg-label">Birth date <span class="req-star">*</span></div>
                <input type="date" class="form-control" name="birth_date" value="{{ old('birth_date') }}" required>
              </div>
              <div class="col-md-6">
                <div class="reg-label">Gender <span class="req-star">*</span></div>
                <select class="form-select" name="gender" required>
                  <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select</option>
                  <option value="male" {{ old('gender')==='male' ? 'selected' : '' }}>Male</option>
                  <option value="female" {{ old('gender')==='female' ? 'selected' : '' }}>Female</option>
                  <option value="other" {{ old('gender')==='other' ? 'selected' : '' }}>Other</option>
                </select>
              </div>

              <div class="col-md-6">
                <div class="reg-label">Number of ID card <span class="req-star">*</span></div>
                <input class="form-control" name="id_card_number" value="{{ old('id_card_number') }}" required>
              </div>
              <div class="col-md-6">
                <div class="reg-label">Business E-Mail <span class="req-star">*</span></div>
                <input type="email" class="form-control" name="business_email" value="{{ old('business_email') }}" required>
              </div>

              <div class="col-md-4">
                <div class="reg-label">Telephone</div>
                <input class="form-control" name="telephone" value="{{ old('telephone') }}">
              </div>
              <div class="col-md-4">
                <div class="reg-label">Mobil phone <span class="req-star">*</span></div>
                <input class="form-control" name="mobile_phone" value="{{ old('mobile_phone') }}" required>
              </div>
              <div class="col-md-4">
                <div class="reg-label">Postal code</div>
                <input class="form-control" name="postal_code" value="{{ old('postal_code') }}">
              </div>

              <div class="col-12">
                <div class="reg-label">Company</div>
                <input class="form-control" name="company" value="{{ old('company') }}">
              </div>

              <div class="col-12">
                <div class="reg-label">Position</div>
                <input class="form-control" name="position" value="{{ old('position') }}">
              </div>
            </div>

            <div class="mt-4 mb-3">
              <span class="reg-title">Product or service</span>
            </div>

            <div class="mb-3">
              <div class="reg-label">Name of requested product/service (course and etc) <span class="req-star">*</span></div>
              <input class="form-control"
                     name="requested_product_service"
                     value="{{ old('requested_product_service', $courseTitle) }}"
                     required>
            </div>

            <div class="mt-4 mb-3">
              <span class="reg-title">Additional requirements</span>
            </div>

            <div class="mb-3">
              <div class="reg-label">Any restrictions / special requirements related to learning</div>
              <textarea class="form-control" name="requirements" placeholder="For example: visual impairment / limited mobility, etc.">{{ old('requirements') }}</textarea>
            </div>

            <div class="mt-4 mb-3">
              <span class="reg-title">Additional notes</span>
            </div>

            <div class="mb-3">
              <div class="reg-label">Your additional notes</div>
              <textarea class="form-control" name="notes">{{ old('notes') }}</textarea>
            </div>

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mt-3">
              <label class="d-flex align-items-center gap-2">
                <input type="checkbox" name="remember_me" value="1" {{ old('remember_me') ? 'checked' : '' }}>
                <span class="note-muted">Remember my personal information for the next registration</span>
              </label>

              <button type="submit" class="btn btn-dark submit-btn">Submit</button>
            </div>

          </form>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="side-box mb-3">
          @foreach($sideMenu as $m)
            <a class="side-link" href="{{ $m['url'] }}">
              <span>{{ $m['title'] }}</span>
              <span style="font-size:20px;line-height:1">›</span>
            </a>
          @endforeach
        </div>

        <div class="contact-card text-center">
          <h3 style="font-weight:900;margin-bottom:14px;">You can contact us<br>with additional<br>questions.</h3>
          <a href="{{ url('az/contact') }}" class="btn">CONTACT US</a>
        </div>
      </div>

    </div>
  </div>
  <div class="td_height_120 td_height_lg_80"></div>
</section>
