<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php
$pdo=new PDO('mysql:host=localhost;dbname=survey;charset=utf8',
	'root', '');
if (isset($_SESSION['monitor'])) {
	$id=$_SESSION['monitor']['id'];
	$sql=$pdo->prepare('select * from monitor where id!=? and login=?');
	$sql->execute([$id, $_REQUEST['login']]);
} else {
	$sql=$pdo->prepare('select * from monitor where login=?');
	$sql->execute([$_REQUEST['login']]);
}
if (empty($sql->fetchAll())) {
	if (isset($_SESSION['monitor'])) {
		$sql=$pdo->prepare('update monitor set name=?, address=?, '.
			'login=?, password=? where id=?');
		$sql->execute([
			$_REQUEST['name'], $_REQUEST['address'],
			$_REQUEST['login'], $_REQUEST['password'], $id]);
		$_SESSION['monitor']=[
			'id'=>$id, 'name'=>$_REQUEST['name'],
			'address'=>$_REQUEST['address'], 'login'=>$_REQUEST['login'],
			'password'=>$_REQUEST['password']];
		echo 'お客様情報を更新しました。';
	} else {
		$sql=$pdo->prepare('insert into monitor values(null,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,null)');
		$sql->execute([
			$_REQUEST['name'],'',$_REQUEST['login'], $_REQUEST['password'],
			'','','','','','','','','',$_REQUEST['address'],'']);
		echo 'お客様情報を登録しました。';
	}
} else {
	echo 'ログイン名がすでに使用されていますので、変更してください。';
}
?>
<?php require 'footer.php'; ?>