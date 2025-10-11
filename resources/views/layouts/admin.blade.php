<!doctype html>
<html lang="az">
 <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- <-- ƏLAVƏ --}}
  <title>@yield('title','Admin')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  @stack('styles')
</head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary mb-4">
      <div class="container">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin</a>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.edit') }}">Settings</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.teams.index') }}">Teams</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.faqs.index') }}">Faqs</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.accreditations.index') }}">Accreditations</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.resource-types.index') }}">Resources Type</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.resources.index') }}">Resources</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.vacancies.index') }}">Vacancies</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.topices.index') }}">Topices</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.services.index') }}">Service</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.courses.index') }}">Courses</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Site</a></li>
        </ul>
      </div>
    </nav>

    <main class="container py-3">
      @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Child view-lardan gələn script stack --}}
    @stack('scripts')
  </body>
</html>
