<?php
include $_SERVER['DOCUMENT_ROOT']."/security/db.php";
include $_SERVER['DOCUMENT_ROOT']."/security/password.php";
session_start();


$rno = $_POST['rno']; 
$sql = mq("select * from reply where idx='".$rno."'");
$reply = $sql->fetch_array();

$bno = $_POST['b_no'];
$sql2 = mq("select * from board where idx='".$bno."'");
$board = $sql2->fetch_array();

$pwk = $_POST['pw'];
$sql3 = mq("select * from member where pw='".$pwk."'");
$member = $sql3->fetch_array();

//$bpw = $board['pw'];
$se_p = $_SESSION['userpw'];

if(password_verify($pwk, $se_p)) 
	{
		$sql = mq("delete from reply where idx='".$rno."'");
		echo "<script>alert('댓글이 삭제되었습니다.');</script>"
	?>
	<script type="text/javascript">location.replace("read.php?idx=<?php echo $board["idx"]; ?>");</script>
	<?php 
	}else{
		echo "<script>alert('비밀번호가 틀립니다');history.back();</script>";
	}
 ?>

 