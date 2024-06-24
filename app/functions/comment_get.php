<?php

$comment_array = array();

// コメントデータをテーブルから取得する
$sql = "SELECT * FROM comment";
$statement = $pdo->prepare($sql);
$statement->execute();

$comment_array = $statement;