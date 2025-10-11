<?php
// database/seeders/SettingSeeder.php
use App\Models\Setting;

$defaults = [
  'site.name'    => 'Educve',
  'site.phone'   => '+23 (000) 68 603',
  'site.email'   => 'support@educat.com',
  'site.address' => '66 broklyn golden street, New York, USA',
  'social'       => [
      'facebook'=>'https://fb.com/educve',
      'instagram'=>'https://instagram.com/educve'
  ],
  'branding'     => ['logo'=>'/storage/logo.png', 'favicon'=>'/storage/favicon.ico'],
];

foreach ($defaults as $k=>$v) {
  \App\Models\Setting::updateOrCreate(['key'=>$k], ['value'=>$v]);
}
