<?php
return 
    [
        'renewal_year' => \Carbon\Carbon::now()->addYears(1)->format('Y'),
        'expires_at' => \Carbon\Carbon::now()->addDays(1)->format('Y-m-d'),
        'check_renewal_date' => \Carbon\Carbon::createFromFormat('Y-m-d', $renwal->expires_at)->format('Y-m-d'),
        'renewal_date' => \Carbon\Carbon::createFromFormat('Y-m-d', $renwal->expires_at)->format('d M, Y')
    ];

// return 
    // [
    //     'renewal_year' => \Carbon\Carbon::now()->format('Y'),
    //     'expires_at' => \Carbon\Carbon::now()->format('Y') .'-12-31',
    //     'check_renewal_date' => \Carbon\Carbon::createFromFormat('Y-m-d', $renwal->expires_at)->addDays(1)->format('Y-m-d'),
    //     'renewal_date' => \Carbon\Carbon::createFromFormat('Y-m-d', $renwal->expires_at)->addDays(1)->format('d M, Y')
    // ];