<?php

/**
 * コメント投稿したときに呼ばれる想定
 */
session_start();

if (!isset($_SESSION['user_id'])) {
    //ログインしていないときは処理されたくない
    echo "Bad Request";
    exit();
}

// 接続
$mysqli = new mysqli('localhost', 'intern', 'password', 'test_session');

//接続状況の確認
if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
}

/**
 * 課題：trx_commentsにPOSTされたコメントとログインしているユーザのidをINSERTで追加する処理を書いてください
 */
// サニタイジングした値を格納
$comment = htmlspecialchars($_POST["comment"], ENT_QUOTES, 'utf8');

// trx_commentsに格納
$stmt = $mysqli->prepare("INSERT INTO trx_comments (user_id, text) VALUES (?, ?)");
$stmt->bind_param('ss', $_SESSION['user_id'], $comment);
$stmt->execute();

$stmt->close();

// table.phpのurlを作成
$tableUrl = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . "/prac/table.php";

//リダイレクト（table.phpにリダイレクトすると自然な流れになると思います）
header("Location: $tableUrl");
