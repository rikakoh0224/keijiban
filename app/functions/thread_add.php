<?php
$error_message = array();

    if(isset($_POST["threadSubmitButton"])){

        // スレッド名入力チェック
        if(empty($_POST["title"])){
            $error_message["title"] = "スレッドタイトルを入力してください。";
        } else {
            //エスケープ処理
            $escaped["title"] = htmlspecialchars($_POST["title"], ENT_QUOTES, "UTF-8");
        }

        // お名前入力チェック
        if(empty($_POST["username"])){
            $error_message["username"] = "お名前を入力してください。";
        } else {
            //エスケープ処理
            $escaped["username"] = htmlspecialchars($_POST["username"], ENT_QUOTES, "UTF-8");
        }

        //コメント入力チェック
        if(empty($_POST["text"])){
            $error_message["text"] = "コメントを入力してください。";
        } else {
            //エスケープ処理
            $escaped["text"] = htmlspecialchars($_POST["text"], ENT_QUOTES, "UTF-8");
        }
        
        if(empty($error_message)){
            $post_date = date("Y-m-d H:i:s");

            // トランザクション開始
            $pdo->beginTransaction();

            try {
                //スレッドを追加
                $sql = "INSERT INTO `thread` (`title`) VALUES (:title);";
                $statement = $pdo->prepare($sql);
    
                //値をセットする
                $statement->bindParam(":title", $escaped["title"], PDO::PARAM_STR);
    
                $statement->execute();
    
                //コメントを追加
                $sql = "INSERT INTO comment (username, text, post_date, thread_id) 
                VALUES (:username, :text, :post_date, (SELECT id FROM thread WHERE title = :title))";
                $statement = $pdo->prepare($sql);
    
                //値をセット
                $statement->bindParam(":username", $escaped["username"], PDO::PARAM_STR);
                $statement->bindParam(":text", $escaped["text"], PDO::PARAM_STR);
                $statement->bindParam(":post_date", $post_date, PDO::PARAM_STR);
                $statement->bindParam(":title", $escaped["title"], PDO::PARAM_STR);
    
                $statement->execute();

                $pdo->commit();

            } catch (Exception $error) {
                $pdo->rollBack();
            }

        }

        //掲示板ページに遷移
        header("Location: http://localhost:8080/2chan-bbs");
    }  