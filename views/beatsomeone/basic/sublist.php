
<?php $this->managelayout->add_css('/dist/sublist.css'); ?>
<script src="https://unpkg.com/wavesurfer.js"></script>
<script src="/dist/sublist.js"></script>

<?php $this->managelayout->add_script('window.vm.$children[0].$data.isLogin = !!'. $this->member->is_member()); ?>



