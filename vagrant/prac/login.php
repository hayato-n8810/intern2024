<?php
session_start();
//MySQLに接続
$mysqli = new mysqli('localhost', 'intern', 'password', 'test_session');

if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
}

/**
 * 課題２：データベースにPOSTで取得したusername,password(ハッシュ化)と一致するものがあればセッションを開始し
 * $_SESSION['user_id']にユーザIDを,$_SESSION['user_name']にユーザ名を格納する処理を書いてください
 */

// サニタイジングした値を格納
$user = htmlspecialchars($_POST["username"], ENT_QUOTES, 'utf8');
$password = htmlspecialchars($_POST["password"], ENT_QUOTES, 'utf8');
// ハッシュ化
$password_hash = hash("sha256", $password);

// SQLクエリの作成
$sql = "SELECT id, user_name FROM trx_users WHERE user_name = ? AND password = ?";
$stmt = $mysqli->prepare($sql);

// プレースホルダに値をバインド
$stmt->bind_param('ss', $user, $password_hash);

// クエリの実行
$stmt->execute();
// 結果の取得
$result = $stmt->get_result();

// データが存在する場合、セッションに保存
if ($val = $result->fetch_assoc()) {
    $_SESSION['user_id'] = $val['id'];
    $_SESSION['user_name'] = $val['user_name'];
}

if (isset($_SESSION['user_id'])) {
    // SESSION[user_id]に値入っていればログインしたとみなす
    echo $_SESSION['user_id'];
    echo $_SESSION['user_name'];
    echo "既にログインしています";

    // table.phpのurlを作成
    $tableUrl = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . "/prac/table.php";
    //リダイレクト
    header("Location: $tableUrl");
    exit();
}

$stmt->close();

// 切断
$mysqli->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <h2>ログイン</h2>
    <form action="login.php" method="post">
        ユーザ: <input type="text" name="username" /><br />
        パスワード: <input type="password" name="password" /><br />
        <input type="submit" />
    </form>
</body>

</html>