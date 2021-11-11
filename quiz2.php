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

$i = 1;
$a = $quizList[$i];
$res=$pdo->query($a);

foreach ($res as $row) {
    $id=$row['id'];
    if ($id < $count) {
        echo '<form action="quiz',$id+1,'.php" method="post">';
        echo '<p>', 'QUIZ_', $id, '</p>';
        echo '<hr>';
        echo '<p style="font-weight:bold">', $row['quiz'], '</p>';
        echo '<a>', '<input type="hidden" name="id" value="', $id, '">', '</a>';
        echo '<a>', '<input type="hidden" name="count" value="', $count, '">', '</a>';
        echo '<a>', '<input type="radio" name="answer" value="', $row['key1'], '">', $row['key1'], '</a>', '<br>';
        echo '<a>', '<input type="radio" name="answer" value="', $row['key2'], '">', $row['key2'], '</a>', '<br>';
        echo '<a>', '<input type="radio" name="answer" value="', $row['key3'], '">', $row['key3'], '</a>', '<br>';
        echo '<a>', '<input type="radio" name="answer" value="', $row['key4'], '">', $row['key4'], '</a>', '<br>';
        echo '<a>', '<input type="radio" name="answer" value="', $row['key5'], '">', $row['key5'], '</a>', '<br>';
        echo '<p>', '<input type="submit" value="確定">', '</p>';
        echo '</form>';
    } else {
        echo '<p action="thanks.php">', '</p>';
    }
}

//クイズ回答をDBに保存する
$stmt=$pdo->prepare('insert into answer(monitor_id, quiz_id, answer) values(?,?,?)');
$stmt->execute([$_SESSION['monitor']['id'], $_REQUEST['id'], $_REQUEST['answer']]);

//二重回答の判定処理
$stmt1 = "SELECT COUNT(quiz_id) FROM answer";
$check = $pdo->query($stmt1);
$countCheck = $check->fetchColumn();//二重回答無しでの総回答数
// $joyo = $countCheck % $count;

$stmt2 = "SELECT COUNT(DISTINCT monitor_id) FROM answer";
$check1 = $pdo->query($stmt2);
$countCheck1 = $check1->fetchColumn();//投稿者の人数
// $joyo1 = $countCheck % $countCheck1;

//同一のクイズには同ユーザの二重回答を防ぐ
if ($countCheck > $count*$countCheck1) {
    $stmt3 = $pdo->prepare('DELETE FROM answer WHERE monitor_id=:id AND quiz_id=:id1 LIMIT 1');
    $stmt3->execute(array(':id'=>$_SESSION['monitor']['id'], ':id1'=>$_REQUEST['id']));
    echo '<h3 style="color:red; text-align:center">二重回答を入力しないでください。</h3>';

    // 使用後に閉る。
    $sql = null;
    $pdo = null;

    //2秒後経てログイン画面に自動移動する
    // header("refresh:2; url=login-input.php");
    header("location:login-input.php");
}


} else {
    echo 'ログインしてください。';
}
?>
<?php require 'footer.php'; ?>