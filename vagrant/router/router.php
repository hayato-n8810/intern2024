<?php
// ルーティング
$routes = [
    "" => "table.php",
    "table" => "table.php",
    "login" => "login.php",
    "logout" => "logout.php",
    "register" => "newUser.php",
];

// リクエストURIを取得し、"/prac/" 以降の部分を抽出
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = "/prac/";

// /prac/ の位置を探し、その後の部分を取得
$position = strpos($request_uri, $base_path);

// /prac/ の後のパスを取得
$sub_path = substr($request_uri, $position + strlen($base_path));
$sub_path = trim($sub_path, "/"); // 余分なスラッシュを除去

// 対応するPHPファイルがあるか確認
if (array_key_exists($sub_path, $routes)) {
    // 各ファイルまでのパスの作成
    $target_file = __DIR__ . '/../prac/' . $routes[$sub_path];
    // ファイルが存在すれば表示
    if (file_exists($target_file)) {
        include $target_file;
        exit;
    }
}

// ファイルが存在しない場合は404エラー
http_response_code(404);
// デフォルトの404エラーページを表示
header("Location: /404.html");
exit;
