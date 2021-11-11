<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<?php
if (isset($_SESSION['monitor'])) {
//PDOオブジェクトの生成
$pdo=new PDO('mysql:host=localhost;dbname=survey;charset=utf8',	'root', '');
// レコード数をカウントする
$sql = "SELECT COUNT(*) FROM quiz";
$res = $pdo->query($sql);
$count = $res->fetchColumn();

$quizList = [
    "select * from quiz ORDER BY id ASC LIMIT 0,1",
    "select * from quiz ORDER BY id ASC LIMIT 1,1",
    "select * from quiz ORDER BY id ASC LIMIT 2,1",
    "select * from quiz ORDER BY id ASC LIMIT 3,1"
];

$i = 0;
$a = $quizList[$i];
$res=$pdo->query($a);

/*
$token=uniqid('', true);
$_SESSION['token']=$token;
echo $_SESSION['token'];
*/

foreach ($res as $row) {
    $id=$row['id'];
    if ($id < $count) {
        echo '<form action="quiz',$id+1,'.php" method="post">';
        echo '<p>', 'QUIZ_', $id, '</p>';
        echo '<hr>';
        echo '<p style="font-weight:bold">', $row['quiz'], '</p>';
        echo '<a>', '<input type="hidden" name="id" value="', $id, '">', '</a>';
        // echo '<a>', '<input type="hidden" name="token" value="', $token, '">', '</a>';
        echo '<a>', '<input type="hidden" name="count" value="', $count, '">', '</a>';
        echo '<a>', '<input type="radio" name="answer" value="', $row['key1'], '">', $row['key1'], '</a>', '<br>';
        echo '<a>', '<input type="radio" name="answer" value="', $row['key2'], '">', $row['key2'], '</a>', '<br>';
        echo '<a>', '<input type="radio" name="answer" value="', $row['key3'], '">', $row['key3'], '</a>', '<br>';
        echo '<a>', '<input type="radio" name="answer" value="', $row['key4'], '">', $row['key4'], '</a>', '<br>';
        echo '<a>', '<input type="radio" name="answer" value="', $row['key5'], '">', $row['key5'], '</a>', '<br>';
        echo '<p>', '<input type="submit" value="確定">', '</p>';
        echo '</form>';
    } else {
        header("Location: thanks.php"); //thanks.phpにリダイレクトさせる
        exit;
    }
}

} else {
    echo 'ログインしてください。';
}
?>
<?php require 'footer.php'; ?>