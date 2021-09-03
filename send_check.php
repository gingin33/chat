<?php
session_start();
session_regenerate_id(true);
/*if (isset($_SESSION['login']) == false) {
    print '<a href="login.php">ログイン</a>';
    print '<br />';
} else {
    print $_SESSION['login_name'] . 'さんがログイン中<br />';
    print '<a href="logout.php">ログアウト</a>';
    print '<br />';
}*/
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Webサイト</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://unpkg.com/destyle.css@1.0.5/destyle.css">
    <link rel="stylesheet" href="webMoblie.css">
</head>

<body>
    <?php
    require_once('../common/common.php');

    $post = sanitize($_POST);
    $_SESSION['name'] = $post['name'];
    $user = $_SESSION['name'];
    $_SESSION['text'] = $post['text'];
    $text = $_SESSION['text'];

    if ($text == false) {
        print '本文を入力してください。<br />';
        print '<input type="button" onclick="history.back()" value="戻る">';
        exit();
    }
    if(mb_strlen($text, 'UTF-8') > 1000){
        print '文字数が上限(1000文字)を超えています。<br />';
        print '<input type="button" onclick="history.back()" value="戻る">';
        exit();
    }
    if($user == false){
        $user = '名無しさん';
    }
    print '以下の内容で送信しますか？<br />';
    print '=================================<br />';
    print nl2br($text) . '<br />';
    print '=================================<br /><br />';
    print '<form method="post" action="send_done.php">';
    print '<input type="button" onclick="history.back()" value="戻る"></input>';
    print '<input type="hidden" name="name" value="' . $user . '">';
    print '<input type="hidden" name="text" value="' . $text . '">';
    print '<input type="submit" value="送信">';
    print '</form>';
    ?>
</body>

</html>
