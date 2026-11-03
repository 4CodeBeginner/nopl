<?php

namespace Tests\Unit;

use App\Services\GeminiVisualSearch;
use App\Services\VisualSearchException;
use Illuminate\Http\Client\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GeminiVisualSearchTest extends TestCase
{
    public function test_it_sends_the_uploaded_image_to_gemini_and_returns_search_keywords(): void
    {
        config([
            'services.gemini.key' => 'test-key',
            'services.gemini.model' => 'gemini-3.5-flash-lite',
        ]);
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    ['content' => ['parts' => [['text' => 'Nissan Skyline GT-R Hot Wheels']]]],
                ],
            ]),
        ]);

        $keywords = app(GeminiVisualSearch::class)->describe(
            UploadedFile::fake()->image('diecast.png')
        );

        $this->assertSame('Nissan Skyline GT-R Hot Wheels', $keywords);
        Http::assertSent(fn (Request $request) =>
            $request->hasHeader('x-goog-api-key', 'test-key')
            && str_ends_with($request->url(), '/models/gemini-3.5-flash-lite:generateContent')
            && $request['contents'][0]['parts'][1]['inline_data']['mime_type'] === 'image/png'
            && $request['contents'][0]['parts'][1]['inline_data']['data'] !== ''
        );
    }

    public function test_it_reports_a_missing_api_key(): void
    {
        config(['services.gemini.key' => null]);

        $this->expectException(VisualSearchException::class);
        $this->expectExceptionMessage('Tambahkan GEMINI_API_KEY');

        app(GeminiVisualSearch::class)->describe(
            UploadedFile::fake()->image('diecast.png')
        );
    }

    public function test_it_reports_an_unavailable_gemini_model(): void
    {
        config([
            'services.gemini.key' => 'test-key',
            'services.gemini.model' => 'missing-model',
        ]);
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'error' => ['message' => 'Model not found'],
            ], 404),
        ]);

        $this->expectException(VisualSearchException::class);
        $this->expectExceptionMessage('Model Gemini tidak ditemukan');

        app(GeminiVisualSearch::class)->describe(
            UploadedFile::fake()->image('diecast.png')
        );
    }
}
