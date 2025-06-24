# Fitur Keamanan - Cafe Menu Ordering Application

## Overview
Aplikasi Cafe Menu Ordering telah dilengkapi dengan sistem keamanan yang komprehensif untuk melindungi data pengguna, transaksi, dan sistem secara keseluruhan.

## 1. Role-Based Access Control (RBAC)

### Struktur Permission
Sistem menggunakan permission granular untuk mengontrol akses:

#### Permission Categories:
- **Menu Management**: `menu.read`, `menu.create`, `menu.update`, `menu.delete`
- **Order Management**: `order.read`, `order.create`, `order.update`, `order.delete`, `order.process`
- **User Management**: `user.read`, `user.create`, `user.update`, `user.delete`
- **Payment Management**: `payment.read`, `payment.process`, `payment.refund`
- **Reporting**: `report.read`, `report.export`
- **System Management**: `system.settings`, `system.audit`

#### Role Permissions:
- **Admin**: Akses penuh ke semua fitur
- **Cashier**: Akses terbatas untuk pemrosesan pesanan dan pembayaran
- **Customer**: Akses terbatas untuk pemesanan dan pembayaran

### Usage:
```php
// Check permission in controller
if ($user->hasPermission('menu.create')) {
    // Allow menu creation
}

// Check specific action
if ($user->canCreate('order')) {
    // Allow order creation
}
```

## 2. Audit Logging

### Fitur Audit Log:
- **Comprehensive Logging**: Semua operasi sensitif dicatat
- **User Tracking**: Mencatat user yang melakukan aksi
- **IP Address & User Agent**: Mencatat informasi device
- **Before/After Values**: Mencatat perubahan data
- **Severity Levels**: info, warning, error, critical

### Logged Operations:
- User authentication (login/logout)
- CRUD operations pada menu, order, user
- Payment processing
- Security events
- System configuration changes

### Usage:
```php
// Log user action
$auditService->log('user.login', [
    'description' => 'User logged in successfully',
    'severity' => 'info'
]);

// Log model changes
$auditService->logModelChange('update', $menu, $oldValues, $newValues);
```

## 3. Data Encryption

### Payment Data Encryption:
- **Credit Card Numbers**: Dienkripsi menggunakan AES-256-CBC
- **Sensitive User Data**: Phone, address, ID numbers
- **Secure Key Management**: Separate encryption key untuk payment data

### Features:
- Automatic encryption/decryption
- Card number masking untuk display
- Hash verification untuk payment integrity

### Usage:
```php
// Encrypt payment data
$encryptedData = $encryptionService->encryptPaymentData($paymentData);

// Decrypt payment data
$paymentData = $encryptionService->decryptPaymentData($encryptedData);

// Mask card number
$maskedCard = $encryptionService->maskCardNumber($cardNumber);
```

## 4. Session Management & Timeout

### Session Features:
- **Multiple Session Support**: User dapat login dari beberapa device
- **Session Tracking**: Monitor active sessions
- **Automatic Timeout**: Session expired berdasarkan konfigurasi
- **Session Termination**: Admin dapat terminate session
- **Device Information**: Browser, platform, device type

### Configuration:
```php
// config/security.php
'session' => [
    'lifetime' => 120, // minutes
    'max_sessions' => 5,
    'timeout_warning' => 10, // minutes before timeout
],
```

### Usage:
```php
// Create new session
$sessionService->createSession($sessionId);

// Update activity
$sessionService->updateActivity($sessionId);

// Terminate session
$sessionService->terminateSession($sessionId, 'manual');
```

## 5. Security Headers

### Implemented Headers:
- **X-Frame-Options**: Prevent clickjacking
- **X-Content-Type-Options**: Prevent MIME type sniffing
- **X-XSS-Protection**: Enable XSS protection
- **Content-Security-Policy**: Control resource loading
- **Strict-Transport-Security**: Force HTTPS
- **Referrer-Policy**: Control referrer information

### Configuration:
```php
// config/security.php
'headers' => [
    'x_frame_options' => 'SAMEORIGIN',
    'x_content_type_options' => 'nosniff',
    'x_xss_protection' => '1; mode=block',
    // ... more headers
],
```

## 6. User Security Features

