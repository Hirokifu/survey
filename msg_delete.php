<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<?php
// 変数の初期化
$pdo = null;
$stmt = null;
$option = null;

// データベースに接続
define( 'DB_HOST', 'localhost');
define( 'DB_USER', 'root');
define( 'DB_PASS', '');
define( 'DB_NAME', 'survey');
try {
	$option = array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
	);
	$pdo = new PDO('mysql:charset=UTF8;dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASS, $option);
	$stmt = $pdo->prepare('DELETE FROM message WHERE id=?');
    $stmt->execute([$_REQUEST['id']]);
    echo '情報を削除しました。';
} catch(PDOException $e) {
	echo 'エラーが発生しました。:' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>削除完了</title>
	<!-- <meta http-equiv="refresh" content="2; url=./msg_input.php"> -->
</head>
<body>
<p>
    <a href="msg_input.php">掲示板へ</a>
</p>
</body>
</html>