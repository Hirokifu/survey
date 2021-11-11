<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<?php
// 変数の初期化
$message = array();
$message_array = array();
$success_message = null;
$error_message = array();
$pdo = null;
$stmt = null;
$res = null;
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
	$stmt = $pdo->prepare('SELECT * FROM message where id=:id');
	$stmt->execute(array(':id'=>$_REQUEST['id']));
	$value = 0;
	$value = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
	echo 'エラーが発生しました。:' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>編集</title>

<div>
<form action="msg_update.php" method="post">
	<p>
	<?php echo '<a>', '<input type="hidden" name="id" value="', $_REQUEST['id'], '">', '</a>';?>
	<a style="font-weight:bold"><?php echo "投稿者:".htmlspecialchars($_REQUEST['view_name'], ENT_QUOTES, 'UTF-8'); ?></a>
	<input type="hidden" name="view_name" value="<?php if(!empty($_REQUEST['view_name'])) echo(htmlspecialchars($_REQUEST['view_name'], ENT_QUOTES, 'UTF-8'));?>">
	</p>
	<p>
	<textarea id="message" name="message" rows="8" style="width:100%; font-size:1.3em" ><?php if(!empty($_REQUEST['message'])) echo(htmlspecialchars($_REQUEST['message'], ENT_QUOTES, 'UTF-8'));?></textarea>
	</p>
	<input type="submit" value="編集">
</form>
</div>
</body>
</html>