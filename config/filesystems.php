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
        'google' => [
            'driver' => 'google',
            'clientId' => env('GOOGLE_DRIVE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
            'refreshToken' => "1//04swiHDmVgpuyCgYIARAAGAQSNwF-L9IrIl-xTm-5Dib0gvLRT-4z20fhCnROhEIcQrmm1lJokeHCofuqFNyS1jkTOXVROjEAUhU",
            'folderId' => env('GOOGLE_DRIVE_FOLDER_ID'),
        ],
        'key_file' => [
            "type" => "service_account",
            "project_id" => "micro-runner-423009-h3",
            "private_key_id" => "4eec64e3952b9752e0608f9966ef2202de87fb29",
            "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCrsvw/JXKno0PC\nx+08uax+Xp9ty8A9IsW6j1AbYSq9ycnj9UxYsmtOm5L+P0vRsWfumT8kUhVXFclW\nU0IwHPJm6GBVZ4chWpDccES0YAJ2is/dR77frgkH+ANgQAeIbcCWORuRVGyAhbIq\negLXvWBobmRUUdEiIoP/1FMVyW1AloCZgBi0URQBVAUtTVPXswovaL2T+NnIYTVy\njWXKo4YOikNgNM6BG8X1peUFur2x+PI2tzyFUzWhvcQsiiyCliYIGHn4vBu+eHdb\nloiCp4C9LQ138XVZuWMY0mAGLDc63r9fyAdhnZfM+5cGmS4BLGp3a20sf1LGJFDo\n0JmbHtqBAgMBAAECggEALMBieazvhN0LaMXGQkkcufU8tZfhG64n/jejR/eb9cqV\n+fnx875RNLRc7DKgNt/3+Frt97ADSubtSrg5rKOm1IalsSziLiHWVvZWGfNaQP5u\nLj0odVF9nhuY+anGrNr6Us1Ar7Di9N6j8OlLO2LrMVzwfn+ytCRt5iy3mRqehLIo\nJmAnhTdkj2ybugsrAhlhmnfS1eeAvqjWEbtKzk36dQjW5TdS+BleTJjS1cFQqzUu\nTbupzPezd1QchjlKIVJRu7EMjPnAz/tyV1Ei/72avkaVgZW59UHBMEO2suEGP9jc\nBYqIe6D30nWpMwRAecmwvWLl2Fnwed0oGcgcLrI9xwKBgQDZhpO5qlaUUzX/EFnC\nYjPKzRfHPYTryEtPi1x/8N5+a4eLCbjZkEjZDN2wlBDKI+kbF9FgRwyaVLGbjtlt\naR8Q0H6DH1PlY9//hTP0P9BmI8BwlCk+UzR+eYpEJfVnehbFDoW1CpCw60XfLufA\neczomFDxo/9caEj9ZOZLYr3DhwKBgQDKEWmec2faxCcxkrK72HrtpbilJHGY07Fi\nbciaWjI+VN8ghsTZxT6Go4Kqk+B7jctbbzqDhLbtcbJtJXmmKNPb4mVwU2dr0uok\nbGmace9tkaniA8DZI8sAwKEQi1brUObaWgh6ozjxHILwnEzpCxk9j0nK/3ZSIoOK\nYi8U0MaDtwKBgQCAsHFtAi0+iwwC3jV8HoTtkfBjWy3sIA8N/DC5MFMxD4Sc6R+G\n9ylh3464DKDyNdSOxsSD5QS7uSdqFFTlua87T13JTRthNnkqvi9CbQ5pnvUWpVDR\nIoCH4ne+YYaRtVULN9A6jwmS4V3w79sDsAtd/97DVnaYwMmNv8fPCZeiuQKBgF+M\nHkIjVc9XAyVotYUnVvE6dHX6JpDaQL1HJhz+W1Wn8h3CPCCxKOCnPmkEJZimsqrY\njHWV8p2SLol3t+7+zTbi9Y5IkdWlVLvGW6UBDPLldsv9dFn4l8wSSda13HLGvXIw\nMmQy/ADet3eooKFtcxDtyTno0/0AfuyXgqW4FrY/AoGBAJzwf04dEzFM6P1zKwf7\nIqnmNQ2GX522BBxavWOAsBf4YYZQpYQ+u8SUTvRiKZBpWOjpBvrYe+epF6VFKR8j\n5rgIOKm1oc6PFZ56LGMu+d2fNRNez4JPtT0t8CV5Xu/UFeSETybra/nwZs8e0ZtP\nsmaDDFltiUthqytsEA/dH+3J\n-----END PRIVATE KEY-----\n",
            "client_email" => "amcdesk-api@micro-runner-423009-h3.iam.gserviceaccount.com",
            "client_id" => "103482734542886235787",
            "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
            "token_uri" => "https://oauth2.googleapis.com/token",
            "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
            "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/amcdesk-api%40micro-runner-423009-h3.iam.gserviceaccount.com",
            "universe_domain" => "googleapis.com"

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
