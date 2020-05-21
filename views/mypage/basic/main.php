<?php $this->managelayout->add_css('/dist/mypage.css'); ?>
<?php $this->managelayout->add_js('/dist/mypage.js'); ?>

<?php 
$this->managelayout->add_script('window.vm.$children[0].$data.isLogin = ("' . $this->member->is_member() . '" != "");');
if (!empty(element('cit_id', $view))) {
    $this->managelayout->add_script('window.vm.$children[0].$data.cit_id = "' . element('cit_id', $view) . '";');
}
?>