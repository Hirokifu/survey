<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<?php
unset($_SESSION['monitor']);
$pdo=new PDO('mysql:host=localhost;dbname=survey;charset=utf8', 'root', '');
$sql=$pdo->prepare('select * from monitor where login=? and password=?');
$sql->execute([$_REQUEST['login'], $_REQUEST['password']]);
foreach ($sql as $row) {
    $_SESSION['monitor']=[
        'id'=>$row['id'],
        'name'=>$row['name'],
        'email'=>$row['email'],
        'login'=>$row['login'],
        'password'=>$row['password'],
        'sex'=>$row['sex'],
        'job'=>$row['job'],
        'birthday'=>$row['birthday'],
        'mariage'=>$row['mariage'],
        'real_estate'=>$row['real_estate'],
        'family_qty'=>$row['family_qty'],
        'kids_qty'=>$row['kids_qty'],
        'personal_income'=>$row['personal_income'],
        'family_income'=>$row['family_income'],
        'address'=>$row['address'],
        'tel'=>$row['tel'],
        'created_at'=>$row['created_at']
    ];
}

if (isset($_SESSION['monitor'])) {
    echo 'いらっしゃいませ、', $_SESSION['monitor']['name'], '　様。';
    // echo '<hr>';
    // echo '職種：', $_SESSION['monitor']['job'], '<br>';
    // echo '住所：', $_SESSION['monitor']['address'], '<br>';
    // echo '電話：', $_SESSION['monitor']['tel'], '<br>';
    // echo 'メール：', $_SESSION['monitor']['email'], '<br>';
    // echo '世代収入：', $_SESSION['monitor']['family_income'], '<br>';
    // echo '登録時間：', $_SESSION['monitor']['created_at'], '<br>';
} else {
    echo 'ログイン名またはパスワードが違います。';
}

echo '<p>','<a href="mypage.php">会員ページ</a>','</p>';
echo '</div>';

?>
<?php require 'footer.php'; ?>