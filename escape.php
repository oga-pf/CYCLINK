<?php
function es($str){
    //文字列をエスケープ処理して出力する
    print htmlspecialchars($str,ENT_QUOTES, 'UTF-8');
}