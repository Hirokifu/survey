<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

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

// データベースに接続
define( 'DB_HOST', 'localhost');
define( 'DB_USER', 'root');
define( 'DB_PASS', '');
define( 'DB_NAME', 'survey');
try {
	$option = array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
	);
	$pdo = new PDO('mysql:charset=UTF8;dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASS, $option);
} catch(PDOException $e) {
	$error_message[] = $e->getMessage();
}

//入力フォーム(opened)
echo '<form method="post">';
echo '<div>';
echo '<h2>ひと言掲示板</h2>';

if (isset($_SESSION['monitor'])) {
	echo "投稿者:", $_SESSION['monitor']['name'];
} else {
	echo '<a style="color:gray">', '（会員様向けの投稿システムなので、ログインしてから投稿お願いします。）','</a>';
}

echo '</div>';
echo '<div>';
echo '<textarea id="message" name="message" rows="6" style="width:100%"></textarea>';
echo '</div>';
echo '<p>';
echo '<input type="submit" name="btn_submit" value="確定">';
echo '</p>';
echo '</form><br>';

if(!empty($_REQUEST['btn_submit'])) {

	// メッセージの入力チェック
	if(empty($_REQUEST['message'])) {
		$error_message[] = 'メッセージを入力してください。';
	} else {
		// 正規化処理（空白除去）
		if (isset($_SESSION['monitor'])) {
		$view_name = preg_replace( '/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $_SESSION['monitor']['name']);
		$message = preg_replace( '/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $_POST['message']);

		if (empty($error_message)) {
			// トランザクション開始
			$pdo->beginTransaction();
		try {
			// SQL作成
			$stmt = $pdo->prepare("INSERT INTO message (id,view_name, message) VALUES (:id, :view_name, :message)");
			// 値をセット
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->bindParam(':view_name', $view_name, PDO::PARAM_STR);
			$stmt->bindParam(':message', $message, PDO::PARAM_STR);
			$res = $stmt->execute();
			// コミット
			$res = $pdo->commit();
		} catch(Exception $e) {
			// エラーが発生した時はロールバック
			$pdo->rollBack();
		}
		if($res) {
			$success_message = 'ご投稿ありがとうございました。';
		} else {
			$error_message[] = '書き込みに失敗しました。';
		}
		}
		// プリペアドステートメントを削除
		$stmt = null;
		} else {
			echo '<h3 style="color:red">','ログインしてください。','</h3>';
		}
	}
}

//全てのメッセージを表示させる
if(empty($error_message)) {
	// メッセージのデータを取得する
	$sql = "SELECT id,view_name,message,created_at FROM message ORDER BY created_at DESC";
	$message_array = $pdo->query($sql);
}
//データベースの接続を閉じる
$pdo = null;
?>

<!-- アラーム表示 -->
<?php if( !empty($success_message) ): ?>
    <p class="success_message"><?php echo '<h3 style="color:blue">', $success_message,'</h3>'; ?></p>
<?php endif; ?>
<?php if( !empty($error_message) ): ?>
    <div class="error_message">
		<?php foreach( $error_message as $value ): ?>
        <?php echo '<h3 style="color:red">', $value,'</h3>'; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<!-- 投稿内容 -->
<section class="session">
<?php if(!empty($message_array)){ ?>
<?php foreach($message_array as $value){ ?>
<article>
    <div id="rcorner">
	<?php if(isset($_SESSION['monitor']) && $_SESSION['monitor']['name']==$value['view_name']){ ?>
		<div style="display:flex; justify-content:space-between; border-bottom:1.5px dotted #c0c0c0">
        <a style="font-weight:bold"><?php echo "投稿者:".htmlspecialchars( $value['view_name'], ENT_QUOTES, 'UTF-8'); ?></a>
        <a style="font-size:0.8em; text-align:end"><?php echo date('Y/m/d H:i', strtotime($value['created_at'])); ?></a>
		</div>
		<p><?php echo nl2br( htmlspecialchars( $value['message'], ENT_QUOTES, 'UTF-8') ); ?></p>

		<!-- 登録中のユーザの投稿には編集＆削除タグを付ける -->
		<div style="display:flex; justify-content:flex-end; gap:10px">
		<form action="msg_edit.php" method="POST">
			<?php echo '<a>', '<input type="hidden" name="id" value="', $value['id'], '">', '</a>';?>
			<?php echo '<a>', '<input type="hidden" name="view_name" value="', $value['view_name'], '">', '</a>';?>
			<?php echo '<a>', '<input type="hidden" name="message" value="', $value['message'], '">', '</a>';?>
			<?php echo '<input type="submit" name="update" value="編集">';?>
		</form>
		<form action="msg_delete.php" method="POST">
			<?php echo '<a>', '<input type="hidden" name="id" value="', $value['id'], '">', '</a>';?>
			<?php echo '<input type="submit" name="delete" value="削除">';?>
		</form>
		</div>

	<?php } else {?>
		<!-- 他人の投稿が表示されても編集&削除ができないこと -->
		<div style="display:flex; justify-content:space-between; border-bottom:1.5px dotted #c0c0c0">
        <a style="font-weight:bold"><?php echo "投稿者:".htmlspecialchars($value['view_name'], ENT_QUOTES, 'UTF-8');?></a>
        <a style="font-size:0.8em; text-align:end"><?php echo date('Y/m/d H:i', strtotime($value['created_at'])); ?></a>
		</div>
		<p><?php echo nl2br( htmlspecialchars( $value['message'], ENT_QUOTES, 'UTF-8') ); ?></p>
	<?php } ?>
    </div>
</article>
<?php } ?>
<?php } ?>
</section>

<?php require 'footer.php'; ?>