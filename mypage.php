<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php

if (isset($_SESSION['monitor'])) {
	$pdo=new PDO('mysql:host=localhost;dbname=survey;charset=utf8',	'root', '');
	$sql = "SELECT * FROM monitor";
	$res = $pdo->prepare($sql);
	$res->execute();

	// 登録内容を表示する
	// style="table-layout:fixed; width:100%; border:1px solid orange; margin:20px;"?
	echo $_SESSION['monitor']['name'],'様の登録情報です。','<br>','<br>';
	echo '<table class="table">';
	echo '<tr><td>お名前</td><td>', $_SESSION['monitor']['name'], '</td></tr>';
	echo '<tr><td>ログインID</td><td>', $_SESSION['monitor']['login'], '</td></tr>';
	echo '<tr><td>パスワード</td><td>', $_SESSION['monitor']['password'], '</td></tr>';

	echo '<tr><td>ご住所</td><td>', $_SESSION['monitor']['address'], '</td></tr>';
	echo '<tr><td>電話番号</td><td>', $_SESSION['monitor']['tel'], '</td></tr>';
	echo '<tr><td>メールアドレス</td><td>', $_SESSION['monitor']['email'], '</td></tr>';

	echo '<tr><td>お誕生日</td><td>', $_SESSION['monitor']['birthday'], '</td></tr>';
	echo '<tr><td>婚姻状況</td><td>', $_SESSION['monitor']['mariage'], '</td></tr>';
	echo '<tr><td>持家状況</td><td>', $_SESSION['monitor']['real_estate'], '</td></tr>';
	echo '<tr><td>家庭成員</td><td>', $_SESSION['monitor']['family_qty'], '</td></tr>';
	echo '<tr><td>子供人数</td><td>', $_SESSION['monitor']['kids_qty'], '</td></tr>';

	echo '<tr><td>職種</td><td>', $_SESSION['monitor']['job'], '</td></tr>';
	echo '<tr><td>個人収入</td><td>', $_SESSION['monitor']['personal_income'], '</td></tr>';
	echo '<tr><td>世代収入</td><td>', $_SESSION['monitor']['family_income'], '</td></tr>';
	// echo '登録時間', $_SESSION['monitor']['created_at'], '<br>';
	echo '</table>';
}

?>


<?php require 'footer.php'; ?>