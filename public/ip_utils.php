<?php
function get_client_ip(): string {
    $keys = ['HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','REMOTE_ADDR'];
    foreach ($keys as $k) {
        if (!empty($_SERVER[$k])) {
            $ips = explode(',', $_SERVER[$k]);
            foreach ($ips as $ip) {
                $ip = trim($ip);
                if (filter_var($ip,FILTER_VALIDATE_IP)) return $ip;
            }
        }
    }
    return 'Unknown';
}
