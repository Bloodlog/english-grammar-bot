<?php

namespace App\Console\Commands;

use App\Jobs\CorrectGrammarJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramGetUpdatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:getupdates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get messages from telegram';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $updateId = Storage::disk('local')->get('update_id.db');
        $params = [];

        if (!is_null($updateId)) {
            $params = ['offset' => (int)$updateId + 1];
        }
        $updates = Telegram::getUpdates($params);
        foreach ($updates as $update) {
            CorrectGrammarJob::dispatch($update)->onQueue('requests_queue');
            Storage::disk('local')->put('update_id.db', $update->updateId);
        }

        return Command::SUCCESS;
    }
}
