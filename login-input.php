<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<?php
echo '<form action="login-output.php" method="post">';
echo '<table class="table">';
echo '<tr><td>ログイン名</td><td>';
echo '<input type="text" name="login">';
echo '</td></td>';

echo '<tr><td>パスワード</td><td>';
echo '<input type="password" name="password">';
echo '</td></td>';
echo '</table>';
echo '<br>';
echo '<input type="submit" value="ログイン">';
echo '</form>';

echo '<p>', '初めての方は、', '<a href="./regist-input.php">ここ</a>','でご登録ください。','</p>';
echo '</div>';
?>

<?php require 'footer.php'; ?>