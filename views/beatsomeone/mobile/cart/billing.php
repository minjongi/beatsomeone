<?php $this->managelayout->add_css('/dist/m_billing.css'); ?>
<?php $this->managelayout->add_js('/dist/m_billing.js'); ?>

<?php
$this->managelayout->add_script('window.vm.$children[0].$data.isLogin = ("' . $this->member->is_member() . '" != "");');
/*
if (!empty(element('cit_id', $view))) {
    $this->managelayout->add_script('window.vm.$children[0].$data.cit_id = "' . element('cit_id', $view) . '";');
}*/
?>
<script type="text/javascript" src="https://static-bill.nhnent.com/payco/checkout/js/payco.js" charset="UTF-8"></script>
<script charset="euc-kr" type="text/javascript" src="https://tx.allatpay.com/common/AllatPayM.js"></script>
<script language=Javascript>
    window.allat_shop_receive_url = '<?= site_url('pg/allat/proc') ?>';
    // 결과값 반환( receive 페이지에서 호출 )
    function result_submit(result_cd, result_msg, enc_data) {
        vm.$children[0].procCompletePay(result_cd, result_msg, enc_data);
    }

    function payco_result_submit(code, msg, data) {
        vm.$children[0].procCompletePayco(code, msg, data);
    }

    function payletter_result_submit() {
        vm.$children[0].procCompletePayletter();
    }
</script>
