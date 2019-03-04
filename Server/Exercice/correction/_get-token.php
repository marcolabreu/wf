<?php
require dirname(__DIR__) . '/vendor/autoload.php';
use Ramsey\Uuid\Uuid;

function generateToken() : string {
    $cipher = "aes-256-gcm";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
    $requestId = Uuid::uuid1();

    return openssl_encrypt($requestId, $cipher, gethostname(), OPENSSL_ZERO_PADDING, $iv, $tag);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $token = generateToken();
}
?>