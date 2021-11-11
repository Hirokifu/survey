<?php session_start(); ?>
<?php require '../survey/header.php'; ?>
<?php require 'menu.php'; ?>
<div style="text-align: center;">
<h3>Answer</h3>

<?php
if (isset($_SESSION['monitor'])) {
    // ログインした場合、データベースに接続する
    $pdo=new PDO('mysql:host=localhost;dbname=survey;charset=utf8',	'root', '');
    $sql=$pdo->prepare('select * from survey'.'where monitor_id=? and quiz_id=?');
    $sql->execute([$_SESSION['monitor']['id']]);

$pdo=new PDO('mysql:host=localhost;dbname=survey;charset=utf8',	'root', '');
$sql=$pdo->prepare('select * from quiz');
$sql->execute([]);

switch ($_REQUEST['answer']) {
case 'key1':
    echo $row['key1'];
    break;
case 'key2':
    echo $row['key2'];
    break;
case 'key3':
    echo $row['key3'];
    break;
case 'key4':
    echo $row['key4'];
    break;
case 'key5':
    echo $row['key5'];
    break;
}
}
?>

<br>
<a href="./quiz.php">次のクイズへ</a>
</div>

<?php require '../survey/footer.php'; ?>