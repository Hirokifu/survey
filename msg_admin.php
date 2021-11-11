
<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<h2>掲示板管理ページ</h2>

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

if (isset($_SESSION['monitor'])) {

// データベースの接続情報
define( 'DB_HOST', 'localhost');
define( 'DB_USER', 'root');
define( 'DB_PASS', '');
define( 'DB_NAME', 'survey');

// データベースに接続
try {
	$option = array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
	);
	$pdo = new PDO('mysql:charset=UTF8;dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASS, $option);
} catch(PDOException $e) {
	// 接続エラーのときエラー内容を取得する
	$error_message[] = $e->getMessage();
}

if(empty($error_message)) {
	// メッセージのデータを取得する
	$sql = "SELECT view_name,message,created_at FROM message ORDER BY created_at DESC";
	$message_array = $pdo->query($sql);
}
} else {
	echo '<p>', '管理ページを入るために、', '<a href="./login-input.php">ログイン</a>','してください。','</p>';
}
?>

<!-- 掲示内容 -->
<section class="session">
<?php if(!empty($message_array)){ ?>
<?php foreach($message_array as $value){ ?>
<article>
    <div id="rcorner">
		<div style="display:flex; justify-content:space-between; border-bottom:1.5px dotted #c0c0c0">
        <a style="font-size:1.2em"><?php echo htmlspecialchars( $value['view_name'], ENT_QUOTES, 'UTF-8'); ?></a>
        <a style="text-align:end"><?php echo date('Y年m月d日 H:i', strtotime($value['created_at'])); ?></a>
		</div>
		<p><?php echo nl2br( htmlspecialchars( $value['message'], ENT_QUOTES, 'UTF-8') ); ?></p>
    </div>
</article>
<?php } ?>
<?php } ?>
</section>

<?php require 'footer.php'; ?>