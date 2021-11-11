<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<?php
//ログインの場合、データベースに接続する
//以下は前のクイズ回答を処理している
if (isset($_SESSION['monitor'])) {
    $pdo=new PDO('mysql:host=localhost;dbname=survey;charset=utf8',	'root', '');
    $sql=$pdo->prepare('insert into answer(monitor_id, quiz_id, answer) values(?,?,?)');
    $sql->execute([$_SESSION['monitor']['id'], $_REQUEST['id'], $_REQUEST['answer']]);

    // 使用後に閉る。
    $sql = null;
    $pdo = null;
} else {
    echo 'ログインしてください。';
}

//ユーザの回答集を表示する
// echo '<p>', $_SESSION['monitor']['name'], "　様のご回答は以下の通りです。",'</p>';

// //queryに$sqlを渡す
// $result=$pdo->query('select id, quiz from quiz');
// $result1=$pdo->query('select quiz_id, answer from answer');
// //queryの結果は配列で返されてforeachで取り出す
// foreach ($result as $val) {
//     echo '<br>';
//     echo '<p>QUIZ_', $val['id'], '</p>';
//     echo '<p>', $val['quiz'], '</p>';

//     if ($val['id'] == $result1['id']) {
//     foreach ($result1 as $row) {
//         echo '<a>', $row['answer'], '</a>','<br>';
//     }
//     }
// }

//御礼メッセージ
echo '<p style="text-align:center">','全てのクイズは回答完了でございます。','<br>','ご協力ありがとうございました。','</p>';

?>
<?php require 'footer.php'; ?>