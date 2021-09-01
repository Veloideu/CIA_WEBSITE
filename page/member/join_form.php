<?php 
include $_SERVER['DOCUMENT_ROOT']."/main/header.php";

if(isset($_SESSION['userid'])){
	echo "<script>alert('잘못된 접근입니다.'); history.back();</script>"; 
}else{
?>

<link rel="stylesheet" type="text/css" href="/assets/css/login.css" />

<div class="wrap wd668">
  <div class="container">
    <div class="form_txtInput">
      <h2 class="sub_tit_txt">회원가입</h2>
      <div class="join_form">
        <table>
          <colgroup>
            <col width="30%" />
            <col width="auto" />
          </colgroup>
		  <form name="myForm" action="join_ok.php" method="post">
					<tbody>
						<tr>
						<th><span>아이디</span></th>
						<td><input type="text" id= "userid" name="userid" placeholder="ID 를 입력하세요."></td>
						</tr>
						<tr>
						<th><span>이름</span></th>
						<td><input type="text" id="name" name="name" placeholder="본인의 이름(홍길동) 입력하세요."></td>
						</tr>
						<tr>
						<th><span>비밀번호</span></th>
						<td><input type="password" id="userpw" name="userpw" placeholder="비밀번호를 입력해주세요."></td>
						</tr>
						<tr>
						<th><span>비밀번호 확인</span></th>
						<td><input type="password" id="userpw2" name="userpw2" placeholder="비밀번호를 한번 더 입력해주세요."></td>
						</tr>
					</tbody>
					</table>
					<div class="exform_txt"><span>표시는 필수적으로 입력해주셔야 가입이 가능합니다.</span></div>
				</div><!-- join_form E  -->
				<div class="agree_wrap">
					<div class="checkbox_wrap">
					<input type="checkbox" id="news_letter" name="news_letter" class="agree_chk">
					<label for="news_letter">[선택]뉴스레터 수신동의</label>
					</div>
					<div class="checkbox_wrap mar27">
					<input type="checkbox" id="marketing" name="marketing" class="agree_chk">
					<label for="marketing">[선택]마케팅 목적 개인정보 수집 및 이용에 대한 동의</label>
					<ul class="explan_txt">
						<li><span class="red_txt">항목 : 이름</span></li>
						<li>고객님께서는 위의 개인정보 및 회원정보 수정 등을 통해 추가로 수집하는 개인정보에<br />
						대해 동의하지 않거나 개인정보를 기재하지 않음으로써 거부하실 수 있습니다.<br />
						다만 이때 회원 대상 서비스가 제한될 수 있습니다.
						<div class="btn_wrap">
						
				<a href="javascript:document.myForm.submit();">회원가입</a>
				</div>						
						</li>
					</ul>
					</div>
				</div>

			<!-- <a href="#" onclick="javascript:document.myform.submit();" class="form_bt" >click</a> -->

				</form>
    </div> <!-- form_txtInput E -->
  </div><!-- content E-->
</div> <!-- container E -->

<?php }