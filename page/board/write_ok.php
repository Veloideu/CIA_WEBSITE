<?php
include $_SERVER['DOCUMENT_ROOT']."/security/db.php";

$upload_dir = $_SERVER['DOCUMENT_ROOT']."/page/board/upload";

$date = date('Y-m-d');

if(isset($_POST['lockpost'])){
	$lo_post = '1';
}else{
	$lo_post = '0';
}

if(!isset($_FILES['imgFile'])){
	echo "업로드된 이미지가 없습니다.";
	}
	
	//업로드 이미지 체크
if($_FILES['imgFile']['error'] > 0) {
	switch ($_FILES['imgFile']['error']){
	case 1 : echo "php.ini 파일의 upload_max_filesize 설정값을 초과";
	break;
	case 2 : echo "Form에서 설정된 MAX_FILE_SIZE 설정값을 초과";
	break;
	case 3 : echo "파일 일부만 업로드 됨";
	//우제연은 멍청이똥개해삼말미잘입니다!!!!!!!!!!!!!!!!!!!!!!
	break;
	case 4 : //echo "업로드된 파일이 없음";
		session_start();

		$mqq = mq("alter table board auto_increment =1"); //auto_increment 값 초기화
		//$sql= mq("insert into board(name,title,content,date) values('".$_SESSION['userid']."','".$_POST['title']."','".$_POST['content']."',now())");
		$sql= mq("insert into board(name,title,content,date,lock_post,file) values('".$_SESSION['userid']."','".$_POST['title']."','".$_POST['content']."','".$date."','".$lo_post."','".$o_name."')");
		$sql= mq("insert into levelpoint(userid,point) values('".$_SESSION['userid']."','".$_POST['title']."','".$_POST['content']."',now())");
		echo "<script>alert('글쓰기 완료되었습니다.');</script>";

		$hit = mysqli_fetch_array(mq("select * from levelpoint where userid ='".$_SESSION['userid']."'"));
		$hit = $hit['point'] + 1;
		$fet = mq("update levelpoint set point = '".$hit."' where userid = '".$_SESSION['userid']."'");
		?>
		<meta http-equiv="refresh" content="0 url=/#work" />
	<?php	
	break;
	case 5 : echo "사용가능한 임시폴더가 없음";
	break;
	case 6 : echo "디스크에 저장할수 없음";
	break;
	case 7 : echo "파일 업로드가 중지됨";
	break;
	default : echo "시스템 오류";
	break;
	}
	}
	
	if($_FILES['imgFile']['size'] > 25242880) {
	echo "업로드 용량 초과";
	}

$o_name = $_FILES['imgFile']['name'];

/*********************************************
* 넘어오는 데이터가 정상인지 검사하기 위한 절차
* 실제 페이지에서는 적용 X
**********************************************/

//$_FILES에 담긴 배열 정보 구하기.
// var_dump($_FILES);

// php 내부 소스에서 html 태그 적용 - 선긋기
echo "<hr>";

/*********************************************
* 실제로 구축되는 페이지 내부.
**********************************************/

// 임시로 저장된 정보(tmp_name)
$tempFile = $_FILES['imgFile']['tmp_name'];

// 파일타입 및 확장자 체크
$fileTypeExt = explode("/", $_FILES['imgFile']['type']);

// 파일 타입 
$fileType = $fileTypeExt[0];

// 파일 확장자
$fileExt = $fileTypeExt[1];

// 확장자 검사
$extStatus = false;

switch($fileExt){
	case 'jpeg':
	case 'jpg':
	case 'gif':
	case 'bmp':
	case 'png':
		$extStatus = true;
		break;
	
	default:
		echo "이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다."; 
		exit;
		break;
}

// 이미지 파일이 맞는지 검사. 
if($fileType == 'image'){
	// 허용할 확장자를 jpg, bmp, gif, png로 정함, 그 외에는 업로드 불가
	if($extStatus){
		// 임시 파일 옮길 디렉토리 및 파일명
		$resFile = "./upload/{$_FILES['imgFile']['name']}";
		// 임시 저장된 파일을 우리가 저장할 디렉토리 및 파일명으로 옮김
		$imageUpload = move_uploaded_file($tempFile, $resFile);
		
		// 업로드 성공 여부 확인
		if($imageUpload == true){
			// echo "파일이 정상적으로 업로드 되었습니다. <br>";
			// echo "<img src='{$resFile}' width='100' />";
		}else{
			echo "파일 업로드에 실패하였습니다.";
		}
	}	// end if - extStatus
		// 확장자가 jpg, bmp, gif, png가 아닌 경우 else문 실행
	else {
		echo "파일 확장자는 jpg, bmp, gif, png 이어야 합니다.";
		exit;
	}	
}	// end if - filetype
	// 파일 타입이 image가 아닌 경우 
else {
	echo "이미지 파일이 아닙니다.";
	exit;
}


session_start();

$mqq = mq("alter table board auto_increment =1"); //auto_increment 값 초기화
//$sql= mq("insert into board(name,title,content,date) values('".$_SESSION['userid']."','".$_POST['title']."','".$_POST['content']."',now())");
$sql= mq("insert into board(name,title,content,date,lock_post,file) values('".$_SESSION['userid']."','".$_POST['title']."','".$_POST['content']."','".$date."','".$lo_post."','".$o_name."')");
$sql= mq("insert into levelpoint(userid,point) values('".$_SESSION['userid']."','".$_POST['title']."','".$_POST['content']."',now())");
echo "<script>alert('글쓰기 완료되었습니다.');</script>";

$hit = mysqli_fetch_array(mq("select * from levelpoint where userid ='".$_SESSION['userid']."'"));
$hit = $hit['point'] + 1;
$fet = mq("update levelpoint set point = '".$hit."' where userid = '".$_SESSION['userid']."'");



  
?>
<meta http-equiv="refresh" content="0 url=/#work" />
