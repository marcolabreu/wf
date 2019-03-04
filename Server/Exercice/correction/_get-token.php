<?php
require dirname(__DIR__).'/vendor/autoload.php';
use Ramsey\Uuid\Uuid;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function generateToken(&$uuid, &$tag) : string {
    $cipher = "aes-256-gcm";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
    $uuid = Uuid::uuid1();

    return openssl_encrypt($uuid, $cipher, gethostname(), OPENSSL_ZERO_PADDING, $iv, $tag);
}

function tokenKeepAlive() {
    $current = new DateTime();
    $alive = [];
    foreach ($_SESSION['csrf_tokens'] as $uuid => $infos) {
        if ($infos['valid_period'] > $current) {
            $alive[$uuid] = $_SESSION['csrf_tokens'][$uuid];
        }
    }

    $_SESSION['csrf_tokens'] = $alive;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = generateToken($uuid, $tag);
    $tokenLimit = 120;

    if (!isset($_SESSION['csrf_tokens'])) {
        $_SESSION['csrf_tokens'] = [];
    } else if (count($_SESSION['csrf_tokens']) > $tokenLimit) {
        $_SESSION['csrf_tokens'] = array_slice($_SESSION['csrf_tokens'], count($_SESSION['csrf_tokens'])-$tokenLimit, $tokenLimit, true);
    }

    tokenKeepAlive();

    $_SESSION['csrf_tokens'][(string)$uuid] = [
        'uuid' => (string)$uuid,
        'tag' => $tag,
        'valid_period' => new DateTime('now +1hour')
    ];
}

session_write_close();

?>
