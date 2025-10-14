@props([
    'page' => null, // səhifə açarı: index, faqs, about-us, ...
])

@php
    $page = $page ?: request()->route()?->getName() ?: 'index';
    $cfg = setting("ui.guides.$page", ['sections' => []]);
    $sections = $cfg['sections'] ?? [];
@endphp

@if (!empty($sections))
    <style>
        /* ===== Coach bubble UI (agent + message) ===== */
        .sg-wrap {
            position: fixed;
            z-index: 1060;
            inset: auto auto;
            display: none;
        }

        .sg-card {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            filter: drop-shadow(0 14px 40px rgba(2, 6, 23, .15));
        }

        .sg-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, #c7d2fe 0%, #e0e7ff 100%);
            display: grid;
            place-items: center;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .sg-bubble {
            max-width: 480px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 12px 14px 10px 14px;
            position: relative;
        }

        .sg-bubble::after {
            content: "";
            position: absolute;
            left: -7px;
            bottom: 10px;
            width: 14px;
            height: 14px;
            background: #fff;
            border-left: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            transform: rotate(45deg);
        }

        .sg-title {
            margin: 0 0 4px 0;
            font-weight: 800;
            font-size: 15px;
            color: #0f172a
        }

        .sg-text {
            margin: 0;
            color: #334155;
            font-size: 14px;
            line-height: 1.55
        }

        .sg-actions {
            display: flex;
            gap: 8px;
            margin-top: 10px;
            justify-content: flex-end
        }

        .sg-btn {
            padding: .42rem .78rem;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #0f172a;
            cursor: pointer
        }

        .sg-btn-primary {
            border-color: #4f46e5;
            background: #4f46e5;
            color: #fff
        }

        /* Focused target highlight (incə) */
        .sg-highlight {
            outline: 3px solid #6366f1;
            outline-offset: 3px;
            animation: sgPulse 1.2s ease-in-out infinite alternate
        }

        @keyframes sgPulse {
            from {
                box-shadow: 0 0 0 0 rgba(99, 102, 241, .22)
            }

            to {
                box-shadow: 0 0 0 10px rgba(99, 102, 241, 0)
            }
        }

        @media (max-width:575.98px) {
            .sg-bubble {
                max-width: 80vw
            }

            .sg-avatar {
                width: 54px;
                height: 54px
            }
        }
    </style>

    <!-- Single floating instance -->
    <div class="sg-wrap" id="sgWrap" role="dialog" aria-live="polite">
        <div class="sg-card">
            <div class="sg-avatar" aria-hidden="true">
                {{-- Minimalist human headset SVG (inline, rənglər temaya uyğun) --}}
                <svg width="40" height="40" viewBox="0 0 64 64" fill="none" aria-hidden="true">
                    <defs>
                        <linearGradient id="g1" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0" stop-color="#4f46e5" />
                            <stop offset="1" stop-color="#22c55e" />
                        </linearGradient>
                    </defs>
                    <circle cx="32" cy="32" r="30" fill="url(#g1)" opacity=".10" />
                    <path d="M46 33a14 14 0 1 0-28 0" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" />
                    <path d="M22 34v6a4 4 0 0 0 4 4h4" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" />
                    <rect x="44" y="29" width="6" height="10" rx="3" fill="#4f46e5" opacity=".9" />
                    <circle cx="32" cy="26" r="6" fill="#4f46e5" opacity=".85" />
                    <path d="M41 46c-2.8-4.5-6.5-7-9-7s-6.2 2.5-9 7" stroke="#4f46e5" stroke-width="2"
                        stroke-linecap="round" />
                    <path d="M38 43h4a3 3 0 0 0 3-3" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" />
                </svg>
            </div>
            <div class="sg-bubble">
                <h6 class="sg-title" id="sgTitle"></h6>
                <p class="sg-text" id="sgText"></p>
                <div class="sg-actions">
                    <button type="button" class="sg-btn" id="sgClose">Bağla</button>
                    <button type="button" class="sg-btn sg-btn-primary" id="sgNext">Oldu</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const DATA = @json($sections, JSON_UNESCAPED_UNICODE);
            if (!Array.isArray(DATA) || DATA.length === 0) return;

            const storageKey = 'sg_seen_v1';
            const seen = new Set(JSON.parse(localStorage.getItem(storageKey) || '[]'));

            const wrap = document.getElementById('sgWrap');
            const title = document.getElementById('sgTitle');
            const text = document.getElementById('sgText');
            const nextBt = document.getElementById('sgNext');
            const clsBt = document.getElementById('sgClose');

            let queue = []; // {i}
            let idx = -1;

            function markSeen(sel) {
                seen.add(sel);
                localStorage.setItem(storageKey, JSON.stringify(Array.from(seen)));
            }

            function highlight(el, on) {
                if (on) el.classList.add('sg-highlight');
                else el.classList.remove('sg-highlight');
            }

            function placeNear(el) {
                const r = el.getBoundingClientRect();
                const vw = document.documentElement.clientWidth;
                const pad = 12;

                // Wrap sol-yuxarı koordinat (bulud elə hədəfin alt-solunda dursun)
                const top = Math.max(16, r.bottom + window.scrollY + 8);
                // Ekrandan çıxmasın deyə sola düzəliş
                const left = Math.min(Math.max(16, r.left + window.scrollX), window.scrollX + vw - wrap.offsetWidth -
                    16);

                wrap.style.top = top + 'px';
                wrap.style.left = left + 'px';
            }

            function showItem(k) {
                const item = DATA[k];
                const el = document.querySelector(item.selector);
                if (!el) return false;

                title.textContent = item.title || 'Məlumat';
                text.textContent = item.text || '';

                wrap.style.display = 'block';
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        placeNear(el);
                        highlight(el, true);
                    })
                });
                return true;
            }

            function hide() {
                const prev = document.querySelector('.sg-highlight');
                if (prev) prev.classList.remove('sg-highlight');
                wrap.style.display = 'none';
            }

            function next() {
                hide();
                idx++;
                while (idx < queue.length) {
                    const {
                        i
                    } = queue[idx];
                    if (showItem(i)) return;
                    idx++;
                }
            }

            nextBt.addEventListener('click', () => {
                const cur = queue[idx];
                if (cur) {
                    const it = DATA[cur.i];
                    if (it.once) markSeen(it.selector);
                }
                next();
            });
            clsBt.addEventListener('click', hide);

            window.addEventListener('resize', () => {
                const cur = queue[idx];
                if (cur) {
                    const n = document.querySelector(DATA[cur.i].selector);
                    if (n && wrap.style.display !== 'none') {
                        placeNear(n);
                    }
                }
            });

            // IO – trigger: enter
            const io = new IntersectionObserver((entries) => {
                entries.forEach(ent => {
                    if (!ent.isIntersecting) return;
                    const sel = ent.target.getAttribute('data-sg-sel') || '';
                    const k = DATA.findIndex(x => x.selector === sel && (x.trigger || 'enter') ===
                        'enter');
                    if (k > -1 && !seen.has(sel)) {
                        queue.push({
                            i: k
                        });
                        if (idx === -1) {
                            next();
                        }
                    }
                });
            }, {
                threshold: .5
            });

            function prepare() {
                queue = [];
                DATA.forEach((it, i) => {
                    const sel = it.selector;
                    if (!sel) return;
                    if (it.once && seen.has(sel)) return;
                    const node = document.querySelector(sel);
                    if (!node) return;

                    if ((it.trigger || 'enter') === 'enter') {
                        node.setAttribute('data-sg-sel', sel);
                        io.observe(node);
                    }
                });
            }

            window.addEventListener('load', () => {
                prepare();

                // load-ları növbəyə at
                DATA.forEach((it, i) => {
                    if ((it.trigger || 'enter') === 'load') {
                        const node = document.querySelector(it.selector);
                        if (node && !(it.once && seen.has(it.selector))) {
                            queue.push({
                                i
                            });
                        }
                    }
                });

                setTimeout(() => {
                    if (queue.length && idx === -1) {
                        next();
                    }
                }, 30);
            });
        })();
    </script>
@endif
