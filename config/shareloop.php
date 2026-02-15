<?php
// Konfigurácia ShareLoop aplikácie

// ShareLoop Settings
$config['ShareLoop'] = [
    // Verifikácia emailu
    'email_verification_expiry' => '+7 days', // Koľko dni platí verifikačný link

    // QR Codes
    'qr_code_base_url' => 'http://localhost:8765/shareloop', // URL pre QR kódy
    'qr_code_size' => '300x300', // Veľkosť QR kódu

    // ISBN databázy
    'isbn_api_enabled' => true,
    'isbn_providers' => [
        'google_books' => [
            'enabled' => true,
            'api_key' => env('GOOGLE_BOOKS_API_KEY', ''),
        ],
        'open_library' => [
            'enabled' => true,
        ],
    ],

    // Email
    'email_sender' => env('SHARELOOP_EMAIL_SENDER', 'noreply@shareloop.com'),
    'email_sender_name' => 'ShareLoop',

    // Pagination
    'pagination_limit' => 20,

    // Book conditions
    'book_conditions' => [
        'excellent' => __('Výborný'),
        'good' => __('Dobrý'),
        'fair' => __('Uspokojivý'),
        'poor' => __('Zlý'),
    ],

    // Sharing types
    'sharing_types' => [
        'borrow' => __('Požičiavanie'),
        'sell' => __('Predaj'),
        'both' => __('Oboje'),
    ],

    // Languages
    'languages' => [
        'sk' => 'Slovenčina',
        'cs' => 'Čeština',
        'en' => 'Angličtina',
        'de' => 'Nemčina',
        'fr' => 'Francúzština',
    ],
];

