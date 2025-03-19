<?php
session_start();

if (isset($_SESSION['user_id'])) {
    // ログアウトボタン表示
    echo "<h3>ログアウト</h3>";
    echo "<form action='logout.php' method='post'>";
    echo   "<button type='submit' name='logout' value='send'>ログアウト</button>";
    echo "</form>";
    /**
     * 課題：ここにechoでHTMLタグを書いてコメント投稿フォームを出力してください
     */
    $html = <<<TEXT
    <h2>コメント入力</h2>
    <form action="comment.php" method="post">
        コメント: <input type="text" name="comment" /><br />
        <input type="submit" />
    </form>
TEXT;
    echo $html;
} else {
    // ログインボタン表示（ログイン画面に遷移）
    echo "<h3>ログイン</h3>";
    echo "<form action='http://localhost:8080/prac/login.php' method='get'>";
    echo   "<button type='submit'>ログイン</button>";
    echo "</form>";
}

// 接続
$mysqli = new mysqli('localhost', 'intern', 'password', 'test_session');

//接続状況の確認
if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
}

/**
 * 課題：結合したテーブルをSELECTして$result変数に格納する処理を書いてください
 */

// SQLクエリの作成
$sql = "SELECT comments.id, user_name, text FROM `trx_comments` AS `comments` INNER JOIN `trx_users` AS `users` ON `users`.`id` = `comments`.`user_id`";
$stmt = $mysqli->prepare($sql);

// クエリの実行
$result = $mysqli->query($sql);

echo "<table>\n";
echo "<tr><th>ID</th><th>ユーザ名</th><th>コメント</th></tr>\n";
while ($row = $result->fetch_assoc()) {
    // 何行も文字列書くときはこのようなヒアドキュメントが便利
    $html = <<<TEXT
<tr>
  <td>{$row['id']}</td>
  <td>{$row['user_name']}</td>
  <td>{$row['text']}</td>
</tr>
TEXT;
    echo $html;
}
echo "</table>";
