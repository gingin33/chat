<?php
ini_set("display_errors",1);

error_reporting(E_ALL);

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
    <link rel="icon" type="image/svg+xml" href="images/favicon.png">
    <link rel="stylesheet" href="web.css">
    <script src="https://kit.fontawesome.com/b8a7fea4d4.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
    <h1>チャットログ</h1><br /><br />
    <?php
    /*$dsn = 'mysql:dbname=utsubo33_testchat;host=mysql1.php.xdomain.ne.jp;charset=utf8';
    $sqlUser = 'utsubo33_gingin';
    $password = 'Utsubo33';*/
    $dsn = 'mysql:dbname=chat;host=localhost;charset=utf8';
    $sqlUser = 'root';
    $password = '';
    $dbh = new PDO($dsn, $sqlUser, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_SESSION['last_code']) == true){
        $lastCode = $_SESSION['last_code'];
    }else{
        $lastCode = 0;
    }
    
    $count = 1;
    for($i = 1;$i <= 1000;$i++){
        $sql = 'SELECT id,timeDate,userName,sentence FROM chat_log WHERE id=?';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $i, PDO::PARAM_INT);
        $stmt->execute();
    
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if($rec == false) {continue;}

        $dateTime = $rec['timeDate'];
        $user = $rec['userName'];
        $text = $rec['sentence'];
        $text = nl2br($text);
        
        //print '<div class="area">';
        print $count.' ';
        print $dateTime.' : <br />';
        print 'お名前 : '.$user.'<br />';
        print $text.'<br /><br />';
        //print '</div>';

        $count++;
    }

    $dbh = null;
    
    ?>
    <div id="formText">
        <form method="post" action="send_check.php">
            ユーザー名:<input type="text" name="name" value="<?php 
            if (isset($_SESSION['name']) == true) {
                print $_SESSION['name'];
            } ?>"></input><br />本文:<br />
            <textarea name="text" rows="4" cols="40"><?php 
            if (isset($_SESSION['text']) == true) {
                print $_SESSION['text'];
            } ?></textarea><br />
            <input type="submit" value="送信">
        </form>
    </div>
    
    <br /><br />
    <a href="../index.html">トップへ></a>
    </div>
    
</body>

</html>
