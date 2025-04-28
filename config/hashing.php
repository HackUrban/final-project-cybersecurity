<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Hash Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default hash driver that will be used to
    | hash passwords for your application and other security-related
    | services. By default, the bcrypt algorithm is used; however,
    | you remain free to modify this value if you wish.
    |
    */

    'driver' => env('HASHING_DRIVER', 'bcrypt'),

    /*
    |--------------------------------------------------------------------------
    | Bcrypt Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the configuration options that should be used
    | when passwords are hashed using the Bcrypt algorithm. This will
    | allow you to control the amount of work (i.e. rounds) the
    | algorithm performs.
    |
    */

    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 10),
    ],

    /*
    |--------------------------------------------------------------------------
    | Argon Options
    |--------------------------------------------------------------------------
    |
    | The Argon2 algorithm has a few configuration options that govern its
    | behavior including memory consumption, time cost, and threads.
    | Note: these options will only be used if you set the driver
    | option above to "argon" or "argon2id".
    |
    */

    'argon' => [
        'memory'   => env('ARGON_MEMORY', 1024),
        'threads'  => env('ARGON_THREADS', 2),
        'time'     => env('ARGON_TIME', 2),
    ],

];
