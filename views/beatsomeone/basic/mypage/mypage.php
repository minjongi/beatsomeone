<?php $this->managelayout->add_css('/dist/mypage.css'); ?>
<?php $this->managelayout->add_js('/dist/mypage.js'); ?>

<?php
$this->managelayout->add_script('window.vm.$children[0].$data.isLogin = ("' . $this->member->is_member() . '" != "");');
if (!empty(element('cit_id', $view))) {
    $this->managelayout->add_script('window.vm.$children[0].$data.cit_id = "' . element('cit_id', $view) . '";');
}
?>

<?php $this->managelayout->add_script('var __t1 = '.json_encode(element('userinfo', $view)).'; '); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.userInfo = __t1;'); ?>