<?php

return [

    'default' => env('FILESYSTEM_DISK', 'local'),

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        // >>> GOOGLE CLOUD STORAGE (GCS)
        'gcs' => [
            'driver'        => 'gcs', // <- AppServiceProvider-də extend etdik
            'project_id'    => env('GCP_PROJECT_ID'),
            'bucket'        => env('GCS_BUCKET'),
            'key_file_path' => env('GCP_KEY_FILE'), // relative path də ola bilər, AppServiceProvider base_path() edir
            'api_url'       => env('GCS_PUBLIC_BASE', 'https://storage.googleapis.com'),
            'path_prefix'   => env('GCS_PATH_PREFIX', ''), // məsələn "hse"
            'visibility'    => 'public',
            'throw'         => false,
        ],

    ],

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
