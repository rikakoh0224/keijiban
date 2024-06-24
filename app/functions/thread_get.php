<?php

$thread_array = array();

// スレッドデータをテーブルから取得する
$sql = "SELECT * FROM thread";
$statement = $pdo->prepare($sql);
$statement->execute();

$thread_array = $statement;