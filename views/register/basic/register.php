<?php
$this->managelayout->add_css('/dist/register.css');
$this->managelayout->add_js('/dist/register.js');

$this->managelayout->add_script('window.vm.$children[0].$data.isLogin = ' . ($this->member->is_member() ? 'true' : 'false'));

if ($this->member->is_member()) {
    $this->managelayout->add_script('window.vm.$children[0].$data.info = ' . json_encode($getData));
    $this->managelayout->add_script('window.vm.$children[0].goPurchase()');
}
?>
