<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php
echo '<form action="regist-output.php" method="post">';
$name=$address=$login=$password='';
if (isset($_SESSION['monitor'])) {
	$name=$_SESSION['monitor']['name'];
	$address=$_SESSION['monitor']['address'];
	$login=$_SESSION['monitor']['login'];
	$password=$_SESSION['monitor']['password'];
}

echo '<table class="table">';
echo '<tr><td>お名前</td><td>';
echo '<input type="text" name="name" size="30" value="', $name, '">';
echo '</td></tr>';
echo '<tr><td>ご住所</td><td>';
echo '<input type="text" name="address" value="', $address, '">';
echo '</td></tr>';
echo '<tr><td>ログイン名</td><td>';
echo '<input type="text" name="login" value="', $login, '">';
echo '</td></tr>';
echo '<tr><td>パスワード</td><td>';
echo '<input type="password" name="password" value="', $password, '">';
echo '</td></tr>';
echo '</table>';
echo '<br>';
echo '<input type="submit" value="確定">';
echo '</form>';
?>
<?php require 'footer.php'; ?>