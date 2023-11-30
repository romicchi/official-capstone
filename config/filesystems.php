<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [
        
        'hostinger' => [
            'driver' => 'ftp',
            'host' => 'gener-lnulib.site',
            'username' => 'u203878552',
            'password' => 'Generlnu123!',
            'port' => 21,
            'root' => '/public_html',
            'passive' => true,
            'ssl' => true,
            'timeout' => 60,
        ],

        'firebase' => [
            'driver' => 'firebase',
            'project_id' => env('FIREBASE_PROJECT_ID', ''),
            'key_file' => env('FIREBASE_KEY_FILE', ''),
            'bucket' => env('FIREBASE_STORAGE_BUCKET', ''),
            'url' => env('FIREBASE_STORAGE_URL', ''),
            'path_prefix' => env('FIREBASE_STORAGE_PATH_PREFIX', ''),
            'cache_control' => env('FIREBASE_STORAGE_CACHE_CONTROL', ''),
            'gcs' => [
                'projectId' => env('FIREBASE_GCS_PROJECT_ID', ''),
            ],
            'visibility' => 'public',
        ],

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => public_path(),
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
         ],         

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],
    

];
