<?php
$error_message = array();
        //なぜarrayか　-> 条件によって出したいメッセージが違うため、複数メッセージを用意したい

session_start();

    if(isset($_POST["submitButton"])){

        //お名前入力チェック
        if(empty($_POST["username"])){
            $error_message["username"] = "お名前を入力してください。";
        } else {
            //エスケープ処理
            $escaped["username"] = htmlspecialchars($_POST["username"], ENT_QUOTES, "UTF-8");
            $_SESSION["username"] = $escaped["username"];
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

            try{
                $sql = "INSERT INTO `comment` (`username`, `text`, `post_date`, `thread_id`) 
                VALUES (:username, :text, :post_date, :thread_id);";
                $statement = $pdo->prepare($sql);
    
                //値をセットする
                $statement->bindParam(":username", $escaped["username"], PDO::PARAM_STR);
                $statement->bindParam(":text", $escaped["text"], PDO::PARAM_STR);
                $statement->bindParam(":post_date", $post_date, PDO::PARAM_STR);
                $statement->bindParam(":thread_id", $_POST["threadID"], PDO::PARAM_STR);
    
                $statement->execute();

                $pdo->commit();

            } catch(Exception $error) {
                $pdo->rollBack();
            }

        }
    }  