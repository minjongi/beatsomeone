<?php $this->managelayout->add_css('/dist/billing.css'); ?>
<?php $this->managelayout->add_js('/dist/billing.js'); ?>

<script charset="euc-kr" src="https://tx.allatpay.com/common/NonAllatPayRE.js"></script>
<script language=Javascript>
    // 결과값 반환( receive 페이지에서 호출 )
    function result_submit(result_cd, result_msg, enc_data) {
        vm.$children[0].procCompletePay(result_cd, result_msg, enc_data);
    }
</script>
