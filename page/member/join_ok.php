<?php
	ini_set('display_errors', true);
include $_SERVER['DOCUMENT_ROOT']."/security/db.php";
include $_SERVER['DOCUMENT_ROOT']."/security/password.php";

$userid = $_POST['userid'];
$userpw = $_POST['userpw'];
$userpw2 = $_POST['userpw2'];

if($userpw2 != $userpw){
	echo "<script>alert('패스워드가 다릅니다.'); history.back();</script>";
}
else{
	$userpw = password_hash($_POST['userpw'], PASSWORD_DEFAULT);
	$username = $_POST['name'];

	$id_check = mq("select * from member where id='$userid'");
		$id_check = $id_check->fetch_array();
		if($id_check >= 1){
			echo "<script>alert('아이디가 중복됩니다.'); history.back();</script>";
		}else{
			$sql = mq("insert into member (id,pw,name) values('".$userid."','".$userpw."','".$username."')");
			$sql2 = mq("insert into levelpoint (userid,point) values('".$userid."','0')");
			?>
			<script type="text/javascript">alert('회원가입이 완료되었습니다.');</script>
			<meta http-equiv="refresh" content="0 url=/">
  <?php }} ?>

