<?php
$user = "root";
$pass = "root";

//DBと接続
try{
    $pdo = new PDO('mysql:host=localhost;dbname=2chan-bbs', $user, $pass);

} catch (PDOException $error ) {
    echo $error->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2ちゃんねる掲示板</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <header>
        <h1 class="title">2ちゃんねる掲示板</h1>
        <hr>
    </header>

    <?php include("app/parts/validation.php"); ?>
    <?php include("app/parts/thread.php"); ?>    
    <?php include("app/parts/newThreadButton.php"); ?>    
</body>
</html>