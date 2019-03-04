<?php require "_get-token.php"; ?>


<!doctype html>
<html lang="en">
<?php include "_addpage_head.html"; ?>
<body class=container>
<h1 class=title-design>Add a project :</h1>

<form method="GET" action="addpage.php">
    <div class="form-group">
        <label for="addProject_title">Tip a title for your project</label>
        <input class="form-control" type="text" name="addProject_title"></input>
    </div>

    <div class="form-group">
        <label for="addProject_description">Define a description for your project</label>
        <textarea class="form-control" name="addProject_description"></textarea>
    </div>

    <div class="form-group">
        <label for="addProject_image">Choose an image for your project</label>
        <input class="form-control" type="file" name="addProject_image"></textarea>
    </div>

    <input type="hidden" name="addProject_csrf_token" value="<?php echo $token ?? ''; ?>"
    />

    <div class="form-group cc">
        <button class="btn btn-default" type="submit">Submit</button>
    </div>
</form>

</body>
</html>