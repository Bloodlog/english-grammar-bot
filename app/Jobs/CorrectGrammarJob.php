<?php

namespace App\Jobs;

use App\Services\GrammarCorrectionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Telegram\Bot\Objects\Update;

class CorrectGrammarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Update $update;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Update $update)
    {
        $this->update = $update;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(GrammarCorrectionService $service)
    {
        $response = $service->send($this->update->message->text);
        if (!array_key_exists('choices', $response)) {
            // TODO error
            return;
        }
        NotificationTelegramJob::dispatch($this->update, $response['choices'][0]['text'])->onQueue('telegram_notifications_queue');
    }
}
