<?php $this->managelayout->add_css('/dist/m_login.css'); ?>
<?php $this->managelayout->add_js('/dist/m_login.js'); ?>


<?php $this->managelayout->add_script('window.vm.$children[0].$data.isLogin = '.($this->member->is_member() ? 'true' : 'false'). ';'); ?>

<?php $this->managelayout->add_script('window.vm.$children[0].$data.errorMsg = "'. str_replace( PHP_EOL, ' ', validation_errors('','')) .'";'); ?>

<?php

echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');


?>