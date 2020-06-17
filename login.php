<?php
// セッション開始
session_start();

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "root";  // ユーザー名のパスワード
$db['dbname'] = "db1";  // データベース名

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["name"])) {  // emptyは値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    }

    if (!empty($_POST["name"]) && !empty($_POST["password"])) {
        // 入力したユーザIDを格納
        $name = $_POST["name"];

        // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare('SELECT * FROM T_USER WHERE name = ?');
            $stmt->execute(array($name));
            $password = $_POST["password"];

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $row['PASSWORD'])) {
                    session_regenerate_id(true);
                    $_SESSION["USERNO"] = $row['USERNO'];
                    $_SESSION["NAME"] = $row['NAME'];
                    header("Location: list.php");  // メイン画面へ遷移
                    exit();  // 処理終了
                } else {
                    // 認証失敗
                    $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
                }
            } else {
                // 4. 認証成功なら、セッションIDを新規に発行する
                // 該当データなし
                $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
            }
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            //$errorMessage = $sql;
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();
        }
    }
}

// テストログインボタンが押された場合（共通なので別のファイルにしたい）
if (isset($_POST["test"])) {

    // 入力したユーザIDを格納
    $name = "test";

    // 2. ユーザIDとパスワードが入力されていたら認証する
    $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

    // 3. エラー処理
    try {
        $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

        $stmt = $pdo->prepare('SELECT * FROM T_USER WHERE name = ?');
        $stmt->execute(array($name));
        $password = "test";

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password, $row['PASSWORD'])) {
                session_regenerate_id(true);
                $_SESSION["USERNO"] = $row['USERNO'];
                $_SESSION["NAME"] = $row['NAME'];
                header("Location: list.php");  // メイン画面へ遷移
                exit();  // 処理終了
            } else {
                // 認証失敗
                $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
            }
        } else {
            // 4. 認証成功なら、セッションIDを新規に発行する
            // 該当データなし
            $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
        }
    } catch (PDOException $e) {
        $errorMessage = 'データベースエラー';
        //$errorMessage = $sql;
        // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
        // echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CYCLINK</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="responsive.css">
    <!--link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">-->
  </head>
  <body>
    <header>
      <div class="container">
        <div class="header-left">
            <a href="index.php"><img src="cyclink-logo.png"></a>
        </div>
<!--        <span class="fa fa-bars menu-icon">
        <li><a href="#">Page 1</a></li>
        <li><a href="#">Page 2</a></li>
        <li><a href="#">Page 3</a></li>
        </span>-->
        <div class="header-right">
          <a href="registration.php">新規登録</a>
          <a href="login.php" class="login">ログイン</a>
        </div>
        <div id="nav-drawer">
          <input id="nav-input" type="checkbox" class="nav-unshown">
          <label id="nav-open" for="nav-input"><span></span></label>
          <label class="nav-unshown" id="nav-close" for="nav-input"></label>
          <div id="nav-content">
              <p><a href="registration.php">新規登録</a></p>
              <p><a href="login.php">ログイン</a></p>
          </div>
        </div>
      </div>
    </header>

    <div class="top-wrapper2">
        <div class="container2">

            <form id="testForm" name="testForm" action="" method="POST">
                <input type="submit" id="test" name="test" value="テストユーザーでログインする" class="btn btn-wrapper test">
            </form>

        <h2>ログイン</h2>

        <form id="loginForm" name="loginForm" action="" method="POST">
<!--            <fieldset>-->
<!--                <legend>ログインフォーム</legend>-->
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
            <p><label for="name">ニックネーム</label><br>
                <input type="text" id="name" name="name" placeholder="ニックネームを入力" value="<?php if (!empty($_POST["name"])) {echo htmlspecialchars($_POST["name"], ENT_QUOTES);} ?>"></p>

            <p><label for="password">パスワード</label><br>
                <input type="password" id="password" name="password" value="" placeholder="パスワードを入力"></p>
                <input type="submit" id="login" name="login" value="ログイン" class="btn signup btn-wrapper">
            </fieldset>
<!--        </form>-->
            <p><a href="index.php" class="btn signup">戻る</a></p>
        </div>
    </div>

    <footer>
      <div class="container">
        <a href="index.php"><img src="cyclink-logo.png"></a>
        <p>Copyright ©2020 CYCLINK Inc. All rights reserved.</p>
      </div>
    </footer>
  </body>
</html>