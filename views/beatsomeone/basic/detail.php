
<?php $this->managelayout->add_css('/dist/detail.css'); ?>
<script src="https://unpkg.com/wavesurfer.js"></script>

<?php $this->managelayout->add_js('/dist/detail.js'); ?>


<?php $this->managelayout->add_script('window.vm.$children[0].$data.isLogin = ("'. $this->member->is_member() .'" != "");'); ?>
<?php $this->managelayout->add_script('var __t1 = '.json_encode(element('item', $view)).'; '); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.item = __t1;'); ?>

