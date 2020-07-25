#!/usr/bin/env php
<?php
if(!isset($argv[1])) {
    return;
}

if(!is_file($argv[1])) {
    return;
}

$source = file_get_contents($argv[1]);
$tokens = token_get_all($source);

foreach ($tokens as $token) {
    if (is_string($token)) {
        // 簡単な1文字毎のトークン
        echo $token;
    } else {
        // トークン配列
        list($id, $text) = $token;
        switch ($id) {
            case T_COMMENT:
            case T_DOC_COMMENT:
                // コメントの場合は前後に改行を入れる
                echo PHP_EOL.$text.PHP_EOL;
                break;
            case T_WHITESPACE:
                // 空白だったら出力
                if(strlen($text) === 1) {
                    echo $text;
                }
                break;
            default:
                // それ以外の場合 -> "そのまま"出力
                echo $text;
                break;
        }
    }
}
