     @php
         $fb = setting('social.facebook');
         $tw = setting('social.twitter');
         $ig = setting('social.instagram');
         $pin = setting('social.pinterest'); // fallback üçün saxlayırıq
         $wa = setting('social.whatsapp'); // tercihen wa.me/…
         // LinkedIn: varsa onu götür, yoxdursa Pinterest URL-ni istifadə et
         $li = setting('social.linkedin', $pin);

         // Linkləri təhlükəsiz açmaq üçün atributlar
         $attrs = 'target="_blank" rel="noopener noreferrer"';
     @endphp
     <!-- Start Footer Section -->
     <footer class="td_footer td_style_1">
         <div class="container">
             <div class="td_footer_row">
                 <div class="td_footer_col">
                     {{-- Footer – Site (settings-driven, with site.logo + fallback to branding.logo) --}}
                     @php
                         $siteName = setting('site.name', 'Educve');
                         $phone = setting('site.phone'); // "+23 (000) 68 603"
                         $email = setting('site.email'); // "support@educat.com"
                         $address = setting('site.address'); // "66 broklyn golden street, New York, USA"
                         $tagline = setting(
                             'site.tagline',
                             'Far far away, behind the word mountains, far from the Consonantia, there live the blind texts.',
                         );

                         // 1) site.logo üstünlük; 2) branding.logo fallback
                         $logoPath = setting('site.logo') ?: setting('branding.logo');

                         $logoUrl = null;
                         if ($logoPath) {
                             $logoUrl = \Illuminate\Support\Str::startsWith($logoPath, ['http', '/storage', 'assets/'])
                                 ? asset($logoPath)
                                 : asset('storage/' . ltrim($logoPath, '/'));
                         }

                         // tel: üçün yalnız rəqəm və + saxla
                         $telHref = $phone ? 'tel:' . preg_replace('/[^0-9\+]+/', '', $phone) : null;
                     @endphp

                     <div class="td_footer_widget">
                         <div class="td_footer_text_widget td_fs_18">
                             @if ($logoUrl)
                                 <img src="{{ $logoUrl }}" alt="{{ $siteName }}"
                                     style="max-height:64px; width:auto;">
                             @else
                                 {{-- Logo yoxdursa sənin SVG fallback-ı göstərilir --}}
                                 <svg width="241" height="64" viewBox="0 0 241 64" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                     {{-- ... SVG path-ların burda qalır ... --}}
                                 </svg>
                             @endif

                             {{-- Tagline settings-dən (site.tagline) gəlir, yoxdursa default mətn --}}
                             <p>{{ __('Far far away, behind the word mountains, far from the Consonantia, there live the blind texts.') }}
                             </p>
                         </div>

                         <ul class="td_footer_address_widget td_medium td_mp_0">
                             @if ($phone && $telHref)
                                 <li>
                                     <i class="fa-solid fa-phone-volume"></i>
                                     <a href="{{ $telHref }}">{{ $phone }}</a>
                                 </li>
                                 <li>
                                     <i class="fa-solid fa-phone-volume"></i>
                                     <a href="{{ $telHref }}">(+994) 10 253 23 88</a>
                                 </li>
                             @endif

                             @if ($email)
                                 <li>
                                     <i class="fa-solid fa-envelope"></i>
                                     <a href="mailto:{{ $email }}">{{ $email }}</a>
                                 </li>
                             @endif

                             @if ($address)
                                 <li>
                                     <i class="fa-solid fa-location-dot"></i>
                                     {!! nl2br(e($address)) !!}
                                 </li>
                             @endif
                         </ul>
                     </div>
                 </div>

                 <div class="td_footer_col">
                     <div class="td_footer_widget">
                         <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">
                             {{ __('Navigateion') }}</h2>
                         <ul class="td_footer_widget_menu">
                             <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                             <li><a href="{{ route('faqss') }}">{{ __('Faqs') }}</a></li>
                             <li><a href="{{ route('about') }}">{{ __('About Us') }}</a></li>
                             <li><a href="{{ route('resources') }}">{{ __('Resources') }}</a></li>
                             <li><a href="{{ route('team') }}">{{ __('Team') }}</a></li>
                             <li><a href="{{ route('contact') }}">{{ __('Contact') }}</a></li>
                         </ul>
                     </div>
                 </div>
                 <div class="td_footer_col">
                     <div class="td_footer_widget">
                         <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">
                             {{ __('Courses') }}</h2>
                         <ul class="td_footer_widget_menu">
                             <li><a href="{{ route('courses-grid-view') }}">{{ __('Courses') }}</a></li>
                             <li><a href="{{ route('services') }}">{{ __('Services') }}</a></li>
                             <li><a href="{{ route('topices') }}">{{ __('Topics') }}</a></li>
                             <li><a href="{{ route('vacancies') }}">{{ __('Vacancies') }}</a></li>
                         </ul>
                     </div>
                 </div>
                 <div class="td_footer_col">
                     <div class="td_footer_widget">
                         <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">
                             {{ __('Subscribe now') }}
                         </h2>
                         <div class="td_newsletter td_style_1">
                             <p class="td_mb_20 td_opacity_7">
                                 {{ __('Far far away, behind the word mountains, far from the Consonantia, there live the blind texts.') }}
                             </p>
                             <form class="td_newsletter_form" action="{{ route('subscribe') }}" method="POST"
                                 id="newsletterForm">
                                 @csrf
                                 <input type="email" name="email" class="td_newsletter_input"
                                     placeholder="Email address" required>
                                 <button type="submit" class="td_btn td_style_1 td_radius_30 td_medium">
                                     <span
                                         class="td_btn_in td_white_color td_accent_bg"><span>{{ __('Subscribe now') }}</span></span>
                                 </button>
                             </form>

                             @if (session('sub_ok'))
                                 <div class="alert alert-success mt-2">{{ session('sub_ok') }}</div>
                             @endif

                             <script>
                                 // İstəsən AJAX:
                                 document.getElementById('newsletterForm')?.addEventListener('submit', async function(e) {
                                     if (!this.hasAttribute('data-ajax')) return; // istəsən attribute ilə aktiv et
                                     e.preventDefault();
                                     const formData = new FormData(this);
                                     const res = await fetch(this.action, {
                                         method: 'POST',
                                         headers: {
                                             'X-Requested-With': 'XMLHttpRequest'
                                         },
                                         body: formData
                                     });
                                     const json = await res.json().catch(() => ({}));
                                     alert(json?.message || 'Subscribed.');
                                     this.reset();
                                 });
                             </script>

                         </div>
                         <div class="td_footer_social_btns td_fs_20">
                             @if ($fb)
                                 <a href="{{ $fb }}" class="td_center" {!! $attrs !!}><i
                                         class="fa-brands fa-facebook-f"></i></a>
                             @endif

                             @if ($tw)
                                 <a href="{{ $tw }}" class="td_center" {!! $attrs !!}><i
                                         class="fa-brands fa-x-twitter"></i></a>
                             @endif

                             @if ($ig)
                                 <a href="{{ $ig }}" class="td_center" {!! $attrs !!}><i
                                         class="fa-brands fa-instagram"></i></a>
                             @endif

                             {{-- Pinterest göstərilmir. Onun yerinə LinkedIn gəlir (Pinterest URL fallback kimi) --}}
                             @if ($li)
                                 <a href="{{ $li }}" class="td_center" {!! $attrs !!}><i
                                         class="fa-brands fa-linkedin-in"></i></a>
                             @endif

                             @if ($wa)
                                 <a href="{{ $wa }}" class="td_center" {!! $attrs !!}><i
                                         class="fa-brands fa-whatsapp"></i></a>
                             @endif
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="td_footer_bottom td_fs_18">
             <div class="container">
                 <div class="td_footer_bottom_in">
                     <p class="td_copyright mb-0">{{ __('Copyright') }}</p>
                     <ul class="td_footer_widget_menu">
                         <li><a href="#">{{ __('Terms & Conditions') }}</a></li>
                         <li><a href="#">{{ __('Privacy & Policy') }}</a></li>
                     </ul>
                 </div>
             </div>
         </div>
     </footer>

     <!-- End Footer Section -->

     <!-- Start Scroll Up Button -->
     <div class="td_scrollup">
         <i class="fa-solid fa-arrow-up"></i>
     </div>
     <!-- End Scroll Up Button -->

     <!-- Script -->
     <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
     <script src="{{ asset('assets/js/jquery.slick.min.js') }}"></script>
     <script src="{{ asset('assets/js/odometer.js') }}"></script>
     <script src="{{ asset('assets/js/gsap.min.js') }}"></script>
     <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
     <script src="{{ asset('assets/js/wow.min.js') }}"></script>
     <script src="{{ asset('assets/js/main.js') }}"></script>


     </body>

     </html>
