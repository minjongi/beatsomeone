<?php $this->managelayout->add_css('/dist/register.css'); ?>
<?php $this->managelayout->add_js('/dist/register.js'); ?>


<?php $this->managelayout->add_script('window.vm.$children[0].$data.isLogin = '.($this->member->is_member() ? 'true' : 'false')); ?>

