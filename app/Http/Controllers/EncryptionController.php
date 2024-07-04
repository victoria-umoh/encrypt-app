<?php

namespace App\Http\Controllers;

use App\Services\EncryptionService;
use Illuminate\Http\Request;

class EncryptionController extends Controller
{
    protected $encryptionService;

    public function __construct(EncryptionService $encryptionService)
    {
        $this->encryptionService = $encryptionService;
    }

    public function encrypt()
    {
        $plaintext = 'Welcome to Lagos';
        $encrypted = $this->encryptionService->encrypt($plaintext);

        return response()->json([
            'plaintext' => $plaintext,
            'encrypted' => $encrypted
        ]);
    }

    public function decrypt(Request $request)
    {
        $hexCiphertext = $request->input('ciphertext');
        $decrypted = $this->encryptionService->decrypt($hexCiphertext);

        return response()->json([
            'ciphertext' => $hexCiphertext,
            'decrypted' => $decrypted
        ]);
    }
}
