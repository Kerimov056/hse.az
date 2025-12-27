{{-- resources/views/partials/info-toast.blade.php --}}

@php
    // Buraya gələn mətni trim edirik
    $infoText = trim((string) ($text ?? ''));
@endphp

@if($infoText !== '')
    <style>
        /* INFO TOAST animasiya – altdan yuxarı qalxma */
        @keyframes infoToastUp {
            0% {
                opacity: 0;
                transform: translateY(40px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div
        id="infoToast"
        style="
            position:fixed;
            left:1.25rem;
            bottom:1.5rem;
            max-width:380px;
            width:min(380px, calc(100% - 24px));
            z-index:9999;
            background:
                radial-gradient(circle at top left, rgba(250,204,21,.18), transparent 55%),
                linear-gradient(135deg, rgba(15,23,42,.97), rgba(30,64,175,.97));
            color:#f9fafb;
            border-radius:18px;
            padding:12px 14px 12px 12px;
            display:flex;
            align-items:flex-start;
            gap:10px;
            opacity:1;
            transform:translateY(0);
            pointer-events:auto;
            box-shadow:0 22px 60px rgba(15,23,42,.9);
            animation: infoToastUp .4s ease-out;
            margin-bottom:10px;
        "
    >
        {{-- Icon --}}
        <div
            style="
                width:40px;
                height:40px;
                border-radius:999px;
                background:radial-gradient(circle at 20% 0%, #facc15, #f97316);
                display:flex;
                align-items:center;
                justify-content:center;
                color:#111827;
                flex-shrink:0;
                box-shadow:0 0 18px rgba(250,204,21,.9);
            "
        >
            <i class="fa-solid fa-lightbulb" style="font-size:19px;"></i>
        </div>

        {{-- Body --}}
        <div style="flex:1; min-width:0;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div
                    style="
                        font-size:.9rem;
                        font-weight:700;
                        color:#facc15;
                        display:flex;
                        align-items:center;
                        gap:.35rem;
                        margin-bottom:4px;
                    "
                >
                    <i class="fa-solid fa-triangle-exclamation" style="font-size:.9rem;"></i>
                    <span>{{ __('Əlavə məlumat') }}</span>
                </div>

                <button
                    type="button"
                    onclick="this.closest('#infoToast').style.display='none';"
                    style="
                        border:none;
                        background:transparent;
                        color:#9ca3af;
                        padding:0;
                        margin-left:4px;
                        cursor:pointer;
                        display:inline-flex;
                        align-items:center;
                        justify-content:center;
                    "
                >
                    <i class="fa-solid fa-xmark" style="font-size:1rem;"></i>
                </button>
            </div>

            <div
                style="
                    font-size:.9rem;
                    color:#e5e7eb;
                    line-height:1.5;
                    max-height:140px;
                    overflow:auto;
                "
            >
                {!! nl2br(e($infoText)) !!}
            </div>
        </div>
    </div>
@endif
