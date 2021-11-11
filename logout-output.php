<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php
if (isset($_SESSION['monitor'])) {
	unset($_SESSION['monitor']);//ユーザ情報を削除する
	echo 'ログアウトしました。';
} else {
	echo 'すでにログアウトしています。';
}
?>
<?php require 'footer.php'; ?>