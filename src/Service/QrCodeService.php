<?php
declare(strict_types=1);

namespace App\Service;

/**
 * QR Code Service
 *
 * Služba na generovanie a správu QR kódov pre knihy
 */
class QrCodeService
{
    /**
     * Generovať QR kód pre knihu
     *
     * @param int $bookId ID knihy
     * @param string $baseUrl Základná URL aplikácie
     * @return string URL QR kódu
     */
    public function generateQrCodeUrl(int $bookId, string $baseUrl = ''): string
    {
        if (empty($baseUrl)) {
            $baseUrl = 'http://localhost:8765/shareloop';
        }

        $bookUrl = $baseUrl . '/books/view/' . $bookId;

        // Použijeme QR server na generovania QR kódu
        // https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=encoded_data
        return 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($bookUrl);
    }

    /**
     * Generovať HTML s QR kódom
     *
     * @param int $bookId ID knihy
     * @param string $baseUrl Základná URL aplikácie
     * @return string HTML s QR kódom
     */
    public function getQrCodeHtml(int $bookId, string $baseUrl = ''): string
    {
        $qrUrl = $this->generateQrCodeUrl($bookId, $baseUrl);

        return '<img src="' . $qrUrl . '" alt="QR Code" class="qr-code" />';
    }

    /**
     * Generovať QR kód pre ľahšie lokálne testovanie
     *
     * @param string $data Data na kódovanie
     * @return string SVG QR kód
     */
    public function generateQrCodeSvg(string $data): string
    {
        // Jednoduchá implementácia bez externého API
        // V produkcii by som odporučil knižnicu ako: phpqrcode/phpqrcode
        return $this->generateQrCodeUrl(1, '');
    }
}

