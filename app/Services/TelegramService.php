<?php

namespace App\Services;

use App\Models\Game;
use Illuminate\Support\Facades\Http;

class TelegramService
{
   
    public $token;
    public $chat_id;
    public function sendMessage($text)
    {
        $token = config('services.telegram.token');
        $chatId = config('services.telegram.chat_id');

        return Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ]);
    }

    public function sendNewGame(Game $game)
    {
        $creator = $game->user->name ?? 'Невідомо';

        $text = "🎮 *Нова гра додана!*\n\n"
              . "📌 Назва: *{$game->name}*\n"
              . "📌 Опис: *{$game->description}*\n"
              . "📌 Дата: *{$game->release_date}*\n"
              . "📌 Платформи: *{$game->platforms}*\n"
              . "👤 Автор: {$creator}";

        return $this->sendMessage($text);
    }
}
