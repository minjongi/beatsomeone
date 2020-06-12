<?php $this->managelayout->add_css('/dist/m_cart.css'); ?>
<?php $this->managelayout->add_js('/dist/m_cart.js'); ?>

<?php
$this->managelayout->add_script('window.vm.$children[0].$data.isLogin = ("' . $this->member->is_member() . '" != "");');
/*
log_message('error', '=>>>>>' . print_r(element('data', $view)));
if (element('data', $view)) {
	log_message('error', '------');
	foreach (element('data', $view) as $result) {
		log_message('error', $result);
		$this->managelayout->add_script('window.vm.$children[0].$data.uudidl = "' . $result . '";');
	}
}
if (!empty(element('cit_id', $view))) {
    $this->managelayout->add_script('window.vm.$children[0].$data.cit_id = "' . element('cit_id', $view) . '";');
}*/
?>