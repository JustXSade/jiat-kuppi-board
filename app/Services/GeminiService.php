<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    public static function generateKuppiHelp(string $category, string $title, string $content): string
    {
        $apiKey = trim((string) env('GEMINI_API_KEY'));

        if (empty($apiKey)) {
            return 'Error: GEMINI_API_KEY is missing in .env file.';
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-3.5-flash-lite:generateContent?key={$apiKey}";

        $systemInstruction = "You are a friendly senior university student (Kuppi Tutor) at Java Institute Sri Lanka. "
            . "LANGUAGE RULE (CRITICAL): You MUST write your response in natural, casual Sinhala script (Sinhala Unicode alphabet) mixed with English IT/technical terms (e.g., Database, Migration, Class, Object, API, Laravel, SQLite, Command, Error). "
            . "STRICTLY FORBIDDEN: NEVER use Singlish (romanized Sinhala written in English letters like 'machan', 'eka', 'karanna', 'thiyenawa', 'balanna', 'puluwan'). "
            . "Even if the student writes their question in Singlish, you MUST reply using actual Sinhala Unicode script + English technical terms. "
            . "Keep the response under 130 words using clear bullet points.";

        $userPrompt = "Category: {$category}\nTitle: {$title}\nQuestion:\n{$content}";

        try {
            $response = Http::withoutVerifying()
                ->timeout(20)
                ->withOptions([
                    'version' => 1.1,
                ])
                ->post($url, [
                    'system_instruction' => [
                        'parts' => [
                            ['text' => $systemInstruction]
                        ]
                    ],
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $userPrompt]
                            ]
                        ]
                    ]
                ]);

            if ($response->successful()) {
                return $response->json('candidates.0.content.parts.0.text')
                    ?? 'Kuppi guide generated, but response was empty.';
            }

            Log::error('Gemini API Error: ' . $response->body());
            return 'AI Error (' . $response->status() . '): ' . ($response->json('error.message') ?? 'Unknown error');
        } catch (\Throwable $e) {
            Log::error('Gemini Exception: ' . $e->getMessage());
            return 'AI Tutor Exception: ' . $e->getMessage();
        }
    }
}