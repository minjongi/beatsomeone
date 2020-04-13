
<?php $this->managelayout->add_css('/dist/sublist.css'); ?>
<script src="https://unpkg.com/wavesurfer.js"></script>
<?php $this->managelayout->add_js('/dist/sublist.js'); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.isLogin = !!'. $this->member->is_member()); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.param.search = "'.$_GET['search'].'"'); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.param.currentGenre = "'.$_GET['genre'].'"'); ?>



