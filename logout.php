<<<<<<< HEAD
<?php

session_start();

if (isset($_SESSION["NAME"]))
{
    $errorMessage = "ログアウトしました。";
}
else {
    $errorMessage = "セッションがタイムアウトしました。";
}

// セッションの変数のクリア
$_SESSION = array();

// セッションクリア
@session_destroy();

//トップページに移動
header("Location:index.php");

?>

<!--<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ログアウト</title>
</head>
<body>
<h1>ログアウト画面</h1>
<div><?php /*echo htmlspecialchars($errorMessage, ENT_QUOTES); */?></div>
<ul>
    <li><a href="Login.php">ログイン画面に戻る</a></li>
</ul>
</body>
=======
<?php

session_start();

if (isset($_SESSION["NAME"]))
{
    $errorMessage = "ログアウトしました。";
}
else {
    $errorMessage = "セッションがタイムアウトしました。";
}

// セッションの変数のクリア
$_SESSION = array();

// セッションクリア
@session_destroy();

//トップページに移動
header("Location:index.php");

?>

<!--<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ログアウト</title>
</head>
<body>
<h1>ログアウト画面</h1>
<div><?php /*echo htmlspecialchars($errorMessage, ENT_QUOTES); */?></div>
<ul>
    <li><a href="Login.php">ログイン画面に戻る</a></li>
</ul>
</body>
>>>>>>> 6e9b1081f50432738fedfee39fcdb0908fc47cc1
</html>-->