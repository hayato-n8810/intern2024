<?php

/**
 * 課題3：セッションが確立しているとき，セッションを破棄してログアウトする処理を書いてください
 */
session_start();

if (isset($_POST["logout"])) {
    // セッションを破棄
    $_SESSION = array();
    session_destroy();
    echo "セッションが削除されました";
}

// table.phpのurlを作成
$tableUrl = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . "/prac/table.php";
//リダイレクト
header("Location: $tableUrl");
exit();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <h2>ログアウト</h2>
    <form action="logout.php" method="post">
        <button type="submit" name="logout" value="send">ログアウト</button>
    </form>
</body>

</html>