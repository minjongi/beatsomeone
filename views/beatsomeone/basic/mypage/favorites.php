<?php $this->managelayout->add_css('/dist/favorites.css'); ?>
<?php $this->managelayout->add_js('/dist/favorites.js'); ?>

<?php
$this->managelayout->add_script('window.vm.$children[0].$data.isLogin = ("' . $this->member->is_member() . '" != "");');
?>
