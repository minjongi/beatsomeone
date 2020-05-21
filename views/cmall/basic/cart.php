<?php $this->managelayout->add_css('/dist/cart.css'); ?>
<?php $this->managelayout->add_js('/dist/cart.js'); ?>


<?php $this->managelayout->add_script('window.vm.$children[0].$data.isLogin = '.($this->member->is_member() ? 'true' : 'false')); ?>

