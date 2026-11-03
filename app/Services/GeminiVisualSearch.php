<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class GeminiVisualSearch
{
    public function describe(UploadedFile $image): string
    {
        $apiKey = config('services.gemini.key');

        if (!is_string($apiKey) || $apiKey === '') {
            throw new VisualSearchException('Pencarian gambar belum dikonfigurasi. Tambahkan GEMINI_API_KEY di file .env.');
        }

        $mimeType = $image->getMimeType();
        if (!is_string($mimeType) || !str_starts_with($mimeType, 'image/')) {
            throw new VisualSearchException('Format gambar tidak dapat dibaca.');
        }

        $model = config('services.gemini.model');

        if (!is_string($model) || $model === '') {
            throw new VisualSearchException('Model Gemini belum dikonfigurasi. Periksa GEMINI_MODEL di file .env.');
        }

        $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/' . rawurlencode($model) . ':generateContent';

        try {
            $response = Http::withHeaders(['x-goog-api-key' => $apiKey])
                ->acceptJson()
                ->timeout(45)
                ->post($endpoint, [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => 'Identifikasi mobil mainan/diecast pada gambar. Keluarkan hanya 3-6 kata kunci pencarian singkat, utamakan merek, model mobil, dan brand diecast jika terlihat. Jangan menebak detail yang tidak terlihat.',
                                ],
                                [
                                    'inline_data' => [
                                        'mime_type' => $mimeType,
                                        'data' => base64_encode($image->get()),
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'maxOutputTokens' => 80,
                        'temperature' => 0.1,
                    ],
                ]);
        } catch (ConnectionException $exception) {
            throw new VisualSearchException('Tidak dapat terhubung ke layanan pencarian gambar Gemini. Silakan coba lagi.', previous: $exception);
        }

        if (!$response->successful()) {
            $detail = $response->json('error.message');
            $detail = is_string($detail) ? trim($detail) : '';

            if (in_array($response->status(), [401, 403], true)) {
                throw new VisualSearchException('GEMINI_API_KEY tidak valid atau tidak memiliki akses. Periksa key di file .env.');
            }

            if ($response->status() === 404) {
                throw new VisualSearchException('Model Gemini tidak ditemukan. Periksa nilai GEMINI_MODEL di file .env.');
            }

            throw new VisualSearchException('Layanan pencarian gambar Gemini bermasalah.' . ($detail !== '' ? ' Detail: ' . $detail : ' Silakan coba lagi.'));
        }

        $parts = $response->json('candidates.0.content.parts', []);
        $description = collect(is_array($parts) ? $parts : [])
            ->pluck('text')
            ->filter(fn ($text) => is_string($text))
            ->implode(' ');

        if (trim($description) === '') {
            throw new VisualSearchException('AI tidak dapat mengenali gambar tersebut. Coba gunakan gambar yang lebih jelas.');
        }

        return trim($description);
    }
}
