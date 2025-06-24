<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Encryption\Encrypter;

class EncryptionService
{
    private $encrypter;

    public function __construct()
    {
        // Use a separate key for payment data encryption
        $key = config('app.payment_encryption_key', config('app.key'));

        // Jika key diawali 'base64:', decode dulu
        if (strpos($key, 'base64:') === 0) {
            $key = base64_decode(substr($key, 7));
        }

        $this->encrypter = new Encrypter($key, 'AES-256-CBC');
    }

    /**
     * Encrypt payment data
     */
    public function encryptPaymentData(array $data): string
    {
        return $this->encrypter->encrypt(json_encode($data));
    }

    /**
     * Decrypt payment data
     */
    public function decryptPaymentData(string $encryptedData): array
    {
        $decrypted = $this->encrypter->decrypt($encryptedData);
        return json_decode($decrypted, true);
    }

    /**
     * Encrypt credit card number
     */
    public function encryptCardNumber(string $cardNumber): string
    {
        return $this->encrypter->encrypt($cardNumber);
    }

    /**
     * Decrypt credit card number
     */
    public function decryptCardNumber(string $encryptedCardNumber): string
    {
        return $this->encrypter->decrypt($encryptedCardNumber);
    }

    /**
     * Mask credit card number for display
     */
    public function maskCardNumber(string $cardNumber): string
    {
        $length = strlen($cardNumber);
        if ($length < 4) {
            return $cardNumber;
        }

        $masked = str_repeat('*', $length - 4) . substr($cardNumber, -4);
        return $masked;
    }

    /**
     * Encrypt sensitive user data
     */
    public function encryptSensitiveData(array $data): array
    {
        $sensitiveFields = ['phone', 'address', 'id_number', 'card_number', 'cvv'];
        
        foreach ($sensitiveFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = $this->encrypter->encrypt($data[$field]);
            }
        }

        return $data;
    }

    /**
     * Decrypt sensitive user data
     */
    public function decryptSensitiveData(array $data): array
    {
        $sensitiveFields = ['phone', 'address', 'id_number', 'card_number', 'cvv'];
        
        foreach ($sensitiveFields as $field) {
            if (isset($data[$field])) {
                try {
                    $data[$field] = $this->encrypter->decrypt($data[$field]);
                } catch (\Exception $e) {
                    // If decryption fails, keep the encrypted value
                    continue;
                }
            }
        }

        return $data;
    }

    /**
     * Generate secure hash for payment verification
     */
    public function generatePaymentHash(array $paymentData): string
    {
        $data = json_encode($paymentData);
        return hash_hmac('sha256', $data, config('app.key'));
    }

    /**
     * Verify payment hash
     */
    public function verifyPaymentHash(array $paymentData, string $hash): bool
    {
        $expectedHash = $this->generatePaymentHash($paymentData);
        return hash_equals($expectedHash, $hash);
    }
} 