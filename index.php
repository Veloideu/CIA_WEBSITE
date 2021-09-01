<?php
  include $_SERVER['DOCUMENT_ROOT']."/security/db.php";
  include $_SERVER['DOCUMENT_ROOT']."/main/header.php";
  session_start();
?>
<!DOCTYPE HTML>
<!--
	Astral by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>CIA WebSite</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" type="text/css" href="assets/board_css/style.css" />
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">

		<!-- Wrapper-->
			<div id="wrapper">

				<!-- Nav -->
					<nav id="nav">
						<a href="#" class="icon solid fa-home" style='font-size:46px'><span>Home</span></a>
						<a href="#work" class="fas fa-pen" style='font-size:46px'><span>Work</span></a>
						<a href="#contact" class="icon solid fa-envelope" style='font-size:46px'><span>Contact</span></a>
						<a href="#login" class='fas fa-user-circle' style='font-size:46px'></i><span>Login</span></a>
					</nav>

				<!-- Main -->
					<div id="main">
						
						<!-- Me -->
							<article id="home" class="panel intro">
								<img src="/assets/img/logo.jpeg" alt="" />
								<header>
									<!-- <h1>CIA WebSite</h1> -->
									<p>Web Vulnerability Diagnostic Testing</p>
									<p style="font-size:20px;">(xss, sql, webhacking, owasp top10)</p>
								</header>
								<a href="#work" class="jumplink pic">
									<span class="arrow icon solid fa-chevron-right"><span>See my work</span></span>
									<!-- <img src="images/1.jpeg" alt="" /> -->
								</a>
							</article>

						<!-- Work -->
							<article id="work" class="panel">
								<section>
									<div id="board_area"> 
										<h1>자유게시판</h1>
										<h4>자유롭게 글을 쓸 수 있는 게시판입니다.</h4>
										  <table class="list-table">
											<thead>
												<tr>
													<th width="70" >번호</th>
													  <th width="100">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;제목</th>
													  <th width="120">글쓴이</th>
													  <th width="100">작성일</th>
													  <th width="100">조회수</th>
												  </tr>
											  </thead>
											  <?php
												  if(isset($_GET['page'])){
													$page = $_GET['page'];
													  }else{
														$page = 1;
													  }
														$sql = mq("select * from board");
														$row_num = mysqli_num_rows($sql); //게시판 총 레코드 수
														$list = 5; //한 페이지에 보여줄 개수
														$block_ct = 5; //블록당 보여줄 페이지 개수
									  
														$block_num = ceil($page/$block_ct); // 현재 페이지 블록 구하기
														$block_start = (($block_num - 1) * $block_ct) + 1; // 블록의 시작번호
														$block_end = $block_start + $block_ct - 1; //블록 마지막 번호
									  
														$total_page = ceil($row_num / $list); // 페이징한 페이지 수 구하기
														if($block_end > $total_page) $block_end = $total_page; //만약 블록의 마지박 번호가 페이지수보다 많다면 마지박번호는 페이지 수
														$total_block = ceil($total_page/$block_ct); //블럭 총 개수
														$start_num = ($page-1) * $list; //시작번호 (page-1)에서 $list를 곱한다.
									  
														$sql2 = mq("select * from board order by idx desc limit $start_num, $list");  
														while($board = $sql2->fetch_array()){
														$title=$board["title"]; 
														  if(strlen($title)>30)
														  { 
															$title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
														  }
														  $sql3 = mq("select * from reply where con_num='".$board['idx']."'");
														  $rep_count = mysqli_num_rows($sql3);
														?>
											<tbody>
											  <tr>
												<td width="70"><?php echo $board['idx']; ?></td>
												<td width="500">
												  <?php 
													$lockimg = "<img src='assets/img/board/lock.png' alt='lock' title='lock' with='20' height='20' />";
													if($board['lock_post']=="1")
													{ ?><a href='/page/board/ck_read.php?idx=<?php echo $board["idx"];?>'><?php echo $title, $lockimg;
													}else{?>
									  
											  <!-- 추가부분 18.08.01 -->
											  <?php
												$boardtime = $board['date']; //$boardtime변수에 board['date']값을 넣음
												$timenow = date("Y-m-d"); //$timenow변수에 현재 시간 Y-M-D를 넣음
												
												if($boardtime==$timenow){
												  $img = "<img src='assets/img/board/new.png' alt='new' title='new' />";
												}else{
												  $img ="";
												}
												?>
											  <!-- 추가부분 18.08.01 END -->
											  <a href='/page/board/read.php?idx=<?php echo $board["idx"]; ?>'><?php echo $title; }?><span class="re_ct">[<?php echo $rep_count;?>]<?php echo $img; ?> </span></a></td>
												<td width="120"><?php echo $board['name']?></td>
												<td width="100"><?php echo $board['date']?></td>
												<td width="100"><?php echo $board['hit']; ?></td>
											  </tr>
											</tbody>
											<?php } ?>
										  </table>
										  <div id="write_btn">
											<a href="/page/board/write.php"><button style="float:right;height:10%; width:100%;">글쓰기</button></a>
									  </div>
										  <div id="page_num">
											  <?php
												if($page <= 1)
												{ //만약 page가 1보다 크거나 같다면
												  echo "<span class='fo_re'>처음</span>"; //처음이라는 글자에 빨간색 표시 
												}else{
												  echo "<a href='?page=1#work'>처음</a>"; //알니라면 처음글자에 1번페이지로 갈 수있게 링크
												}
												if($page <= 1)
												{ //만약 page가 1보다 크거나 같다면 빈값
												  
												}else{
												$pre = $page-1; //pre변수에 page-1을 해준다 만약 현재 페이지가 3인데 이전버튼을 누르면 2번페이지로 갈 수 있게 함
												  echo "<a href='?page=$pre#work'>이전</a>"; //이전글자에 pre변수를 링크한다. 이러면 이전버튼을 누를때마다 현재 페이지에서 -1하게 된다.
												}
												for($i=$block_start; $i<=$block_end; $i++){ 
												  //for문 반복문을 사용하여, 초기값을 블록의 시작번호를 조건으로 블록시작번호가 마지박블록보다 작거나 같을 때까지 $i를 반복시킨다
												  if($page == $i){ //만약 page가 $i와 같다면 
													echo "<span class='fo_re'>[$i]</span>"; //현재 페이지에 해당하는 번호에 굵은 빨간색을 적용한다
												  }else{
													echo "<a href='?page=$i#work'>[$i]</a>"; //아니라면 $i
												  }
												}
												if($block_num >= $total_block){ //만약 현재 블록이 블록 총개수보다 크거나 같다면 빈 값
												}else{
												  $next = $page + 1; //next변수에 page + 1을 해준다.
												  echo "<a href='?page=$next#work'>다음</a>"; //다음글자에 next변수를 링크한다. 현재 4페이지에 있다면 +1하여 5페이지로 이동하게 된다.
												}
												if($page >= $total_page){ //만약 page가 페이지수보다 크거나 같다면
												  echo "<span class='fo_re'>마지막</span>"; //마지막 글자에 긁은 빨간색을 적용한다.
												}else{
												  echo "<a href='?page=$total_page#work'>마지막</a>"; //아니라면 마지막글자에 total_page를 링크한다.
												}
											  ?>
										  </div>
									  
										<!-- 18.10.11 검색 추가 -->
										<div id="search_box">
										  <form action="/page/board/search_result.php" method="get">
											<select name="catgo">
											  <option value="title">제목</option>
											  <option value="name">글쓴이</option>
											  <option value="content">내용</option>
											</select>
											<input type="text2" name="search" size="40" required="required" /> <button>검색</button>
										  </form>
										  </div>
										</div>
								</section>
							</article>

						<!-- Contact -->
							<article id="contact" class="panel">
								<header>
									<h2>Contact Me</h2>
								</header>
								<form action="#" method="post">
									<div>
										<div class="row">
											<div class="col-6 col-12-medium">
												<input type="text" name="name" placeholder="Name" />
											</div>
											<div class="col-6 col-12-medium">
												<input type="text" name="email" placeholder="Email" />
											</div>
											<div class="col-12">
												<input type="text" name="subject" placeholder="Subject" />
											</div>
											<div class="col-12">
												<textarea name="message" placeholder="Message" rows="6"></textarea>
											</div>
											<div class="col-12">
												<input type="submit" value="Send Message" />
											</div>
										</div>
									</div>
								</form>
							</article>

						<!-- Login -->
						<article id="login" class="panel">
								<header>
								<h2>회원레벨게시판</h2>
								회원레벨에 따라 이용하는 게시판입니다
								</header>
										<?php
											if(isset($_SESSION['userid'])){ //세션 userid가 있으면 페이지를 보여줍니다
												// lo_point변수에 sql쿼리결과를 저장
												$sql = mq("select * from levelpoint where userid='".$_SESSION['userid']."'");
												$lo_point = $sql->fetch_array();
										?>
										<?php echo $_SESSION['nickname']; ?>님 어서오세요. &nbsp;&nbsp;&nbsp;<a href="/page/member/logout.php">로그아웃</a><br />
											<?php
												switch ($lo_point['point']) {
												case '0':
												echo "현재등급 : 새싹등급 0포인트";
												break;

												case '1':
												echo "현재등급 : 일반등급 1포인트";
												break;

												case '2':
												echo "현재등급 : 열심등급 2포인트";
												break;
												
												case '3';
												echo "현재등급 : 별신등급 3포인트";
												break;

												case '4';
												echo "현재등급 : 달신등급 4포인트";
												break;

												default:
												echo "현재등급 : 슈퍼등급 ",$lo_point['point'],"포인트";
												break;
											} //switch문 끝 
										?>
										<?php }else{ ?><!--세션 userid체크해서 세션값 없으면 로그인 폼 표시 -->
											<form action="/page/member/login_ok.php" method="post">
												<ul>
													<li><input type="text" name="userid" placeholder="아이디" required /></li>
													<li><input type="password" name="userpw" placeholder="비밀번호" required /></li>
													<li><input type="submit" value="로그인"></li>
													<li> <a href='/page/member/join_form.php'>회원가입</a></li>
												</ul>
											</form>
										<?php } ?>
							</article>

					</div>

				<!-- Footer -->
					<div id="footer">
						<ul class="copyright">
							<li>&copy; Untitled.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
						</ul>
					</div>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<!-- <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script> -->
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>