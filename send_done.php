<?php
session_start();
session_regenerate_id(true);

    try {
        require_once('../common/common.php');

        $post = sanitize($_POST);
        $user = $post['name'];
        $text = $post['text'];

        /*$dsn = 'mysql:dbname=utsubo33_testchat;host=mysql1.php.xdomain.ne.jp;charset=utf8';
        $sqlUser = 'utsubo33_gingin';
        $password = 'Utsubo33';*/
        $dsn = 'mysql:dbname=chat;host=localhost;charset=utf8';
        $sqlUser = 'root';
        $password = '';
        $dbh = new PDO($dsn, $sqlUser, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'LOCK TABLES chat_log WRITE';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        
        $sql = 'INSERT INTO chat_log (timeDate,userName,sentence) VALUES (?,?,?)';
        $stmt = $dbh->prepare($sql);
        $data[] = date('Y/m/d H:i:s');
        $data[] = $user;
        $data[] = $text;
        $stmt->execute($data);
        $_SESSION['last_code'] = $dbh->lastInsertId();

        $sql = 'UNLOCK TABLES';
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		
        $dbh = null;

        $search = array("\n", "\r\n", "\r");
        $text = str_replace($search, '\n', $text);

        $sentence = date('Y/m/d H:i:s');
        $sentence .= ',';
        $sentence .= $user;
        $sentence .= ',';
        $sentence .= $text;
        $sentence .= "\n";

        $file = fopen('./log.txt', 'a');
        $sentence = mb_convert_encoding($sentence, 'SJIS', 'UTF-8');
        fputs($file, $sentence);
        fclose($file);

        unset($_SESSION['name']);
        unset($_SESSION['text']);

        header('Location: ./web.php');
        exit();
    } catch (Exception $e) {
        print '障害が発生しております。';
        exit();
    }
    ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Webサイト</title>
</head>

<body>
</body>

</html>
