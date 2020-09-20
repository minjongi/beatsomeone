<?php $this->managelayout->add_css('/dist/m_billing.css'); ?>
<?php $this->managelayout->add_js('/dist/m_billing.js'); ?>

<?php
$this->managelayout->add_script('window.vm.$children[0].$data.isLogin = ("' . $this->member->is_member() . '" != "");');
/*
if (!empty(element('cit_id', $view))) {
    $this->managelayout->add_script('window.vm.$children[0].$data.cit_id = "' . element('cit_id', $view) . '";');
}*/
?>
<script charset="euc-kr" src="https://tx.allatpay.com/common/NonAllatPayRE.js"></script>
<script language=Javascript>
    // 결과값 반환( receive 페이지에서 호출 )
    function result_submit(result_cd, result_msg, enc_data) {
        vm.$children[0].procCompletePay(result_cd, result_msg, enc_data);
    }
</script>
