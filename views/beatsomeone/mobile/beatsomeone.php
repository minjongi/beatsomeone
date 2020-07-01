<?php $this->managelayout->add_css('/dist/m_beatsomeone.css'); ?>
<!--<script src="https://unpkg.com/wavesurfer.js"></script>-->
<!--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/amplitudejs@5.0.3/dist/amplitude.js"></script>-->

<?php $this->managelayout->add_js('/dist/m_beatsomeone.js'); ?>

<?php $this->managelayout->add_script('var t = '.json_encode(element('type1', $view)).'; '); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.init = t;'); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.isLogin = '.($this->member->is_member() ? 'true' : 'false')); ?>

<?php $this->managelayout->add_script('var __t1 = '.json_encode(element('user', $view)).'; '); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.userInfo = __t1;'); ?>


