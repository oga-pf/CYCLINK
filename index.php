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
<!--          <img class="logo" src="cyclink-logo.png">-->
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
    <div class="top-wrapper">
      <div class="container">
        <h1>CYCLINKをはじめよう</h1>
        <p>CYCLINKはサイクリング中に撮った写真を共有するサービスです。</p>
        <p>お気に入りの場所や体験を共有しましょう。</p>
        <div class="btn-wrapper">
            <p><a href="registration.php" class="btn signup">はじめる</a></p>
            <p><a href="#explanation" class="btn signup">使い方</a></p>
            <!-- <a href="#" class="btn twitter"><span class="fa fa-twitter"></span>つかい方</a>
            <a href="#" class="btn facebook"><span class="fa fa-facebook"></span>はじめる</a>
            <a href="#" class="btn twitter"><span class="fa fa-twitter"></span>使い方</a> -->
        </div>
      </div>
    </div>
    <a name="explanation"></a>
    <div class="lesson-wrapper">

      <div class="container">
        <div class="heading">
            <h2>CYCLINKの使い方</h2>
        </div>
        <div class="lessons">
          <div class="lesson">
            <div class="lesson-icon">
              <img src="list.png">
            </div>
              <p>投稿一覧</p>
            <p class="text-contents">CYCLINKに投稿された写真を見ることができます。気に入った写真にGoodやコメントをつけてみましょう。検索機能も使って、お気に入りの写真を探してみて下さい。</p>
          </div>
          <div class="lesson">
            <div class="lesson-icon">
              <img src="post.png">
            </div>
              <p>新規投稿</p>
            <p class="text-contents">あなたが撮った写真を投稿することができます。コメントを入力したり撮影した地域やシチュエーションを選択して、サイクリング中の体験を共有してみましょう。</p>
          </div>
          <div class="lesson">
            <div class="lesson-icon">
              <img src="map.png">
            </div>
            <p>マップ</p>
            <p class="text-contents">CYCLINKに投稿された写真をマップ上に表示します。今度行ってみたいサイクリングスポットが見つかるかもしれません。</p>
          </div>
          <div class="lesson">
            <div class="lesson-icon">
              <img src="mypage.png">
            </div>
            <p>マイページ</p>
            <p class="text-contents">マイページでプロフィールやアイコンの編集することができます。また、あなたの過去に投稿した写真やフォローフォロワーの管理も行うことができます。</p>
          </div>
          <div class="clear"></div>

<!--            <h3>あなたもCYCLINKをはじめてみませんか？</h3>-->
            <!--          <h3>Let's learn to code, learn to be creative!</h3>-->
            <p>
                <br>
          <a href="registration.php"><span class="btn message">さっそくはじめる</span></a>
            </p>
        </div>
      </div>
    </div>
<!--    <div class="message-wrapper">
      <div class="container">
        <div class="heading">
          <h2>あなたもCYCLINKをはじめてみませんか？</h2>
        </div>
          <a href="registration.php"><span class="btn message">さっそくはじめる</span></a>
      </div>
    </div>-->
    <footer>
      <div class="container">
          <a href="index.php"><img src="cyclink-logo.png"></a>
        <p>Copyright ©2020 CYCLINK Inc. All rights reserved.</p>
      </div>
    </footer>
  </body>
</html>