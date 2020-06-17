<<<<<<< HEAD
<?php
// セッション開始
session_start();

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "root";  // ユーザー名のパスワード
$db['dbname'] = "db1";  // データベース名

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$signUpMessage = "";

// ログインボタンが押された場合
if (isset($_POST["signUp"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["username"])) {  // 値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    } else if (empty($_POST["password2"])) {
        $errorMessage = 'パスワードが未入力です。';
    }

    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] === $_POST["password2"]) {
        // 入力したユーザIDとパスワードを格納
        $username = $_POST["username"];
        $password = $_POST["password"];

        // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare("INSERT INTO T_USER(name, password) VALUES (?, ?)");

            $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT)));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）
            $userid = $pdo->lastinsertid();  // 登録した(DB側でauto_incrementした)IDを$useridに入れる

            $stmt = $pdo->prepare('SELECT * FROM T_USER WHERE name = ?');
            $stmt->execute(array($username));

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $row['PASSWORD'])) {
                    session_regenerate_id(true);
                    $_SESSION["NAME"] = $row['NAME'];
                    header("Location: list.php");  // メイン画面へ遷移
                    $signUpMessage = '登録が完了しました。あなたの登録IDは '. $userid. ' です。パスワードは '. $password. ' です。';  // ログイン時に使用するIDとパスワード

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
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();
        }
    } else if($_POST["password"] != $_POST["password2"]) {
        $errorMessage = 'パスワードに誤りがあります。';
    }
}

// テストログインボタンが押された場合
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
    <title>login</title>
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
        <h2>新規登録</h2>
            <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
            <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>

            <form id="loginForm" name="loginForm" action="" method="POST">
            <p><label for="username">ニックネーム</label><br>
            <input type="text" id="username" name="username" placeholder="ニックネームを入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>"></p>
            <p><label for="password">パスワード</label><br>
            <input type="password" id="password" name="password" value="" placeholder="パスワードを入力"></p>
            <p><label for="password2">パスワード（確認用）</label><br>
            <input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力"></p>
                <input type="submit" id="signUp" name="signUp" value="登録する" class="btn signup btn-wrapper">


                <!--            </fieldset>-->
        </form>
<!--        <form action="index.php">-->
<!--            <input type="submit" value="戻る">-->
            <p><a href="index.php" class="btn signup">戻る</a></p>
<!--        </form>-->
        </div>
    </div>

<!--    <div class="top-wrapper">
      <div class="container">
        <h1>CYCLINKをはじめよう</h1>
        <p>CYCLINKはサイクリング中に撮った写真を共有するサービスです。</p>
        <p>お気に入りの場所や体験を共有しましょう。</p>
        <div class="btn-wrapper">
            <p><a href="index-registration.php" class="btn signup">はじめる</a></p>
            <p><a href="#explanation" class="btn signup">使い方</a></p>
             <a href="#" class="btn twitter"><span class="fa fa-twitter"></span>つかい方</a>
            <a href="#" class="btn facebook"><span class="fa fa-facebook"></span>はじめる</a>
            <a href="#" class="btn twitter"><span class="fa fa-twitter"></span>使い方</a>
        </div>
      </div>
    </div> -->

<!--    <a name="explanation"></a>-->
  <!--  <div class="lesson-wrapper">

      <div class="container">
        <div class="heading">
            <h2>CYCLINKの使い方</h2>
        </div>
        <div class="lessons">
          <div class="lesson">
            <div class="lesson-icon">
              <img src="https://prog-8.com/images/html/advanced/html.png">
              <p>HTML & CSS</p>
            </div>
            <p class="text-contents">Webページの作成に使用される言語です。HTMLとCSSを組み合わせることで、静的なページを作り上げることができます。</p>
          </div>
          <div class="lesson">
            <div class="lesson-icon">
              <img src="https://prog-8.com/images/html/advanced/jQuery.png">
              <p>jQuery</p>
            </div>
            <p class="text-contents">素敵な動きを手軽に実装できるJavaScriptライブラリです。 アニメーション効果をつけたり、Ajax（エイジャックス）を使って外部ファイルを読み込んだりと色々なことができます。</p>
          </div>
          <div class="lesson">
            <div class="lesson-icon">
              <img src="https://prog-8.com/images/html/advanced/ruby.png">
              <p>Ruby</p>
            </div>
            <p class="text-contents">オープンソースの動的なプログラミング言語で、 シンプルさと高い生産性を備えています。大きなWebアプリケーションから小さな日用ツールまで、さまざまなソフトウェアを作ることができます。</p>
          </div>
          <div class="lesson">
            <div class="lesson-icon">
              <img src="https://prog-8.com/images/html/advanced/php.png">
              <p>PHP</p>
            </div>
            <p class="text-contents">HTMLだけではページの内容を変えることはできません。PHPはHTMLにプログラムを埋め込み、それを可能にします。</p>
          </div>
          <div class="clear"></div>
        </div>
      </div>
    </div>
    <div class="message-wrapper">
      <div class="container">
        <div class="heading">
          <h2>さぁ、あなたもProgateでプログラミングを学んでみませんか?</h2>
          <h3>Let's learn to code, learn to be creative!</h3>
        </div>
        <span class="btn message">さっそく開発する</span>
      </div>
    </div>-->
    <footer>
      <div class="container">
        <a href="index.php"><img src="cyclink-logo.png"></a>
        <p>Copyright ©2020 CYCLINK Inc. All rights reserved.</p>
      </div>
    </footer>
  </body>
