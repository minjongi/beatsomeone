<?php
$this->managelayout->add_js(base_url('assets/js/sns.js'));
$this->managelayout->add_js(base_url('plugin/zeroclipboard/ZeroClipboard.js'));
if ($this->cbconfig->item('kakao_apikey')) {
    $this->managelayout->add_js('https://developers.kakao.com/sdk/js/kakao.min.js');
    ?>
    <script type="text/javascript">Kakao.init('<?php echo $this->cbconfig->item('kakao_apikey'); ?>');</script>
<?php } ?>

<?php $this->managelayout->add_css('/dist/m_video.css'); ?>
<?php $this->managelayout->add_js('/dist/m_video.js'); ?>

<?php $this->managelayout->add_script('var t = '.json_encode(element('type1', $view)).'; '); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.init = t;'); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.isLogin = '.($this->member->is_member() ? 'true' : 'false')); ?>

<?php $this->managelayout->add_script('var __t1 = '.json_encode(element('user', $view)).'; '); ?>
<?php $this->managelayout->add_script('window.vm.$children[0].$data.userInfo = __t1;'); ?>
