<?php $this->managelayout->add_css('/dist/m_findaccount.css'); ?>
<?php $this->managelayout->add_js('/dist/m_findaccount.js'); ?>



<?php $this->managelayout->add_script('window.vm.$children[0].$data.isLogin = '.($this->member->is_member() ? 'true' : 'false')); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.message = "'.element('message', $view).'"'); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.errorMsg = "'. str_replace( PHP_EOL, ' ', validation_errors('','')) .'";'); ?>
