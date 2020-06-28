<?php

require 'ImageUploader.php';
// 文字列のエスケープ処理
require_once('escape.php');

session_start();
if (empty($_SESSION ['NAME'])) {
    header("Location:index.php");
} else {
}

ini_set('display_errors', 1);
define('MAX_FILE_SIZE', 1 * 1024 * 1024); // 1MB
define('THUMBNAIL_WIDTH', 400);
define('IMAGES_DIR', __DIR__ . '/images');
define('THUMBNAIL_DIR', __DIR__ . '/thumbs');

if (!function_exists('imagecreatetruecolor')) {
    echo 'GD not installed';
    exit;
}

function h($s) {
    return es($s);
}

$uploader = new \MyApp\ImageUploader();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploader->upload();
}

list($success, $error) = $uploader->getResults();

$images = $uploader->getImages();

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CYCLINK</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="responsive.css">
  </head>
  <body>
    <header>
      <div class="container">
        <div class="header-left">
            <a href="list.php"><img src="cyclink-logo.png"></a>
        </div>
        <div class="header-right">
            <a href="list.php">投稿一覧</a>
            <a href="post.php">新規投稿</a>
            <a href="#">マップ</a>
            <a href="#">マイページ</a>
            <a href="logout.php" class="login">ログアウト</a>
        </div>
        <div id="nav-drawer">
          <input id="nav-input" type="checkbox" class="nav-unshown">
          <label id="nav-open" for="nav-input"><span></span></label>
          <label class="nav-unshown" id="nav-close" for="nav-input"></label>
          <div id="nav-content">
              <p><a href="list.php">投稿一覧</a></p>
              <p><a href="post.php">新規投稿</a></p>
              <p><a href="#">マップ</a></p>
              <p><a href="#">マイページ</a></p>
              <p><a href="logout.php">ログアウト</a></p>
          </div>
        </div>
      </div>
    </header>


    <div class=""lesson-wrapper"">
        <div class="container">
            <div class="heading">
                <h2>新規投稿</h2>
            </div>
          <form action="" method="post" enctype="multipart/form-data">
              <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>">
              <input type="file" name="image" class="file-select">
              <br><br>
              <p><textarea name="description"></textarea></p>
              <p><input type="submit" value="投稿する" class="btn signup btn-wrapper"></p>
          </form>
         <?php if (isset($success)) : ?>
              <div class="msg success"><?php echo h($success); ?></div>
            //メインページに移動
            <?php header("Location:list.php");?>
          <?php endif; ?>
          <?php if (isset($error)) : ?>
              <div class="msg error"><?php echo h($error); ?></div>
          <?php endif; ?>
          <p><a href="list.php" class="btn signup">戻る</a></p>
            <br><br><br>
      </div>
    </div>
    <footer>
        <div class="container">
            <a href="list.php"><img src="cyclink-logo.png"></a>
            <p>Copyright ©2020 CYCLINK Inc. All rights reserved.</p>
        </div>
    </footer>
  </body>
</html>