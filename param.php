<?php

/*$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "root";  // ユーザー名のパスワード
$db['dbname'] = "db1";  // データベース名

//azureの場合はこちらを使う
$db['host'] = "127.0.0.1; port=50474";  // DBサーバのURLとポート番号
$db['user'] = "azure";  // ユーザー名
$db['pass'] = "6#vWHD_$";  // ユーザー名のパスワード
$db['dbname'] = "db1";  // データベース名*/

$localdb = getenv('MYSQLCONNSTR_localdb');//可変のポート番号が格納される環境変数
/*if(empty($localdb)) {*/
    if (preg_match('/Data Source=127.0.0.1:([0-9]*);/', $localdb, $tmps)) {
        $port = $tmps[1];
        //azureの場合はこちらを使う
        $db['host'] = "127.0.0.1; port=${port}";  // DBサーバのURLとポート番号
        $db['user'] = "azure";  // ユーザー名
        $db['pass'] = "6#vWHD_$";  // ユーザー名のパスワード
        $db['dbname'] = "db1";  // データベース名*/
    } else {
        $db['host'] = "localhost";  // DBサーバのURL
        $db['user'] = "root";  // ユーザー名
        $db['pass'] = "root";  // ユーザー名のパスワード
        $db['dbname'] = "db1";  // データベース名
    }
/*}*/
?>