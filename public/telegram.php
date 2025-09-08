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

function send_photo_to_telegram($photoPath, $caption = "📷 Foto recibida"){
    $token = TELEGRAM_BOT_TOKEN;
    $chat_id = TELEGRAM_CHAT_ID;
    $url = "https://api.telegram.org/bot$token/sendPhoto";

    $post_fields = [
        'chat_id' => $chat_id,
        'photo'   => new CURLFile($photoPath),
        'caption' => $caption
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
}
