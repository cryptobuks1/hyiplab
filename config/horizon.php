<?php
$supervisorName   = preg_replace('/ /', '-', env('APP_NAME', 'supervisor-1'));
$supervisorParams = [
    $supervisorName => [
        'connection' => 'redis',
        'queue' => [
            $supervisorName.'-high',
            $supervisorName.'-default',
            $supervisorName.'-low',
            $supervisorName.'-emails'],

        'balance' => env('HORIZON_BALANCE', 'auto'),
        'processes' => env('HORIZON_PROCESSES', 5),
        'tries' => env('HORIZON_TRIES', 3),

        'maxProcesses' => env('HORIZON_MAX_PROCESSES', 5),
        'minProcesses' => env('HORIZON_MIN_PROCESSES', 5),

        'delay' => env('HORIZON_DELAY', 0),
        'memory' => env('HORIZON_MEMORY', 512),
        'timeout' => env('HORIZON_TIMEOUT', 60),
        'sleep' => env('HORIZON_SLEEP', 1),
        'maxTries' => env('HORIZON_MAX_TRIES', 3),
        'force' => env('HORIZON_FORCE', false),
    ],
];

return [

    /*
    |--------------------------------------------------------------------------
    | Horizon Redis Connection
    |--------------------------------------------------------------------------
    |
    | This is the name of the Redis connection where Horizon will store the
    | meta information required for it to function. It includes the list
    | of supervisors, failed jobs, job metrics, and other information.
    |
    */

    'use' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Horizon Redis Prefix
    |--------------------------------------------------------------------------
    |
    | This prefix will be used when storing all Horizon data in Redis. You
    | may modify the prefix when you are running multiple installations
    | of Horizon on the same server so that they don't have problems.
    |
    */

    'prefix' => env('HORIZON_PREFIX', 'horizon:'),

    /*
    |--------------------------------------------------------------------------
    | Queue Wait Time Thresholds
    |--------------------------------------------------------------------------
    |
    | This option allows you to configure when the LongWaitDetected event
    | will be fired. Every connection / queue combination may have its
    | own, unique threshold (in seconds) before this event is fired.
    |
    */

    'waits' => [
        'redis:default' => env('HORIZON_WAITS', 60),
    ],

    /*
    |--------------------------------------------------------------------------
    | Job Trimming Times
    |--------------------------------------------------------------------------
    |
    | Here you can configure for how long (in minutes) you desire Horizon to
    | persist the recent and failed jobs. Typically, recent jobs are kept
    | for one hour while all failed jobs are stored for an entire week.
    |
    */

    'trim' => [
        'recent' => env('HORIZON_TRIM_RECENT', 60),
        'failed' => env('HORIZON_TRIM_FAILED', 10080),
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Worker Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define the queue worker settings used by your application
    | in all environments. These supervisors and settings handle all your
    | queued jobs and will be provisioned by Horizon during deployment.
    |
    */

    'environments' => [
        'production' => $supervisorParams,
        'demo' => $supervisorParams,
        'develop' => $supervisorParams,
        'local' => $supervisorParams,
    ],
];
