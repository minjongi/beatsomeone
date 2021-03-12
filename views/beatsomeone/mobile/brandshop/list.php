<?php $this->managelayout->add_css('/dist/m_brandshop.css'); ?>
<script src="https://unpkg.com/wavesurfer.js"></script>
<?php $this->managelayout->add_js('/dist/m_brandshop.js'); ?>
<?php if($this->member->is_member()) { ?>
    <?php $this->managelayout->add_script('window.vm.$children[0].$data.isLogin = !!'. $this->member->is_member() .';'); ?>
<?php } ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.param.search = "'.$_GET['search'].'"'); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.brand = '.json_encode($view['brand'])); ?>
<?php if($_GET['genre']) { ?>
    <?php $this->managelayout->add_script('window.vm.$children[0].$data.param.currentGenre = "'.$_GET['genre'].'"'); ?>
<?php } ?>


