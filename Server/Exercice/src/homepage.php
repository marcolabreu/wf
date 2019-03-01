<?php include('header.html'); ?>

<body>
<h1>TagBeSill</h1>


<?php $host = '127.0.0.1';
$db = 'TagBeSill';
$user = 'debian-sys-maint';
$pass = 'kTAfY4463eRP9Q4Z';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$stmt = $pdo->query('SELECT * FROM article');
while ($row = $stmt->fetch()) {
    ?>

    <article>
        <h2><?php echo $row['title'] ?></h2>
        <img src="<?php echo $row['img'] ?>">
        <p><?php echo $row['description'] ?></p>
    </article>


<?php } ?>


</body>
</html>