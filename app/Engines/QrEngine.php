<?php

namespace App\Engines;

use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * Part-9.3 Reusable Engine: one QR generator/verifier used by Student Identity,
 * Teacher Identity, and every Document Engine output (Part-6/7 QR Verification).
 */
class QrEngine
{
    public function generateToken(): string
    {
        return (string) Str::uuid();
    }

    public function verificationUrl(string $token): string
    {
        return route('public.verify', ['token' => $token]);
    }

    /**
     * Returns raw SVG markup for the QR code pointing at the public verification URL.
     * Requires: composer require simplesoftwareio/simple-qrcode
     */
    public function svg(string $token): string
    {
        return QrCode::size(160)->generate($this->verificationUrl($token));
    }
}
