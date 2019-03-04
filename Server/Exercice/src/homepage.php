<?php include('header.html'); ?>
<?php require('pdo.php'); ?>

<body>
<h1>TagBeSill</h1>

<?php
$articles = $pdo->query('SELECT * FROM article');
while ($row = $articles->fetch()) {
    ?>

    <article>
        <h2><?php echo $row['title'] ?></h2>
        <div class="flex">
            <p><?php echo $row['description'] ?></p>
            <img src="<?php echo $row['img'] ?>">
        </div>
    </article>


<?php } ?>


</body>
</html>