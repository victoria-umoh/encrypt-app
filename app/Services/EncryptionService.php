<?php

namespace App\Services;

class EncryptionService
{
    protected $cipher = 'AES-256-CBC';
    protected $key;
    protected $iv;

    public function __construct()
    {
        $this->key = config('app.encryption_key');
        $this->iv = config('app.encryption_iv');

        if (empty($this->key)) {
            $this->key = openssl_random_pseudo_bytes(32);
        }

        if (empty($this->iv)) {
            $this->iv = openssl_random_pseudo_bytes(16);
        }
    }

    public function encrypt($plaintext)
    {
        $ciphertext = openssl_encrypt($plaintext, $this->cipher, $this->key, OPENSSL_RAW_DATA, $this->iv);
        return bin2hex($ciphertext);
    }

    public function decrypt($hexCiphertext)
    {
        $ciphertext = hex2bin($hexCiphertext);
        return openssl_decrypt($ciphertext, $this->cipher, $this->key, OPENSSL_RAW_DATA, $this->iv);
    }
}
