<?php $this->managelayout->add_css('/dist/billing.css'); ?>
<?php $this->managelayout->add_js('/dist/billing.js'); ?>

<script type="text/javascript" src="https://static-bill.nhnent.com/payco/checkout/js/payco.js" charset="UTF-8"></script>
<script charset="euc-kr" src="https://tx.allatpay.com/common/NonAllatPayRE.js"></script>
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

