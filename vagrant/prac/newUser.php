<?php

/**
 * 課題１：mysqliを用いてMySQLに接続し，POSTで受け取ったデータをtrx_usersにINSERTする処理を書いてください
 * パスワードはハッシュ化する必要があるので，以下の$password_hashを用いてください
 */
// 接続
$mysqli = new mysqli('localhost', 'intern', 'password', 'test_session');

//接続状況の確認
if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
} else {
    $mysqli->set_charset('utf8');
}

if (!empty($_POST["username"]) and !empty($_POST["password"])) {

    // サニタイジングした値を格納
    $user = htmlspecialchars($_POST["username"], ENT_QUOTES, 'utf8');
    $password = htmlspecialchars($_POST["password"], ENT_QUOTES, 'utf8');
    // ハッシュ化
    $password_hash = hash("sha256", $password);

    // trx_usersに格納
    $stmt = $mysqli->prepare("INSERT INTO trx_users (user_name, password) VALUES (?, ?)");
    $stmt->bind_param('ss', $user, $password_hash);
    $stmt->execute();

    $stmt->close();

    // 切断
    $mysqli->close();

    // POSTデータを削除
    $_POST = array();

    // login.phpへリダイレクト
    header("Location: /prac/login");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <h2>ユーザ追加</h2>
    <h3>以下に必要事項を入力してください</h3>
    <form action="newUser.php" method="post">
        ユーザ: <input type="text" name="username" required /><br />
        パスワード: <input type="password" name="password" required /><br />
        <input type="submit" />
    </form>
</body>

</html>