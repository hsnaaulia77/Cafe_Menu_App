<?php

namespace App\Models;

use App\Services\EncryptionService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'total_amount',
        'status',
        'notes',
        'processed_at',
        'completed_at',
        'payment_method',
        'paid_amount',
        'admin_notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Hidden attributes for security
    protected $hidden = [
        'customer_phone', // Will be encrypted
        'customer_address', // Will be encrypted
    ];

    // Append encrypted attributes
    protected $appends = [
        'customer_phone_decrypted',
        'customer_address_decrypted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'ready' => 'Siap',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => 'Tidak Diketahui'
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'badge-warning',
            'confirmed' => 'badge-info',
            'processing' => 'badge-primary',
            'ready' => 'badge-success',
            'completed' => 'badge-success',
            'cancelled' => 'badge-danger',
            default => 'badge-secondary'
        };
    }

    public function getPaymentMethodLabelAttribute()
    {
        return match($this->payment_method) {
            'cash' => 'Tunai',
            'transfer' => 'Transfer',
            'qris' => 'QRIS',
            'card' => 'Kartu',
            default => 'Tidak Diketahui'
        };
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function canBeProcessed()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function canBeCompleted()
    {
        return in_array($this->status, ['processing', 'ready']);
    }

    // Encryption methods for sensitive data
    public function getCustomerPhoneDecryptedAttribute()
    {
        if (!$this->customer_phone) {
            return null;
        }

        try {
            $encryptionService = app(EncryptionService::class);
            return $encryptionService->decryptCardNumber($this->customer_phone);
        } catch (\Exception $e) {
            return '***-***-****'; // Masked fallback
        }
    }

    public function getCustomerAddressDecryptedAttribute()
    {
        if (!$this->customer_address) {
            return null;
        }

        try {
            $encryptionService = app(EncryptionService::class);
            return $encryptionService->decryptCardNumber($this->customer_address);
        } catch (\Exception $e) {
            return 'Address not available'; // Fallback
        }
    }

    public function setCustomerPhoneAttribute($value)
    {
        if ($value) {
            $encryptionService = app(EncryptionService::class);
            $this->attributes['customer_phone'] = $encryptionService->encryptCardNumber($value);
        } else {
            $this->attributes['customer_phone'] = null;
        }
    }

    public function setCustomerAddressAttribute($value)
    {
        if ($value) {
            $encryptionService = app(EncryptionService::class);
            $this->attributes['customer_address'] = $encryptionService->encryptCardNumber($value);
        } else {
            $this->attributes['customer_address'] = null;
        }
    }

    // Security methods
    public function canUserAccess($user)
    {
        // Admin can access all orders
        if ($user->isAdmin()) {
            return true;
        }

        // Cashier can access all orders
        if ($user->isCashier()) {
            return true;
        }

        // Customer can only access their own orders
        if ($user->isCustomer()) {
            return $this->user_id === $user->id;
        }

        return false;
    }

    public function canUserUpdate($user)
    {
        // Admin can update all orders
        if ($user->isAdmin()) {
            return true;
        }

        // Cashier can update order status and payment
        if ($user->isCashier()) {
            return in_array($this->status, ['pending', 'confirmed', 'processing', 'ready']);
        }

        // Customer can only update their own pending orders
        if ($user->isCustomer()) {
            return $this->user_id === $user->id && $this->status === 'pending';
        }

        return false;
    }

    public function canUserDelete($user)
    {
        // Only admin can delete orders
        return $user->isAdmin();
    }

    // Payment security methods
    public function processPayment($amount, $method, $user)
    {
        // Validate payment amount
        if ($amount < 0 || $amount > $this->total_amount) {
            throw new \Exception('Invalid payment amount');
        }

        // Update payment information
        $this->update([
            'paid_amount' => $amount,
            'payment_method' => $method,
            'status' => $amount >= $this->total_amount ? 'completed' : 'processing',
            'completed_at' => $amount >= $this->total_amount ? now() : null,
        ]);

        // Log payment processing
        $auditService = app(\App\Services\AuditService::class);
        $auditService->log('payment.processed', [
            'description' => "Payment processed for order #{$this->id} by {$user->name}",
            'model_type' => 'App\Models\Order',
            'model_id' => $this->id,
            'new_values' => [
                'paid_amount' => $amount,
                'payment_method' => $method,
                'status' => $this->status,
            ],
            'severity' => 'info'
        ]);

        return $this;
    }

    public function refundPayment($amount, $reason, $user)
    {
        // Validate refund amount
        if ($amount <= 0 || $amount > $this->paid_amount) {
            throw new \Exception('Invalid refund amount');
        }

        // Update refund information
        $this->update([
            'paid_amount' => $this->paid_amount - $amount,
            'status' => 'cancelled',
            'admin_notes' => $this->admin_notes . "\nRefund: {$amount} - {$reason}",
        ]);

        // Log refund
        $auditService = app(\App\Services\AuditService::class);
        $auditService->log('payment.refunded', [
            'description' => "Payment refunded for order #{$this->id} by {$user->name}",
            'model_type' => 'App\Models\Order',
            'model_id' => $this->id,
            'new_values' => [
                'refund_amount' => $amount,
                'refund_reason' => $reason,
                'paid_amount' => $this->paid_amount,
                'status' => $this->status,
            ],
            'severity' => 'warning'
        ]);

        return $this;
    }

    // Audit methods
    public function logStatusChange($oldStatus, $newStatus, $user)
    {
        $auditService = app(\App\Services\AuditService::class);
        $auditService->log('order.status_changed', [
            'description' => "Order #{$this->id} status changed from {$oldStatus} to {$newStatus} by {$user->name}",
            'model_type' => 'App\Models\Order',
            'model_id' => $this->id,
            'old_values' => ['status' => $oldStatus],
            'new_values' => ['status' => $newStatus],
            'severity' => 'info'
        ]);
    }
}
