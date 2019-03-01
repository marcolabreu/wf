<?php include('header.html'); ?>
<?php include('pdo.php'); ?>

<body>
<h1>TagBeSill</h1>

<?php
$articles = $pdo->query('SELECT * FROM article');
while ($row = $articles->fetch()) {
    ?>

    <article>
        <h2><?php echo $row['title'] ?></h2>
        <img src="<?php echo $row['img'] ?>">
        <p><?php echo $row['description'] ?></p>
    </article>


<?php } ?>


</body>
</html>