<?php $this->managelayout->add_css('/dist/regist_item.css'); ?>
<?php $this->managelayout->add_js('/dist/regist_item.js'); ?>

<?php
$this->managelayout->add_script('var __t1 = '.json_encode(element('userinfo', $view)).'; ');
$this->managelayout->add_script('window.vm.$children[0].$data.userInfo = __t1;');
$this->managelayout->add_script('window.vm.$children[0].$data.isLogin = ("' . $this->member->is_member() . '" != "");');
if (!empty(element('cit_id', $view))) {
    $this->managelayout->add_script('window.vm.$children[0].$data.cit_id = "' . element('cit_id', $view) . '";');
} else {
    $this->managelayout->add_script('window.vm.$children[0].$data.cit_id = 0;');
    $this->managelayout->add_script('window.vm.$children[0].$data.cit_key = "' . uniqid() . '";');
}
?>
