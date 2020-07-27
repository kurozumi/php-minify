#!/usr/bin/env php
<?php
if (!isset($argv[1])) {
    return;
}

if (!is_file($argv[1])) {
    return;
}

$source = file_get_contents($argv[1]);
$tokens = token_get_all($source);

$code = '';
foreach ($tokens as $token) {
    if (is_string($token)) {
        // 簡単な1文字毎のトークン
        $code .= $token;
    } else {
        // トークン配列
        list($id, $text) = $token;
        switch ($id) {
            case T_COMMENT:
            case T_DOC_COMMENT:
                // コメントの場合は前後に改行を入れる
                $code .= PHP_EOL . $text . PHP_EOL;
                break;
            case T_WHITESPACE:
                // 空白だったら出力
                if (strlen($text) === 1) {
                    $code .= $text;
                }
                break;
            default:
                // それ以外の場合 -> "そのまま"出力
                $code .= $text;
                break;
        }
    }
}
$stdout = fopen('php://stdout', 'w');
fwrite($stdout, $code);
