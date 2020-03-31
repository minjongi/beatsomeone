<?php $this->managelayout->add_css('/dist/m_register.css'); ?>
<?php $this->managelayout->add_js('/dist/m_register.js'); ?>


<?php $this->managelayout->add_script('window.vm.$children[0].$data.isLogin = '.($this->member->is_member() ? 'true' : 'false')); ?>

