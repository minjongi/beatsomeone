<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
<?php $this->managelayout->add_css('/dist/list_item.css'); ?>
<?php $this->managelayout->add_js('/dist/chunk-vendors.js'); ?>
<?php $this->managelayout->add_js('/dist/chunk-common.js'); ?>
<?php $this->managelayout->add_js('/dist/list_item.js'); ?>




<div class="mypage" >
    <ul class="nav nav-tabs">
        <li><a href="<?php echo site_url('mypage'); ?>" title="마이페이지">마이페이지</a></li>
        <?php if($this->member->item('mem_usertype') == 2) { ?>
            <li><a href="<?php echo site_url('mypage/regist_item'); ?>" title="음원등록">음원등록</a></li>
            <li class="active"><a href="<?php echo site_url('mypage/list_item'); ?>" title="음원등록내역">음원등록내역</a></li>
            <li><a href="<?php echo site_url('mypage/status_item'); ?>" title="판매내역">판매내역</a></li>
        <?php } ?>
        <li><a href="<?php echo site_url('mypage/loginlog'); ?>" title="나의 로그인기록">로그인기록</a></li>
        <li><a href="<?php echo site_url('membermodify'); ?>" title="정보수정">정보수정</a></li>
        <li><a href="<?php echo site_url('membermodify/memberleave'); ?>" title="탈퇴하기">탈퇴하기</a></li>
    </ul>

    <h3>음원등록내역</h3>

    <div id="app">
        <ListItem>

        </ListItem>
    </div>

</div>


