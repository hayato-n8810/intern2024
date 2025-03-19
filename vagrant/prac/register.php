<section>
    <form action="" method="post">
        名前:<br>
        <input type="text" name="name" value=""><br>
        <br>
        パスワード:<br>
        <input type="text" name="password" value=""><br>
        <input type="submit" value="登録">
    </form>
</section>

<?php
// 接続
$mysqli = new mysqli('localhost', 'intern', 'password', 'test');

//接続状況の確認
if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
} else {
    $mysqli->set_charset('utf8');
}

// サニタイジングした値を格納
$name = htmlspecialchars($_POST["name"], ENT_QUOTES, 'utf8');
$pass = htmlspecialchars($_POST["password"], ENT_QUOTES, 'utf8');

$stmt = $mysqli->prepare("INSERT INTO user (name, password) VALUES (?, ?)");
$stmt->bind_param('ss', $name, $pass);
$stmt->execute();

$stmt->close();

// 切断
$mysqli->close();
?>