=======
<?php
// セッション開始
session_start();

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "root";  // ユーザー名のパスワード
$db['dbname'] = "db1";  // データベース名

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$signUpMessage = "";

// ログインボタンが押された場合
if (isset($_POST["signUp"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["username"])) {  // 値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    } else if (empty($_POST["password2"])) {
        $errorMessage = 'パスワードが未入力です。';
    }

    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] === $_POST["password2"]) {
        // 入力したユーザIDとパスワードを格納
        $username = $_POST["username"];
        $password = $_POST["password"];

        // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare("INSERT INTO T_USER(name, password) VALUES (?, ?)");

            $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT)));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）
            $userid = $pdo->lastinsertid();  // 登録した(DB側でauto_incrementした)IDを$useridに入れる

            $stmt = $pdo->prepare('SELECT * FROM T_USER WHERE name = ?');
            $stmt->execute(array($username));

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $row['PASSWORD'])) {
                    session_regenerate_id(true);
                    $_SESSION["NAME"] = $row['NAME'];
                    header("Location: list.php");  // メイン画面へ遷移
                    $signUpMessage = '登録が完了しました。あなたの登録IDは '. $userid. ' です。パスワードは '. $password. ' です。';  // ログイン時に使用するIDとパスワード

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
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();
        }
    } else if($_POST["password"] != $_POST["password2"]) {
        $errorMessage = 'パスワードに誤りがあります。';
    }
}

// テストログインボタンが押された場合
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
    <title>login</title>
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
        <h2>新規登録</h2>
            <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
            <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>

            <form id="loginForm" name="loginForm" action="" method="POST">
            <p><label for="username">ニックネーム</label><br>
            <input type="text" id="username" name="username" placeholder="ニックネームを入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>"></p>
            <p><label for="password">パスワード</label><br>
            <input type="password" id="password" name="password" value="" placeholder="パスワードを入力"></p>
            <p><label for="password2">パスワード（確認用）</label><br>
            <input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力"></p>
                <input type="submit" id="signUp" name="signUp" value="登録する" class="btn signup btn-wrapper">


                <!--            </fieldset>-->
        </form>
<!--        <form action="index.php">-->
<!--            <input type="submit" value="戻る">-->
            <p><a href="index.php" class="btn signup">戻る</a></p>
<!--        </form>-->
        </div>
    </div>

<!--    <div class="top-wrapper">
      <div class="container">
        <h1>CYCLINKをはじめよう</h1>
        <p>CYCLINKはサイクリング中に撮った写真を共有するサービスです。</p>
        <p>お気に入りの場所や体験を共有しましょう。</p>
        <div class="btn-wrapper">
            <p><a href="index-registration.php" class="btn signup">はじめる</a></p>
            <p><a href="#explanation" class="btn signup">使い方</a></p>
             <a href="#" class="btn twitter"><span class="fa fa-twitter"></span>つかい方</a>
            <a href="#" class="btn facebook"><span class="fa fa-facebook"></span>はじめる</a>
            <a href="#" class="btn twitter"><span class="fa fa-twitter"></span>使い方</a>
        </div>
      </div>
    </div> -->

<!--    <a name="explanation"></a>-->
  <!--  <div class="lesson-wrapper">

      <div class="container">
        <div class="heading">
            <h2>CYCLINKの使い方</h2>
        </div>
        <div class="lessons">
          <div class="lesson">
            <div class="lesson-icon">
              <img src="https://prog-8.com/images/html/advanced/html.png">
              <p>HTML & CSS</p>
            </div>
            <p class="text-contents">Webページの作成に使用される言語です。HTMLとCSSを組み合わせることで、静的なページを作り上げることができます。</p>
          </div>
          <div class="lesson">
            <div class="lesson-icon">
              <img src="https://prog-8.com/images/html/advanced/jQuery.png">
              <p>jQuery</p>
            </div>
            <p class="text-contents">素敵な動きを手軽に実装できるJavaScriptライブラリです。 アニメーション効果をつけたり、Ajax（エイジャックス）を使って外部ファイルを読み込んだりと色々なことができます。</p>
          </div>
          <div class="lesson">
            <div class="lesson-icon">
              <img src="https://prog-8.com/images/html/advanced/ruby.png">
              <p>Ruby</p>
            </div>
            <p class="text-contents">オープンソースの動的なプログラミング言語で、 シンプルさと高い生産性を備えています。大きなWebアプリケーションから小さな日用ツールまで、さまざまなソフトウェアを作ることができます。</p>
          </div>
          <div class="lesson">
            <div class="lesson-icon">
              <img src="https://prog-8.com/images/html/advanced/php.png">
              <p>PHP</p>
            </div>
            <p class="text-contents">HTMLだけではページの内容を変えることはできません。PHPはHTMLにプログラムを埋め込み、それを可能にします。</p>
          </div>
          <div class="clear"></div>
        </div>
      </div>
    </div>
    <div class="message-wrapper">
      <div class="container">
        <div class="heading">
          <h2>さぁ、あなたもProgateでプログラミングを学んでみませんか?</h2>
          <h3>Let's learn to code, learn to be creative!</h3>
        </div>
        <span class="btn message">さっそく開発する</span>
      </div>
    </div>-->
    <footer>
      <div class="container">
        <a href="index.php"><img src="cyclink-logo.png"></a>
        <p>Copyright ©2020 CYCLINK Inc. All rights reserved.</p>
      </div>
    </footer>
  </body>
>>>>>>> 6e9b1081f50432738fedfee39fcdb0908fc47cc1
</html>