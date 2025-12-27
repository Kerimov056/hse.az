@props([
    'label' => 'Mesaj göndərin',
    'title' => 'Bizə yazın',
])

<style>
:root {
    --cw-accent: #e31b23;
    --cw-ink: #0f172a;
    --cw-muted: #64748b;
    --cw-line: #e5e7eb;
    --cw-bg: #ffffff;
    --cw-shadow: 0 18px 50px rgba(2,6,23,.18);
    --cw-radius: 16px;
}

.cw-fab {
    position: fixed;
    right: 18px; bottom: 18px;
    z-index: 9999;
    display: inline-flex; align-items: center; gap: 10px;
    padding: 12px 16px;
    border-radius: 999px;
    background: var(--cw-accent); color: #fff;
    border: none; cursor: pointer;
    box-shadow: var(--cw-shadow);
    font-weight: 800;
    transition: transform .06s ease, filter .15s ease, box-shadow .2s ease;
}
.cw-fab:hover { filter: brightness(.97) }
.cw-fab:active { transform: translateY(1px) }
.cw-fab .cw-icon {
    width: 22px; height: 22px; display: inline-block;
}

.cw-panel {
    position: fixed;
    right: 18px; bottom: 82px;
    width: min(360px, calc(100vw - 24px));
    max-height: min(78vh, 640px);
    z-index: 9999;
    border-radius: var(--cw-radius);
    background: var(--cw-bg);
    border: 1px solid var(--cw-line);
    box-shadow: var(--cw-shadow);
    overflow: hidden;
    display: none;
}
.cw-panel.is-open { display: flex; flex-direction: column; }

.cw-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 14px;
    background: linear-gradient(180deg, #fff, #fbfbfc);
    border-bottom: 1px solid var(--cw-line);
}
.cw-head .cw-title {
    margin: 0; font-size: 16px; font-weight: 900; color: var(--cw-ink);
}
.cw-close {
    border: 1px solid var(--cw-line);
    background: #fff; border-radius: 10px;
    width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;
    cursor: pointer;
}

.cw-body { padding: 12px; overflow: auto; }

/* INFO BANNER */
.cw-info {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 10px 12px;
    margin-bottom: 10px;
    border-radius: 12px;
    background: #fffbeb;              /* açıq sarı */
    border: 1px solid #facc15;        /* sarı kontur */
}
.cw-info-icon {
    width: 22px;
    height: 22px;
    flex: 0 0 22px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    background: #facc15;
    color: #713f12;
}
.cw-info-text {
    font-size: 13px;
    line-height: 1.4;
    color: #713f12;
}
.cw-info-text strong {
    font-weight: 700;
}

/* Form */
.cw-form .fields {
    display: grid; grid-template-columns: 1fr 1fr; gap: 8px;
}
.cw-form .fields .full { grid-column: 1 / -1; }
.cw-input, .cw-textarea {
    width: 100%; border: 1px solid var(--cw-line); border-radius: 12px;
    padding: 12px 12px; font-size: 14px; outline: none; background: #fff;
    transition: border-color .15s, box-shadow .15s;
}
.cw-input:focus, .cw-textarea:focus {
    border-color: #fecaca; box-shadow: 0 0 0 4px rgba(227,27,35,.08);
}
.cw-textarea { min-height: 120px; resize: vertical; }

.cw-btn {
    margin-top: 10px; width: 100%;
    border: none; border-radius: 12px;
    background: var(--cw-accent); color: #fff; font-weight: 800;
    padding: 12px 16px; cursor: pointer;
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
}
.cw-btn:hover { filter: brightness(.98) }
.cw-btn:active { transform: translateY(1px) }

.cw-footer-hint{
    text-align:center; font-size:12px; color:var(--cw-muted); margin-top:6px;
}

@media (max-width: 575.98px) {
    .cw-fab { right: 12px; bottom: 12px; }
    .cw-panel { right: 12px; bottom: 72px; }
}
</style>

<button type="button" class="cw-fab" id="cwToggle" aria-expanded="false" aria-controls="cwPanel">
    <span class="cw-icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 12L20 4l-5 16-4-6-7-2Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
        </svg>
    </span>
    <span>{{ __($label) }}</span>
</button>

<div class="cw-panel" id="cwPanel" role="dialog" aria-labelledby="cwTitle" aria-modal="true">
    <div class="cw-head">
        <h3 class="cw-title" id="cwTitle">{{ $title }}</h3>
        <button class="cw-close" type="button" id="cwClose" aria-label="Bağla">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 6l12 12M18 6L6 18" stroke="#0f172a" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>
    </div>

    <div class="cw-body">

        {{-- INFO BANNER --}}
        <div class="cw-info">
            <div class="cw-info-icon">
                {{-- lamp / idea icon --}}
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 18h6M10 21h4M9 10a3 3 0 0 1 6 0c0 1.657-1 2.5-1.5 3.5-.21.42-.37.83-.47 1.5h-2.06c-.1-.67-.26-1.08-.47-1.5C10 12.5 9 11.657 9 10Z"
                          stroke="#713f12" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M5 10a7 7 0 1 1 14 0" stroke="#713f12" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
            </div>
       <div class="cw-info-text">
    {!! __('chat.info_block') !!}
</div>
        </div>

        <form class="cw-form" method="POST" action="{{ route('contact.send') }}" id="cwForm" novalidate>
            @csrf
            <div class="fields">
                <input class="cw-input" name="full_name" type="text" placeholder="Adınız və soyadınız *" required>
                <input class="cw-input" name="email" type="email" placeholder="Email *" required>
                <input class="cw-input full" name="phone" type="text" placeholder="+994">
                <input class="cw-input full" name="topic" type="text" placeholder="Mövzu">
                <textarea class="cw-textarea full" name="message" placeholder="Mesajınız *" required></textarea>
            </div>

            <button class="cw-btn" type="submit" id="cwSubmit">
                <span class="btn-text">{{ __("Göndər") }}</span>
                <span class="btn-spin" style="display:none">⏳</span>
            </button>
        </form>

        <div class="cw-footer-hint">
            {{ __("Bu forma") }} <b>{{ __("Əlaqə") }}</b> {{ __("bölməsinə göndəriləcək.") }}
        </div>
    </div>
</div>

<script>
(function() {
    const fab   = document.getElementById('cwToggle');
    const panel = document.getElementById('cwPanel');
    const close = document.getElementById('cwClose');

    function open()  { panel.classList.add('is-open'); fab.setAttribute('aria-expanded','true'); }
    function closeP(){ panel.classList.remove('is-open'); fab.setAttribute('aria-expanded','false'); }

    fab?.addEventListener('click', () => {
        panel.classList.contains('is-open') ? closeP() : open();
    });
    close?.addEventListener('click', closeP);

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && panel.classList.contains('is-open')) closeP();
    });

    const form = document.getElementById('cwForm');
    form?.addEventListener('submit', function () {
        const btn  = document.getElementById('cwSubmit');
        const text = btn?.querySelector('.btn-text');
        const spin = btn?.querySelector('.btn-spin');
        btn.disabled = true;
        if (text && spin) {
            text.style.opacity = .8;
            spin.style.display = 'inline-block';
        }
    });
})();
</script>
