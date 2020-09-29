<?php $this->managelayout->add_css('/dist/m_mypage.css'); ?>
<?php $this->managelayout->add_js('/dist/m_mypage.js'); ?>

<script language=JavaScript charset='euc-kr' src="https://tx.allatpay.com/common/NonAllatPayREPlus.js"></script>
<script language=Javascript>
    // 결과값 반환( receive 페이지에서 호출 )
    function result_submit(result_cd,result_msg,enc_data) {
        vm.$children[0].$refs.routerView.$refs.refundModal.procCompletePay(result_cd, result_msg, enc_data);
    }
</script>