<?php require '../survey/header.php'; ?>
<?php require 'menu.php'; ?>

<!-- リサーチを開始する -->
<!-- <form action="quiz.php" method="post">
スタート -->
<!-- <input type="text" name="keyword">
<input type="submit" value="開始">
</form>
<hr> -->


<?php
//PDOオブジェクトの生成
$pdo=new PDO('mysql:host=localhost;dbname=survey;charset=utf8',	'root', '');
$sql=$pdo->query('select * from quiz ORDER BY id ASC LIMIT 0,1');
foreach ($sql as $row) {
	$id=$row['id'];
    echo '<form action="answer-insert.php" method="post">', '<br>';
	echo '<p>', 'QUIZ_', $id, '</p>';
	echo '<hr>';
	echo '<p style="font-weight:bold">', $row['quiz'], '</p>';
	echo '<a>', '<input type="hidden" name="id" value="', $id, '">', '</a>';
	echo '<a>', '<input type="radio" name="answer" value="', $row['key1'], '">', $row['key1'], '</a>', '<br>';
	echo '<a>', '<input type="radio" name="answer" value="', $row['key2'], '">', $row['key2'], '</a>', '<br>';
	echo '<a>', '<input type="radio" name="answer" value="', $row['key3'], '">', $row['key3'], '</a>', '<br>';
	echo '<a>', '<input type="radio" name="answer" value="', $row['key4'], '">', $row['key4'], '</a>', '<br>';
    echo '<a>', '<input type="radio" name="answer" value="', $row['key5'], '">', $row['key5'], '</a>', '<br>';
    echo '<p>', '<input type="submit" value="確定">', '</p>';
    echo '</form>';
}

?>
<?php require '../survey/footer.php'; ?>