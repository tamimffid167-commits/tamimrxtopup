<?php
// Copy this file to config.php and edit the values. Never upload real API secrets to GitHub.
return [
    'site_name' => 'RX TOPUP',
    'bkash_number' => '01XXXXXXXXX',
    'nagad_number' => '01XXXXXXXXX',
    'payment_note' => 'Send money using the correct merchant/personal payment type instructed by the admin.',
    // Change this before going live. Use a long, unique password.
    'admin_password_hash' => '', // Generate with: php -r "echo password_hash('YOUR_PASSWORD', PASSWORD_DEFAULT), PHP_EOL;"
    'currency' => 'BDT',
];
