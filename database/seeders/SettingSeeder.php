<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            // — Site
            'site.name'    => 'Educve',
            'site.phone'   => '+23 (000) 68 603',
            'site.email'   => 'support@educat.com',
            'site.address' => '66 broklyn golden street, New York, USA',
            'site.logo'    => 'assets/img/logo.svg',

            // — Social
            'social' => [
                'facebook'  => 'https://fb.com/educve',
                'instagram' => 'https://instagram.com/educve',
                'twitter'   => 'https://twitter.com/educve',
                'pinterest' => 'https://pinterest.com/educve',
                'whatsapp'  => 'https://wa.me/19999999999',
                // 'linkedin' => 'https://www.linkedin.com/company/educve',
            ],

            // — Branding
            'branding' => [
                'logo'    => '/storage/logo.png',
                'favicon' => '/storage/favicon.ico',
            ],

            // — HOME: Hero
            'home.hero' => [
                'kicker'   => 'Knowledge is Power',
                'title'    => '<span>Educve</span> - The Best Place to Invest in your Knowledge',
                'subtitle' => 'A university is a vibrant institution that serves as a hub for higher education and research. It provides a dynamic environment.',
                'cta'      => ['text' => 'View Our Program', 'url'  => 'courses-grid-view.html'],
                'buttons'  => [
                    ['text' => 'Apply Now',    'url' => 'courses-grid-view.html'],
                    ['text' => 'Request Info', 'url' => 'signup.html'],
                    ['text' => 'Chat With Us', 'url' => '#'],
                ],
            ],

            // — HOME: About
            'home.about' => [
                'est_year'   => 'EST 1995',
                'kicker'     => 'About us',
                'title'      => 'The largest & Most Diverse Universities in the United Emirates',
                'subtitle'   => 'Far far away, behind the word mountains, far from the Consonantia...',
                'items'      => [
                    ['title' => 'Graduate Program',     'text' => 'Browse the Undergraduate Degrees'],
                    ['title' => 'Undergraduate Program', 'text' => 'Browse the Undergraduate Degrees'],
                ],
                'image_1'    => 'assets/img/home_1/about_img_1.jpg',
                'image_2'    => 'assets/img/home_1/about_img_2.jpg',
                'circle_img' => 'assets/img/home_1/about_circle_text.svg',
                'video_url'  => 'https://www.youtube.com/embed/rRid6GCJtgc',
                'cta'        => ['text' => 'More About', 'url'  => 'courses-grid-view.html'],
            ],

            // — HOME: Features
            'home.features' => [
                'kicker' => 'CAMPUS',
                'title'  => 'Campus is your Dream Lifestyle',
                'image'  => 'assets/img/home_1/feature_img.jpg',
                'list'   => [
                    ['title' => 'Smart Hostel', 'text' => 'Behind the word mountains...', 'icon' => 'assets/img/icons/feature-1.svg'],
                    ['title' => 'Student Life', 'text' => 'Behind the word mountains...', 'icon' => 'assets/img/icons/feature-2.svg'],
                    ['title' => 'Arts & Clubs', 'text' => 'Behind the word mountains...', 'icon' => 'assets/img/icons/feature-3.svg'],
                    ['title' => 'Sports & Fitness', 'text' => 'Behind the word mountains...', 'icon' => 'assets/img/icons/feature-4.svg'],
                ],
            ],

            // — HOME: Campus
            'home.campus' => [
                'title'    => 'Navigate',
                'subtitle' => 'Far far away, behind the word mountains...',
                'cta'      => ['text' => 'View All Program', 'url' => 'courses-grid-view.html'],
                'cards'    => [
                    ['title' => 'Campus Student Life', 'url' => 'course-details.html', 'image' => 'assets/img/home_1/campur_life_1.jpg'],
                    ['title' => 'Arts & Cultural Program', 'url' => 'course-details.html', 'image' => 'assets/img/home_1/campur_life_2.jpg'],
                    ['title' => 'Recreations & Wellness', 'url' => 'course-details.html', 'image' => 'assets/img/home_1/campur_life_3.jpg'],
                    ['title' => 'Sports & Fitness', 'url' => 'course-details.html', 'image' => 'assets/img/home_1/campur_life_4.jpg'],
                ],
            ],

            // — HOME: Video + Contact
            'home.video' => [
                'bg_image'    => 'assets/img/home_1/video_bg.jpg',
                'heading'     => 'Take a Video Tour to Learn <br>Intro of Campus',
                'youtube_url' => 'https://www.youtube.com/embed/rRid6GCJtgc',
                'contact'     => [
                    'email_label' => 'Get In Touch:',
                    'email'       => 'info@eduon.com',
                    'phone_label' => 'Get In Touch:',
                    'phone'       => '+01 998 7698 870',
                ],
            ],

            // — HOME: Departments
            'home.departments' => [
                'kicker'   => 'Departments',
                'title'    => 'Popular Departments',
                'subtitle' => 'Far far away, behind the word mountains...',
                'list'     => [
                    ['title' => 'Economics', 'icon' => 'assets/img/icons/dep-1.svg'],
                    ['title' => 'Mathematics', 'icon' => 'assets/img/icons/dep-2.svg'],
                    ['title' => 'Physics',    'icon' => 'assets/img/icons/dep-3.svg'],
                ],
            ],

            /**
             * ————— UI SECTION GUIDES —————
             * Səhifə açarları: index, faqs, about-us, resource, course, topices, vacancy, team, contact
             * Hər element:
             *  - selector: DOM selektor (mütləq unikal)
             *  - title: başlıq
             *  - text: mətn (qısa)
             *  - trigger: 'load' | 'enter' (ilkini dərhal göstər, qalanları scroll-da)
             *  - once: true/false (göstərildikdən sonra təkrar göstərmə)
             */
            'ui.guides' => [
                'index' => [
                    'sections' => [
                        ['selector' => '#home-hero',           'title' => 'Başlanğıc paneli',          'text' => 'Ana vitrin: əsas dəyər təklifi, qısa izah və hərəkətə çağırışlar (CTA). Buradan istifadəçi ən qısa marşrutla kurslara və ya müraciətə yönlənir.', 'trigger' => 'load',  'once' => true],
                        ['selector' => '#home-about',          'title' => 'Haqqımızda (qısa icmal)',   'text' => 'Missiya, yanaşma və əsas üstünlüklər. İki şəkilli kompozisiya və dairəvi video düyməsi vizual etibarı yüksəldir; CTA isə uzun “About” səhifəsinə aparır.',                   'trigger' => 'enter', 'once' => true],
                        ['selector' => '#home-courses',        'title' => 'Populyar kurslar',          'text' => 'Tablarla “Courses/Services/Topics/Vacancies” bölmələrinə keçid. Kartlar vahid hündürlükdədir, başlıq və təsvir clamp olunub; “View Details” konversiyanı sadələşdirir.',        'trigger' => 'enter', 'once' => true],
                        ['selector' => '#home-features',       'title' => 'Üstünlüklər (Campus)',      'text' => 'Şəkil + mətn kombinasiyası ilə dəyər təklifi: infrastruktur, mentor dəstəyi, praktik layihələr və ölçülə bilən nəticələr. 4 maddəlik siyahı fokus yaradır.',                     'trigger' => 'enter', 'once' => true],
                        ['selector' => '#home-campus',         'title' => 'Naviqasiya kartları',       'text' => 'Dörd istiqamətə sürətli keçid üçün mozaika kartlar. Hər kartda vizual vurğu, başlıq və kliklə dərhal yönləndirmə — “keçid sürəti” əsas prioritetdir.',                          'trigger' => 'enter', 'once' => true],
                        ['selector' => '#home-resources',      'title' => 'Resurslar & Yükləmələr',    'text' => 'Materiallar PDF/image/video kimi avtomatik önbaxışla göstərilir (pdf.js dəstəyi). “Featured” resurs solda, sağda isə üç kompakt kart — sürətli seçim üçün.',                      'trigger' => 'enter', 'once' => true],
                        ['selector' => '#home-video-contact',  'title' => 'Video təqdimat + əlaqə',    'text' => 'Qısa tanıtım videosu brend tonunu çatdırır; alt hissədə e-poçt və telefon üçün iri CTA qutuları var. Hədəf: sual yaranan kimi minimal sürtünmə ilə əlaqə.',                       'trigger' => 'enter', 'once' => true],
                        ['selector' => '#home-accreditations', 'title' => 'Akkreditasiyalar',          'text' => 'Tərəfdaşlıq və tanınmalar: solda “featured” loqo + tarix, sağda kompakt kartlar. Sosial sübut rolunu oynayır və şübhəni azaldır.',                                              'trigger' => 'enter', 'once' => true],
                        ['selector' => '#home-team',           'title' => 'Komanda hekayəsi',          'text' => 'Ön plana çıxarılan ekspertin foto, qısa bio və bacarıq səviyyələri (progress bar). Yanındakı sürətli əməl düymələri “View Profile / Email / Call” verir.',                        'trigger' => 'enter', 'once' => true],
                        ['selector' => '#home-departments',    'title' => 'Fakültələr',                'text' => '8-lik grid: hər bölmə üçün ikon + başlıq. “Birdən çox maraq nöqtəsi” ssenarisində istifadəçiyə geniş baxış imkanı yaradır.',                                                  'trigger' => 'enter', 'once' => true],
                    ],
                ],

                'faqs'     => ['sections' => [
                    ['selector' => '#faqs-list',   'title' => 'Sual-cavab',  'text' => 'Ən çox verilən suallar.', 'trigger' => 'load',  'once' => true],
                ]],
                'about-us' => [
                    'sections' => [
                        [
                            'selector' => '#about-hero',
                            'title'    => 'Başlanğıc',
                            'text'     => 'Səhifənin hero hissəsi. Buradan ümumi başlıq və breadcrumb görünür.',
                            'trigger'  => 'load',
                            'once' => true
                        ],
                        [
                            'selector' => '#about-overview',
                            'title'    => 'İcmal',
                            'text'     => 'Haqqımızda bölməsinin əsas məzmunu: iki şəkilli kompozisiya, video düyməsi və CTA.',
                            'trigger'  => 'enter',
                            'once' => true
                        ],
                        [
                            'selector' => '#about-accreditations',
                            'title'    => 'Akkreditasiya',
                            'text'     => 'Tərəfdaş loqoları və cədvəl-akkordeon; sosial sübut və etibar.',
                            'trigger'  => 'enter',
                            'once' => true
                        ],
                        [
                            'selector' => '#about-who',
                            'title'    => 'Kimik?',
                            'text'     => 'Who we are mətni, Vision/Mission kartları və yumşaq scroll animasiyalar.',
                            'trigger'  => 'enter',
                            'once' => true
                        ],
                        [
                            'selector' => '#about-services',
                            'title'    => 'Xidmətlər',
                            'text'     => 'Xidmətlərin qısa siyahısı; kliklə detallı səhifəyə yönləndirmə.',
                            'trigger'  => 'enter',
                            'once' => true
                        ],
                    ],
                ],
                'resource' => ['sections' => [
                    ['selector' => '#resource',    'title' => 'Resurslar',   'text' => 'Materialları buradan tap.', 'trigger' => 'load', 'once' => true],
                ]],

                // COURSES GRID VIEW (əvvəl “course” kimi istifadə edirdik) 
                'course'   => ['sections' => [
                    ['selector' => '#courses-hero',   'title' => 'Kurslar',     'text' => 'Bütün kursları burada görürsən. Axtarışla dəqiqləşdir.', 'trigger' => 'load',  'once' => true],
                    ['selector' => '#courses-search', 'title' => 'Axtarış',     'text' => 'Ad və ya təsvirə görə axtar. “Clear” ilə sıfırla.',      'trigger' => 'enter', 'once' => true],
                    ['selector' => '#courses-grid',   'title' => 'Nəticələr',   'text' => 'Kartdan “Details” və ya “Visit” ilə keçid et.',          'trigger' => 'enter', 'once' => true],
                ]],

                'topices'  => ['sections' => [
                    ['selector' => '#topics',      'title' => 'Mövzular',    'text' => 'Mövzuların siyahısı.',     'trigger' => 'load',  'once' => true],
                ]],
                'vacancy'  => ['sections' => [
                    ['selector' => '#vacancy',     'title' => 'Vakansiyalar', 'text' => 'Açıq yerlər.',             'trigger' => 'load',  'once' => true],
                ]],

                // TEAM (real id-lərlə)
                'team'     => ['sections' => [
                    ['selector' => '#team-hero',   'title' => 'Komandamız',  'text' => 'Müəllim və ekspert heyətini tanı.',   'trigger' => 'load',  'once' => true],
                    ['selector' => '#team-search', 'title' => 'Axtarış/Filter', 'text' => 'Ad/vəzifə ilə axtar, cinsə görə süzgəc.', 'trigger' => 'enter', 'once' => true],
                    ['selector' => '#team-grid',   'title' => 'Üzvlər',      'text' => 'Şəklə/ada kliklə detal səhifəsinə keç.', 'trigger' => 'enter', 'once' => true],
                ]],

                'contact'  => ['sections' => [
                    ['selector' => '#contact-hero', 'title' => 'Əlaqə',       'text' => 'Bizimlə əlaqə qur.',       'trigger' => 'load',  'once' => true],
                    ['selector' => '#map',         'title' => 'Xəritə',      'text' => 'Ofisimizin yeri.',          'trigger' => 'enter', 'once' => true],
                ]],

                // ⬇️ YENİ: SERVICES
                'services' => ['sections' => [
                    ['selector' => '#services-hero',  'title' => 'Xidmətlər',    'text' => 'Təklif etdiyimiz bütün xidmətlər.',            'trigger' => 'load',  'once' => true],
                    ['selector' => '#services-search', 'title' => 'Axtarış paneli', 'text' => 'Ad / təsvir üzrə axtar, “Clear” ilə sıfırla.', 'trigger' => 'enter', 'once' => true],
                    ['selector' => '#services-grid',  'title' => 'Kartlar',      'text' => '“Learn More” detal, “Visit” xarici keçiddir.', 'trigger' => 'enter', 'once' => true],
                ]],
            ]
        ];

        foreach ($defaults as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
