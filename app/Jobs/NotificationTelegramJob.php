<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class NotificationTelegramJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Update $update;
    private $correctMessage;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Update $update, $correctMessage)
    {
        $this->update = $update;
        $this->correctMessage = $correctMessage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Telegram::sendMessage([
            'chat_id' => $this->update->message->chat['id'],
            'text' => $this->correctMessage
        ]);
    }
}
