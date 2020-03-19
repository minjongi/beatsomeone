<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<div class="mypage">
	<ul class="nav nav-tabs">
        <li><a href="<?php echo site_url('mypage'); ?>" title="마이페이지">마이페이지</a></li>
        <?php if($this->member->item('mem_usertype') == 2) { ?>
        <li><a href="<?php echo site_url('mypage/regist_item'); ?>" title="음원판매등록">음원판매등록</a></li>
        <li><a href="<?php echo site_url('mypage/list_item'); ?>" title="나의음원목록">나의음원목록</a></li>
        <li><a href="<?php echo site_url('mypage/status_item'); ?>" title="판매현황">판매현황</a></li>
        <?php } ?>
        <li><a href="<?php echo site_url('mypage/loginlog'); ?>" title="나의 로그인기록">로그인기록</a></li>
        <li <?php if (uri_string() === 'membermodify') { ?>class="active" <?php } ?> ><a href="<?php echo site_url('membermodify'); ?>" title="정보수정">정보수정</a></li>
        <li <?php if (uri_string() === 'membermodify/memberleave') { ?>class="active" <?php } ?>><a href="<?php echo site_url('membermodify/memberleave'); ?>" title="탈퇴하기">탈퇴하기</a></li>
	</ul>

	<h3>회원 탈퇴</h3>
	<div class="mt20">
		<p style="padding:20px;">안녕하세요 <span class="text-primary"><?php echo html_escape($this->member->item('mem_nickname')); ?></span>님, <br />
			회원님의 탈퇴가 정상적으로 진행되었습니다.<br />
			그 동안 저희 사이트를 이용해주셔서 감사합니다. </p>
	</div>
</div>
