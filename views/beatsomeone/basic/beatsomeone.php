<?php $this->managelayout->add_css('/dist/beatsomeone.css'); ?>
<script src="https://unpkg.com/wavesurfer.js"></script>
<!--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/amplitudejs@5.0.3/dist/amplitude.js"></script>-->


<?php $this->managelayout->add_js('/dist/beatsomeone.js'); ?>

<?php $this->managelayout->add_script('var t = '.json_encode(element('type1', $view)).'; '); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.init = t;'); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.isLogin = '.($this->member->is_member() ? 'true' : 'false')); ?>
