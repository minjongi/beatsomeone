
<?php $this->managelayout->add_css('/dist/m_detail.css'); ?>
<script src="https://unpkg.com/wavesurfer.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/amplitudejs@5.0.3/dist/amplitude.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.14/mediaelementplayer.min.css">
<?php $this->managelayout->add_js('/dist/m_detail.js'); ?>


<?php $this->managelayout->add_script('window.vm.$children[0].$data.isLogin = ("'. $this->member->is_member() .'" != "");'); ?>
<?php $this->managelayout->add_script('var __t1 = '.json_encode(element('item', $view)).'; '); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.item = __t1;'); ?>

