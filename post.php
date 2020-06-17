<?php
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
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

require 'ImageUploader.php';

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



<!--          <div class="btn">
              Upload!
              <form action="" method="post" enctype="multipart/form-data" id="my_form">
                  <input type="hidden" name="MAX_FILE_SIZE" value="<?php /*echo h(MAX_FILE_SIZE); */?>">
                  <input type="file" name="image" id="my_file">
              </form>
          </div>-->
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


            <!--
          <ul>
              <?php /*foreach ($images as $image) : */?>
                  <li>
                      <a href="<?php /*echo h(basename(IMAGES_DIR)) . '/' . h(basename($image)); */?>">
                          <img src="<?php /*echo h($image); */?>">
                      </a>
                  </li>
              <?php /*endforeach; */?>
          </ul>-->

<!--          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

          <script>
              $(function() {
                  $('.msg').fadeOut(3000);
                  $('#my_file').on('change', function() {
                      $('#my_form').submit();
                  });
              });
          </script>
-->

<!--        <div class="lessons">
          <div class="lesson">
            <div class="lesson-icon">
                <dt><a href="#"><img src="sample1.jpg"></a></dt>
            </div>
            <p>投稿者：test<br>日付：2014/10/25</p>
            <p class="text-contents2">近所のサイクリングコースを走ってきました。天気が良くて最高でした。</p>
          </div>
          <div class="lesson">
            <div class="lesson-icon">
                    <dt><a href="#"><img src="sample2.jpg" alt="" width="150" height="120"></a></dt>
            </div>
            <p>投稿者：tanaka<br>日付：2019/10/25</p>
            <p class="text-contents2">ひさしぶりの休日。友人達と3人で。雨が降った後だったからか、地面には木の葉がたくさん落ちていました。秋ですね。</p>
          </div>
          <div class="lesson">
            <div class="lesson-icon">
                    <dt><a href="#"><img src="sample3.jpg" alt="" width="150" height="120"></a></dt>
            </div>
          <p>投稿者：suzuki<br>日付：2020/5/25</p>
            <p class="text-contents2">家から片道50km。今日は本格的な山岳コースに挑戦しました。たくさん登って疲れてへとへとです。</p>
          </div>
          <div class="lesson">
            <div class="lesson-icon">
                    <dt><a href="#"><img src="sample4.jpg" alt="" width="150" height="120"></a></dt>
            </div>
              <p>投稿者：sky<br>日付：2020/2/25</p>
            <p class="text-contents2">新しく買った自転車で近所に買い物へ。いい気分転換になりました。何を買ったのかは内緒です。</p>
          </div>
          <div class="lesson">
          <div class="lesson-icon">
              <dt><a href="#"><img src="sample5.jpg" alt="" width="150" height="120"></a></dt>
          </div>
          <p>投稿者：sea<br>日付：2016/12/14</p>
          <p class="text-contents2">今日は車で遠征して色んな所を走りました。ここがその中で1番おすすめの絶景ポイントです。</p>
          </div>
            <div class="lesson">
            <div class="lesson-icon">
                <dt><a href="#"><img src="sample6.jpg" alt="" width="150" height="120"></a></dt>
            </div>
            <p>投稿者：green<br>日付：2018/2/3</p>
            <p class="text-contents2">近所の公園で一休み。ベンチで本を読みました。しばらくすると天気が悪くなってきたので急いで帰りました。</p>
          </div>
          <div class="clear"></div>
        </div>-->

          <p><a href="list.php" class="btn signup">戻る</a></p>
            <br><br><br>
      </div>
    </div>
<!-- ページを選択できるようにしたい    <div class="message-wrapper">
      <div class="container">
        <div class="heading">
          <h2>xxxx</h2>
          <h3>xxxxx</h3>
        </div>
        <span class="btn message">xxxxx</span>
      </div>
    </div>-->


    <footer>
        <div class="container">
            <a href="list.php"><img src="cyclink-logo.png"></a>
            <p>Copyright ©2020 CYCLINK Inc. All rights reserved.</p>
        </div>
    </footer>
  </body>
</html>