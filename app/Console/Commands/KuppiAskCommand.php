<?php

namespace App\Console\Commands;

use App\Services\GeminiService;
use Illuminate\Console\Command;

class KuppiAskCommand extends Command
{
    protected $signature = 'kuppi:ask {question : Your study or coding question}';
    protected $description = 'Ask the Gemini AI Kuppi Tutor directly from the CLI';

    public function handle()
    {
        $question = $this->argument('question');
        $this->info("Asking Merlin AI Kuppi Tutor...");
        
        $answer = GeminiService::generateKuppiHelp('CLI Kuppi Query', $question, $question);
        
        $this->newLine();
        $this->line($answer);
        $this->newLine();
    }
}