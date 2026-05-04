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

        return Http::withOptions([
            'verify' => false,
        ])->post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ]);
    }

    public function sendNewGame(Game $game)
    {
        $text = "🎮 Нова гра!\n\n"
            . "📌 Назва гри: {$game->name}\n"
            . "📌 Опис: \n{$game->description}\n"
            . "📌 Рейтинг: {$game->rating}⭐\n"
            . "📌 Підтримка платформ: {$game->platforms}\n"
            . "📌 Категорія: {$game->category->title}\n"
            . "📌 Розробник: {$game->creator->first_name} {$game->creator->last_name}\n"
            . "📌 Компанія: {$game->company->name}\n";

        return $this->sendMessage($text);
    }
}
