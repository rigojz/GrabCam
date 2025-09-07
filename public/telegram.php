<?php
require_once __DIR__ . '/config.php';

function send_to_telegram($message){
    $token = TELEGRAM_BOT_TOKEN;
    $chat_id = TELEGRAM_CHAT_ID;
    $url = "https://api.telegram.org/bot$token/sendMessage";

    $data = [
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    return file_get_contents($url,false,stream_context_create($options));
}
