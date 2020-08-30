<?php
if ($this->cbconfig->item('use_sociallogin')) {
    $this->managelayout->add_js(base_url('assets/js/social_login.js'));
}

$this->managelayout->add_css('/dist/mypage_new.css?v=' . time());
$this->managelayout->add_js('/dist/mypage_new.js?v='. time());