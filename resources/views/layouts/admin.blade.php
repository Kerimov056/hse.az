<!doctype html>
<html lang="az">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin')</title>

    <!-- Bootstrap core -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-w: 260px;
            --sidebar-bg: #0f172a;
            /* slate-900 */
            --sidebar-bg-hover: #111827;
            /* gray-900 */
            --sidebar-fg: #e5e7eb;
            /* gray-200 */
            --sidebar-muted: #94a3b8;
            /* slate-400 */
            --brand-accent: #22c55e;
            /* emerald-500 */
            --surface: #0b1220;
            /* dark surface */
        }

        html,
        body {
            height: 100%;
            background: #0b1220;
        }

        body {
            color: #e5e7eb;
        }

        .app-layout {
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-w);
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #0b1220 100%);
            color: var(--sidebar-fg);
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.04), 0 10px 30px rgba(0, 0, 0, .45);
        }

        .sidebar .brand {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: 1rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .brand .logo-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--brand-accent);
            box-shadow: 0 0 16px var(--brand-accent);
        }

        .brand .title {
            font-weight: 700;
            letter-spacing: .3px;
        }

        .nav-section {
            padding: .5rem .75rem 1.25rem .75rem;
        }

        .nav-section .section-title {
            font-size: .75rem;
            color: var(--sidebar-muted);
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: .5rem 1rem;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            color: var(--sidebar-fg);
            border-radius: .6rem;
            padding: .65rem .9rem;
            transition: background .15s ease, color .15s ease, transform .06s ease;
        }

        .sidebar .nav-link i {
            font-size: 1.1rem;
            color: var(--sidebar-muted);
        }

        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.06);
            transform: translateX(2px);
        }

        .sidebar .nav-link.active {
            background: rgba(34, 197, 94, 0.15);
            color: #fff;
        }

        .sidebar .nav-link.active i {
            color: var(--brand-accent);
        }

        /* Collapse button (mobile) */
        .sidebar-toggle {
            display: none;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                transform: translateX(-100%);
                transition: transform .25s ease;
                z-index: 1040;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-backdrop {
                content: "";
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .5);
                display: none;
                z-index: 1035;
            }

            .sidebar-backdrop.show {
                display: block;
            }

            .sidebar-toggle {
                display: inline-flex;
                align-items: center;
                gap: .5rem;
                margin: .75rem;
            }

            .content header.sticky-head {
                position: sticky;
                top: 0;
                z-index: 1020;
                backdrop-filter: blur(6px);
                background: rgba(11, 18, 32, 0.65);
                border-bottom: 1px solid rgba(255, 255, 255, .06);
            }
        }

        .content {
            flex: 1;
            background: #ffffff;
            /* sağ tərəf ağ */
            color: #0f172a;
            /* tünd mavi-boz mətn */
        }

        .content .container-fluid {
            padding: 1.25rem;
        }

        /* Kartlar və form elementləri light temaya uyğun */
        .card {
            background: #ffffff;
            color: #0f172a;
            border-color: #e5e7eb;
        }

        .form-control,
        .form-select {
            background: #ffffff;
            color: #0f172a;
            border-color: #ced4da;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 .2rem rgba(34, 197, 94, .25);
            border-color: #22c55e;
            /* emerald */
        }

        /* Cədvəllər */
        .table {
            color: #0f172a;
            --bs-table-bg: #fff;
            --bs-table-striped-bg: #f8fafc;
            /* çox açıq stripe */
            --bs-table-hover-bg: #f1f5f9;
            /* hover açıq boz */
        }

        .table thead th {
            background-color: #e5e7eb !important;
        }
        
        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 .2rem rgba(34, 197, 94, .25);
            border-color: var(--brand-accent);
        }

        /* Utility */
        .muted {
            color: var(--sidebar-muted);
        }
    </style>

    @stack('styles')
</head>

<body>
    <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>
    <div class="app-layout">
        <!-- Sidebar -->
        <aside id="appSidebar" class="sidebar">
            <div class="brand">
                <span class="logo-dot"></span>
                <span class="title">Admin</span>
            </div>

            <div class="nav-section">
                <div class="section-title">Panel</div>
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i><span>Dashboard</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-globe2"></i><span>Sayt</span>
                    </a>
                </nav>
            </div>

            <div class="nav-section">
                <div class="section-title">Məzmun</div>
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                        href="{{ route('admin.settings.edit') }}">
                        <i class="bi bi-gear"></i><span>Settings</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.teams.*') ? 'active' : '' }}"
                        href="{{ route('admin.teams.index') }}">
                        <i class="bi bi-people"></i><span>Teams</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}"
                        href="{{ route('admin.faqs.index') }}">
                        <i class="bi bi-question-circle"></i><span>Faqs</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.accreditations.*') ? 'active' : '' }}"
                        href="{{ route('admin.accreditations.index') }}">
                        <i class="bi bi-shield-check"></i><span>Accreditations</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.resource-types.*') ? 'active' : '' }}"
                        href="{{ route('admin.resource-types.index') }}">
                        <i class="bi bi-ui-checks-grid"></i><span>Resource Types</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.resources.*') ? 'active' : '' }}"
                        href="{{ route('admin.resources.index') }}">
                        <i class="bi bi-archive"></i><span>Resources</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.vacancies.*') ? 'active' : '' }}"
                        href="{{ route('admin.vacancies.index') }}">
                        <i class="bi bi-briefcase"></i><span>Vacancies</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.topices.*') ? 'active' : '' }}"
                        href="{{ route('admin.topices.index') }}">
                        <i class="bi bi-chat-left-text"></i><span>Topics</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}"
                        href="{{ route('admin.services.index') }}">
                        <i class="bi bi-grid"></i><span>Services</span>
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}"
                        href="{{ route('admin.courses.index') }}">
                        <i class="bi bi-journal-text"></i><span>Courses</span>
                    </a>
                </nav>
            </div>

            <div class="nav-section pb-4">
                <div class="section-title">Hesab</div>
                <nav class="nav flex-column">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i><span>Çıxış</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </nav>
            </div>
        </aside>

        <!-- Content -->
        <div class="content w-100">
            <header class="sticky-head d-lg-none">
                <button id="sidebarToggle" class="btn btn-outline-light sidebar-toggle" type="button">
                    <i class="bi bi-list"></i>
                    <span>Menü</span>
                </button>
            </header>

            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile sidebar toggle
        const sidebar = document.getElementById('appSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        const toggleBtn = document.getElementById('sidebarToggle');

        function closeSidebar() {
            sidebar.classList.remove('show');
            backdrop.classList.remove('show');
        }

        function openSidebar() {
            sidebar.classList.add('show');
            backdrop.classList.add('show');
        }
        toggleBtn && toggleBtn.addEventListener('click', () => sidebar.classList.contains('show') ? closeSidebar() :
            openSidebar());
        backdrop && backdrop.addEventListener('click', closeSidebar);
    </script>

    {{-- Child view-lardan gələn script stack --}}
    @stack('scripts')
</body>

</html>
