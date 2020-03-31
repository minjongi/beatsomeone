<?php $this->managelayout->add_css('/dist/login.css'); ?>
<?php $this->managelayout->add_js('/dist/login.js'); ?>


<?php $this->managelayout->add_script('window.vm.$children[0].$data.isLogin = '.($this->member->is_member() ? 'true' : 'false'). ';'); ?>

<?php $this->managelayout->add_script('window.vm.$children[0].$data.errorMsg = "'. str_replace( PHP_EOL, ' ', validation_errors('','')) .'";'); ?>

<?php

echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
//echo show_alert_message(element('message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
//echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');

?>