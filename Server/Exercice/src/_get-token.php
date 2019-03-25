<?php
require dirname(__DIR__).'/vendor/autoload.php';
use Ramsey\Uuid\Uuid;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function generateToken(&$uuid, &$tag, &$iv) : string {
    $cipher = "aes-256-gcm";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
    $uuid = Uuid::uuid1();

    return openssl_encrypt($uuid, $cipher, gethostname(), OPENSSL_ZERO_PADDING, $iv, $tag);
}

function validateToken($token) {
    if (!isset($_SESSION['csrf_tokens'][$token])) {
        return false;
    }
    $store = $_SESSION['csrf_tokens'][$token];

    $cipher = "aes-256-gcm";
    $uuid = openssl_decrypt($token, $cipher, gethostname(), OPENSSL_ZERO_PADDING, $store['iv'], $store['tag']);

    return $uuid == $store['uuid'];
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

$token = generateToken($uuid, $tag, $iv);
$tokenLimit = 120;

if (!isset($_SESSION['csrf_tokens'])) {
    $_SESSION['csrf_tokens'] = [];
} else if (count($_SESSION['csrf_tokens']) > $tokenLimit) {
    $_SESSION['csrf_tokens'] = array_slice($_SESSION['csrf_tokens'], count($_SESSION['csrf_tokens'])-$tokenLimit, $tokenLimit, true);
}

tokenKeepAlive();

$_SESSION['csrf_tokens'][$token] = [
    'uuid' => (string)$uuid,
    'tag' => $tag,
    'iv' => $iv,
    'valid_period' => new DateTime('now +1hour')
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $error = false;
    $messages = [];

    if (empty($_POST['addProject_title'])) {
        $error = true;
        $messages['addProject_title'] = '<p>This value should not be blank</p>';
    }
    if (empty($_POST['addProject_description'])) {
        $error = true;
        $messages['addProject_description'] = '<p>This value should not be blank</p>';
    }
    if (empty($_POST['addProject_csrf_token'])) {
        $error = true;
        $messages['addProject_csrf_token'] = '<p>An error occurred 1</p>';
    } else if (!validateToken($_POST['addProject_csrf_token'])) {
        $error = true;
        $messages['addProject_csrf_token'] = '<p>An error occurred 2</p>';
    }

    if (!empty($_FILES['addProject_image']['name'])) {
        $file = $_FILES['addProject_image'];

        if (!in_array(mime_content_type($file['tmp_name']), ['image/png','image/jpeg', 'image/gif'])) {
            $error = true;
            $messages['addProject_image'] = '<p>Only png, jpeg or gif are allowed</p>';
        }
    }

    if (!$error) {
        $fileName = null;
        if (!empty($_FILES['addProject_image']['name'])) {
            $fileName = '../storage/'.(new DateTime())->format('YmdHis').uniqid().'.'.pathinfo($file['name'], PATHINFO_EXTENSION);
            move_uploaded_file($file['tmp_name'], $fileName);
        }


        $stderr = fopen('php://stderr', 'w');
        $db = 'test';
        $host = '172.19.0.2';
        $username = 'root';
        try{
            $connection = new PDO("mysql:dbname=$db;host=$host", $username);
        } catch (\PDOException $exception) {
            $log = sprintf(
                '[ERROR] %s Impossible connection to the DB %s',
                (new DateTime())->format('Y-m-d H:i:s'),
                (string)$exception
            );
            fwrite($stderr, $log);
            var_dump($log);
            exit(0x000B1);
        }

        $stmt = $connection->prepare('INSERT INTO article(img, title, description) VALUES (:img, :title, :desc)');

        $stmt->bindValue('title', htmlspecialchars($_POST['addProject_title']));
        $stmt->bindValue('desc', htmlspecialchars($_POST['addProject_description']));

        if ($fileName === null) {
            $stmt->bindValue('img', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue('img', $fileName);
        }

        if($stmt->execute()) {
            // working
        } else {
            var_dump($stmt->errorInfo());
        }
    }
}

session_write_close();

?>