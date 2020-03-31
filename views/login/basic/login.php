<?php $this->managelayout->add_css('/dist/login.css'); ?>
<?php $this->managelayout->add_js('/dist/login.js'); ?>


<?php $this->managelayout->add_script('window.vm.$children[0].$data.isLogin = '.($this->member->is_member() ? 'true' : 'false')); ?>
