<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains security-related configuration options for the
    | cafe menu ordering application.
    |
    */

    // Session Configuration
    'session' => [
        'lifetime' => env('SESSION_LIFETIME', 120), // minutes
        'max_sessions' => env('MAX_SESSIONS_PER_USER', 5),
        'timeout_warning' => env('SESSION_TIMEOUT_WARNING', 10), // minutes before timeout
    ],

    // Password Policy
    'password' => [
        'min_length' => env('PASSWORD_MIN_LENGTH', 8),
        'require_uppercase' => env('PASSWORD_REQUIRE_UPPERCASE', true),
        'require_lowercase' => env('PASSWORD_REQUIRE_LOWERCASE', true),
        'require_numbers' => env('PASSWORD_REQUIRE_NUMBERS', true),
        'require_symbols' => env('PASSWORD_REQUIRE_SYMBOLS', true),
        'expire_days' => env('PASSWORD_EXPIRE_DAYS', 90),
    ],

    // Login Security
    'login' => [
        'max_attempts' => env('LOGIN_MAX_ATTEMPTS', 5),
        'lockout_duration' => env('LOGIN_LOCKOUT_DURATION', 30), // minutes
        'remember_me_days' => env('LOGIN_REMEMBER_ME_DAYS', 30),
    ],

    // Two-Factor Authentication
    'two_factor' => [
        'enabled' => env('TWO_FACTOR_ENABLED', false),
        'issuer' => env('TWO_FACTOR_ISSUER', 'Cafe Menu App'),
        'algorithm' => env('TWO_FACTOR_ALGORITHM', 'sha1'),
        'digits' => env('TWO_FACTOR_DIGITS', 6),
        'period' => env('TWO_FACTOR_PERIOD', 30), // seconds
    ],

    // Audit Logging
    'audit' => [
        'enabled' => env('AUDIT_LOGGING_ENABLED', true),
        'retention_days' => env('AUDIT_LOG_RETENTION_DAYS', 90),
        'log_sensitive_operations' => env('AUDIT_LOG_SENSITIVE_OPERATIONS', true),
        'log_user_actions' => env('AUDIT_LOG_USER_ACTIONS', true),
        'log_payment_operations' => env('AUDIT_LOG_PAYMENT_OPERATIONS', true),
    ],

    // Payment Security
    'payment' => [
        'encryption_enabled' => env('PAYMENT_ENCRYPTION_ENABLED', true),
        'encryption_key' => env('PAYMENT_ENCRYPTION_KEY'),
        'mask_card_numbers' => env('PAYMENT_MASK_CARD_NUMBERS', true),
        'log_payment_attempts' => env('PAYMENT_LOG_ATTEMPTS', true),
    ],

    // Rate Limiting
    'rate_limiting' => [
        'enabled' => env('RATE_LIMITING_ENABLED', true),
        'login_attempts' => env('RATE_LIMIT_LOGIN_ATTEMPTS', 5),
        'api_requests' => env('RATE_LIMIT_API_REQUESTS', 60),
        'order_creation' => env('RATE_LIMIT_ORDER_CREATION', 10),
    ],

    // Security Headers
    'headers' => [
        'x_frame_options' => env('SECURITY_X_FRAME_OPTIONS', 'SAMEORIGIN'),
        'x_content_type_options' => env('SECURITY_X_CONTENT_TYPE_OPTIONS', 'nosniff'),
        'x_xss_protection' => env('SECURITY_X_XSS_PROTECTION', '1; mode=block'),
        'referrer_policy' => env('SECURITY_REFERRER_POLICY', 'strict-origin-when-cross-origin'),
        'permissions_policy' => env('SECURITY_PERMISSIONS_POLICY', 'geolocation=(), microphone=(), camera=()'),
    ],

    // IP Whitelist/Blacklist
    'ip_restrictions' => [
        'enabled' => env('IP_RESTRICTIONS_ENABLED', false),
        'whitelist' => explode(',', env('IP_WHITELIST', '')),
        'blacklist' => explode(',', env('IP_BLACKLIST', '')),
        'admin_only_ips' => explode(',', env('ADMIN_ONLY_IPS', '')),
    ],

    // File Upload Security
    'file_upload' => [
        'max_size' => env('FILE_UPLOAD_MAX_SIZE', 2048), // KB
        'allowed_types' => explode(',', env('FILE_UPLOAD_ALLOWED_TYPES', 'jpg,jpeg,png,gif')),
        'scan_virus' => env('FILE_UPLOAD_SCAN_VIRUS', false),
        'store_encrypted' => env('FILE_UPLOAD_STORE_ENCRYPTED', false),
    ],

    // API Security
    'api' => [
        'require_authentication' => env('API_REQUIRE_AUTH', true),
        'rate_limit' => env('API_RATE_LIMIT', 60),
        'token_expiry' => env('API_TOKEN_EXPIRY', 60), // minutes
        'log_requests' => env('API_LOG_REQUESTS', true),
    ],

    // Backup Security
    'backup' => [
        'encrypt_backups' => env('BACKUP_ENCRYPT', true),
        'backup_retention_days' => env('BACKUP_RETENTION_DAYS', 30),
        'backup_notification' => env('BACKUP_NOTIFICATION', true),
    ],
]; 