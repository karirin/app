<?php require_once('../head.php'); ?>
<body>
<?php

try
{

$comment_id = $_POST['id'];
$comment_image_name = $_POST['image_name'];
$user_id = $_POST['user_id'];
$post_id = $_POST['post_id'];

$dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
$user = 'root';
$password = '';
$dbh = new PDO($dsn,$user,$password);
$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'DELETE FROM comment WHERE id=?';
$stmt = $dbh -> prepare($sql);
$data[] = $comment_id;
$stmt -> execute($data);

$dbh = null;

if($comment_image_name != '')
{
    unlink('./image/'.$comment_image_name);
}

}   
catch (Exception $e)
{
print'ただいま障害により大変ご迷惑をお掛けしております。';
exit();
}

?>

削除しました。<br />
<br />
<a href="/post/post_disp.php?user_id=<?= $user_id; ?>&post_id=<?= $post_id; ?>">戻る</a>
</body>
<?php require_once('../footer.php'); ?>
</html>