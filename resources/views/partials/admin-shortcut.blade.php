{{-- resources/views/partials/admin-shortcut.blade.php --}}

@php
    // İstəsən buranı url('/admin') də edə bilərsən
    $adminUrl = route('admin.dashboard');
@endphp

<style>
    .admin-shortcut-wrap {
        position: fixed;
        left: 18px;
        bottom: 18px;
        z-index: 9998; /* chat widget 9999-dursa, bunun bir az altda qalması normaldir */
        pointer-events: none; /* yalnız buton kliklənə bilsin deyə */
    }

    .admin-shortcut-btn {
        pointer-events: auto;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 999px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        background: rgba(15, 23, 42, 0.96);
        color: #f9fafb;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 14px 35px rgba(15, 23, 42, .35);
        transition: transform .12s ease, box-shadow .15s ease, background .15s ease, opacity .15s ease;
        opacity: 0.96;
    }

    .admin-shortcut-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 45px rgba(15, 23, 42, .45);
        background: #020617;
        opacity: 1;
    }

    .admin-shortcut-btn:active {
        transform: translateY(0);
        box-shadow: 0 10px 28px rgba(15, 23, 42, .35);
    }

    .admin-shortcut-icon {
        width: 20px;
        height: 20px;
        border-radius: 999px;
        background: linear-gradient(135deg, #22c55e, #4ade80);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 0 3px rgba(34,197,94,.25);
    }

    .admin-shortcut-icon svg {
        display: block;
    }

    .admin-shortcut-label {
        display: flex;
        flex-direction: column;
        line-height: 1.25;
    }

    .admin-shortcut-label strong {
        font-size: 13px;
    }

    .admin-shortcut-label span {
        font-size: 11px;
        opacity: .75;
    }

    /* Kiçik ekranlarda bir az yuxarı qaldıraq */
    @media (max-width: 575.98px) {
        .admin-shortcut-wrap {
            left: 12px;
            bottom: 80px; /* sağ altda chat bubble varsa, toqquşmasın deyə */
        }
    }
</style>

<div class="admin-shortcut-wrap">
    <a href="{{ $adminUrl }}" class="admin-shortcut-btn">
        <span class="admin-shortcut-icon" aria-hidden="true">
            {{-- shield / panel icon --}}
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 3 6 5v6c0 3.6 2.4 6.7 6 7.9 3.6-1.2 6-4.3 6-7.9V5l-6-2Z"
                      stroke="#022c22" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M10 11.5 11.5 13 14 10.5" stroke="#022c22" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
        <span class="admin-shortcut-label">
            <strong>Admin panel</strong>
            <span>Dashboard-a keçid</span>
        </span>
    </a>
</div>
