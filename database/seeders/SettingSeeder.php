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

            // — Social
            'social' => [
                'facebook'  => 'https://fb.com/educve',
                'instagram' => 'https://instagram.com/educve',
                'twitter'   => 'https://twitter.com/educve',
                'pinterest' => 'https://pinterest.com/educve',
                'whatsapp'  => 'https://wa.me/19999999999',
            ],

            // — Branding
            'branding' => [
                'logo'    => '/storage/logo.png',
                'favicon' => '/storage/favicon.ico',
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

            // — HOME: Features (MAX 4 item)
            'home.features' => [
                'kicker' => 'CAMPUS',
                'title'  => 'Campus is your Dream Lifestyle',
                'image'  => 'assets/img/home_1/feature_img.jpg',
                'list'   => [
                    [
                        'title' => 'Smart Hostel',
                        'text'  => 'Behind the word mountains, far from the Conso there live the blind texts',
                        'icon'  => 'assets/img/icons/feature-1.svg', // default asset icon
                    ],
                    [
                        'title' => 'Student Life',
                        'text'  => 'Behind the word mountains, far from the Conso there live the blind texts',
                        'icon'  => 'assets/img/icons/feature-2.svg',
                    ],
                    [
                        'title' => 'Arts & Clubs',
                        'text'  => 'Behind the word mountains, far from the Conso there live the blind texts',
                        'icon'  => 'assets/img/icons/feature-3.svg',
                    ],
                    [
                        'title' => 'Sports & Fitness',
                        'text'  => 'Behind the word mountains, far from the Conso there live the blind texts',
                        'icon'  => 'assets/img/icons/feature-4.svg',
                    ],
                ],
            ],

            // — HOME: Campus
            'home.campus' => [
                'title'    => 'Navigate',
                'subtitle' => 'Far far away, behind the word mountains...',
                'cta'      => ['text' => 'View All Program', 'url' => 'courses-grid-view.html'],
                'cards'    => [
                    ['title' => 'Campus Student Life',    'url' => 'course-details.html', 'image' => 'assets/img/home_1/campur_life_1.jpg'],
                    ['title' => 'Arts & Cultural Program', 'url' => 'course-details.html', 'image' => 'assets/img/home_1/campur_life_2.jpg'],
                    ['title' => 'Recreations & Wellness', 'url' => 'course-details.html', 'image' => 'assets/img/home_1/campur_life_3.jpg'],
                    ['title' => 'Sports & Fitness',       'url' => 'course-details.html', 'image' => 'assets/img/home_1/campur_life_4.jpg'],
                ],
            ],

            // — HOME: Video
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
        ];

        foreach ($defaults as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
