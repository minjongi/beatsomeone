
<?php $this->managelayout->add_css('/dist/detail.css'); ?>
<script src="https://unpkg.com/wavesurfer.js"></script>

<?php $this->managelayout->add_js('/dist/detail.js'); ?>

<?php echo var_dump($view) ?>

<?php $this->managelayout->add_script('var __t1 = '.json_encode(element('item', $view)).'; '); ?>
<?php $this->managelayout->add_script('var __t2 = '.json_encode(element('meta', $view)).'; '); ?>
<?php $this->managelayout->add_script('var __t3 = '.json_encode(element('detail', $view)).'; '); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.item = __t1;'); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.meta = __t2;'); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.detail = __t3;'); ?>

