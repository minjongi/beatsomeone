
<?php $this->managelayout->add_css('/dist/beatsomeone.css'); ?>
<script src="https://unpkg.com/wavesurfer.js"></script>

<?php $this->managelayout->add_js('/dist/beatsomeone.js'); ?>


<?php $this->managelayout->add_script('var t = '.json_encode(element('type1', $view)).'; '); ?>

<?php $this->managelayout->add_script('window.vm.$children[0].$data.init = t;'); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.isLogin = !!'. $this->member->is_member()); ?>

<?php //$this->managelayout->add_script('console.log({vm:window.vm.$children[0].$data});'); ?>
