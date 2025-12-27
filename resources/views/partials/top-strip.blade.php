@php
    // Dəstəklənən dillər + flag url-lər
    $supportedLocales = [
        'az' => [
            'label' => 'AZ',
            'flag'  => asset('assets/img/flags/az.jpg'),
        ],
        'en' => [
            'label' => 'EN',
            'flag'  => asset('assets/img/flags/en.jpg'),
        ],
        'ru' => [
            'label' => 'RU',
            'flag'  => asset('assets/img/flags/ru.jpg'),
        ],
    ];

    $currentLocale = app()->getLocale();
    if (! array_key_exists($currentLocale, $supportedLocales)) {
        $currentLocale = 'en';
    }
@endphp

<div class="td_top_header td_heading_bg td_white_color">
    <div class="container" style="max-width:1400px!important;padding:0 16px!important;margin:0 auto!important;">
        <div class="td_top_header_in"
             style="display:flex!important;flex-wrap:wrap!important;align-items:center!important;justify-content:space-between!important;gap:8px!important;width:100%!important;">

            {{-- LEFT: ticker --}}
            <div class="td_top_header_left"
                 style="flex:1 1 220px!important;min-width:0!important;overflow:hidden!important;">
                <div id="tickerLine"
                     style="position:relative!important;overflow:hidden!important;white-space:nowrap!important;font-size:14px!important;font-weight:600!important;color:#ffffff!important;">
                    <span id="tickerInner"
                          style="display:inline-block!important;white-space:nowrap!important;will-change:transform;">
                        {{-- text JS ilə qoyulacaq --}}
                    </span>
                </div>
            </div>

            {{-- RIGHT: auth + lang + flag (search trigger) --}}
            <div class="td_top_header_right"
                 style="display:flex!important;flex-wrap:wrap!important;align-items:center!important;justify-content:flex-end!important;gap:8px!important;flex:0 0 auto!important;">

                {{-- Auth links --}}
                <div style="display:flex!important;align-items:center!important;gap:6px!important;flex-wrap:wrap!important;">
                    @guest
                        <span style="font-size:14px!important;">
                            <a href="{{ route('auth.show', 'login') }}"
                               style="color:#ffffff!important;text-decoration:none!important;">{{ __('Sign in') }}</a>
                            /
                            <a href="{{ route('auth.show', 'register') }}"
                               style="color:#ffffff!important;text-decoration:none!important;">{{ __('Sign up') }}</a>
                        </span>
                    @endguest

                    @auth
                        <span class="td_medium"
                              style="color:#ffffff!important;font-size:14px!important;">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline"
                              style="margin:0!important;">
                            @csrf
                            <button type="submit" class="td_btn td_style_1 td_medium"
                                    style="border-radius:999px!important;border:none!important;padding:0px 14px!important;font-size:13px!important;">
                                <span class="td_btn_in td_white_color td_accent_bg">
                                    <span>{{ __('Log out') }}</span>
                                </span>
                            </button>
                        </form>
                    @endauth
                </div>

                {{-- Language pill + flag (click → header search açılır) --}}
                <div
                    style="
                        display:flex!important;
                        align-items:center!important;
                        gap:8px!important;
                        flex-wrap:nowrap!important;
                        padding:4px 10px!important;
                        border-radius:999px!important;
                        border:1px solid rgba(255,255,255,0.22)!important;
                        background:rgba(15,23,42,0.32)!important;
                        box-shadow:0 8px 20px rgba(15,23,42,0.35)!important;
                        backdrop-filter:blur(10px)!important;
                    ">
                    <select
                        id="topLangSelect"
                        style="
                            border:none!important;
                            outline:none!important;
                            background:transparent!important;
                            color:#ffffff!important;
                            font-size:13px!important;
                            font-weight:600!important;
                            padding:4px 8px 4px 0!important;
                            cursor:pointer!important;
                            min-width:60px!important;
                            border-right:1px solid rgba(255,255,255,0.25)!important;
                        ">
                        @foreach ($supportedLocales as $code => $conf)
                            <option
                                value="{{ $code }}"
                                data-flag="{{ $conf['flag'] }}"
                                data-url="{{ url($code) }}"
                                @selected($code === $currentLocale)
                                style="color:#000!important;"
                            >
                                {{ $conf['label'] }}
                            </option>
                        @endforeach
                    </select>

                    <button type="button"
                            onclick="document.querySelector('.td_search_tobble_btn')?.click()"
                            style="
                                width:30px!important;
                                height:30px!important;
                                border-radius:999px!important;
                                border:none!important;
                                background:rgba(255,255,255,0.16)!important;
                                display:flex!important;
                                align-items:center!important;
                                justify-content:center!important;
                                padding:0!important;
                                cursor:pointer!important;
                                flex-shrink:0!important;
                            ">
                        <img id="topLangFlag"
                             src="{{ $supportedLocales[$currentLocale]['flag'] }}"
                             alt="{{ strtoupper($currentLocale) }} flag"
                             style="width:18px!important;height:18px!important;display:block!important;border-radius:999px!important;object-fit:cover!important;">
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ticker: Welcome əvvəl, sonra Konstitusiya. Hər biri sola gedib çıxır, sonra növbəti gəlir --}}
<script>
  window.addEventListener('load', function () {
    const line = document.getElementById('tickerLine');
    const inner = document.getElementById('tickerInner');
    if (!line || !inner) return;

    const messages = [
      "Welcome to the first health, safety, environment education platform of Azerbaijan.",
      "The Constitution of the Republic of Azerbaijan, Article 35/VI - Everyone has right to work in safe and healthy workplace."
    ];

    let idx = 0;
    let offset = 0;
    let textWidth = 0;
    let containerWidth = 0;

    function setMessage(i) {
      inner.textContent = messages[i] || "";
      // ölçüləri yenilə
      containerWidth = line.offsetWidth;
      textWidth = inner.offsetWidth;

      // sağdan başlasın (containerın sağ kənarından)
      offset = containerWidth;
      inner.style.transform = 'translateX(' + offset + 'px)';
    }

    function step() {
      // sola doğru hərəkət
      offset -= 1;

      // tam soldan çıxıb qurtaranda növbəti mətn
      if (offset < -textWidth) {
        idx = (idx + 1) % messages.length;
        setMessage(idx);
      } else {
        inner.style.transform = 'translateX(' + offset + 'px)';
      }

      requestAnimationFrame(step);
    }

    // ilk mesaj: Welcome
    setMessage(0);

    // 1 saniyə gözlət, sonra hərəkətə başla (istəsən 0 elə)
    setTimeout(() => requestAnimationFrame(step), 800);
  });
</script>

{{-- language change + flag sync --}}
<script>
    (function () {
        const select = document.getElementById('topLangSelect');
        const flagImg = document.getElementById('topLangFlag');
        if (!select || !flagImg) return;

        function updateFlag() {
            const opt = select.options[select.selectedIndex];
            if (!opt) return;
            const flagUrl = opt.getAttribute('data-flag');
            const code = opt.value || '';
            if (flagUrl) {
                flagImg.src = flagUrl;
                flagImg.alt = (code.toUpperCase() || 'LANG') + ' flag';
            }
        }

        updateFlag();

        select.addEventListener('change', function () {
            const opt = this.options[this.selectedIndex];
            if (!opt) return;

            updateFlag();

            const url = opt.getAttribute('data-url');
            if (url) {
                window.location.href = url;
            }
        });
    })();
</script>