### Account Security:
- **Login Attempt Limiting**: Lock account setelah 5 failed attempts
- **Account Lockout**: Temporary lockout (30 minutes)
- **Password Policy**: Minimum requirements dan expiration
- **Two-Factor Authentication**: Optional 2FA support
- **Force Password Change**: Admin dapat force password change

### Security Fields:
```php
// User model fields
'last_login_at' => 'datetime',
'last_login_ip' => 'string',
'login_attempts' => 'integer',
'locked_until' => 'datetime',
'two_factor_enabled' => 'boolean',
'password_changed_at' => 'datetime',
'force_password_change' => 'boolean',
```

## 7. Middleware Security

### Implemented Middleware:
- **AuditLogMiddleware**: Automatic audit logging
- **PermissionMiddleware**: Permission-based access control
- **SecurityHeadersMiddleware**: Security headers injection
- **RoleMiddleware**: Role-based access control

### Usage:
```php
// Route protection
Route::middleware(['auth', 'permission:menu.create'])->group(function () {
    // Routes requiring menu.create permission
});

// Audit logging
Route::middleware(['audit.log:menu.create,warning'])->group(function () {
    // Routes with audit logging
});
```

## 8. Security Maintenance

### Automated Tasks:
- **Session Cleanup**: Remove expired sessions
- **Audit Log Cleanup**: Remove old audit logs
- **Security Statistics**: Monitor security metrics

### Commands:
```bash
# Clean expired sessions
php artisan security:maintenance --clean-sessions

# Clean old audit logs
php artisan security:maintenance --clean-audit-logs

# Run all maintenance tasks
php artisan security:maintenance --all
```

## 9. Admin Security Dashboard

### Features:
- **Security Statistics**: Overview of security metrics
- **Recent Security Events**: Monitor recent activities
- **Active Sessions**: View and manage user sessions
- **Audit Logs**: Browse and search audit logs
- **User Management**: Lock/unlock users, force password changes

### Access:
- Available at `/admin/security`
- Requires admin role
- Full audit logging of admin actions

## 10. Configuration

### Environment Variables:
```env
# Session Configuration
SESSION_LIFETIME=120
MAX_SESSIONS_PER_USER=5
SESSION_TIMEOUT_WARNING=10

# Password Policy
PASSWORD_MIN_LENGTH=8
PASSWORD_REQUIRE_UPPERCASE=true
PASSWORD_REQUIRE_LOWERCASE=true
PASSWORD_REQUIRE_NUMBERS=true
PASSWORD_REQUIRE_SYMBOLS=true
PASSWORD_EXPIRE_DAYS=90

# Login Security
LOGIN_MAX_ATTEMPTS=5
LOGIN_LOCKOUT_DURATION=30

# Audit Logging
AUDIT_LOGGING_ENABLED=true
AUDIT_LOG_RETENTION_DAYS=90

# Payment Security
PAYMENT_ENCRYPTION_ENABLED=true
PAYMENT_ENCRYPTION_KEY=your-secret-key
```

## 11. Best Practices

### Development:
1. **Always check permissions** sebelum melakukan operasi sensitif
2. **Log all security events** untuk audit trail
3. **Encrypt sensitive data** terutama payment information
4. **Validate user input** untuk mencegah injection attacks
5. **Use HTTPS** untuk semua komunikasi

### Deployment:
1. **Change default passwords** dan encryption keys
2. **Configure proper session settings** sesuai kebutuhan
3. **Set up monitoring** untuk security events
4. **Regular security updates** dan maintenance
5. **Backup security logs** secara berkala

### Monitoring:
1. **Monitor failed login attempts**
2. **Track suspicious activities**
3. **Review audit logs** secara berkala
4. **Monitor session activities**
5. **Check for unauthorized access attempts**

## 12. Troubleshooting

### Common Issues:
1. **Permission Denied**: Check user role dan permissions
2. **Session Timeout**: Verify session configuration
3. **Encryption Errors**: Check encryption key configuration
4. **Audit Log Issues**: Verify database permissions

### Debug Commands:
```bash
# Check security configuration
php artisan config:show security

# View security statistics
php artisan security:maintenance

# Test permissions
php artisan tinker
>>> $user = App\Models\User::find(1);
>>> $user->hasPermission('menu.create');
```

## Support

Untuk pertanyaan atau masalah terkait keamanan, silakan hubungi tim development atau buat issue di repository project. 