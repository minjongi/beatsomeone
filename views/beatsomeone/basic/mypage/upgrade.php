<?php
$this->managelayout->add_css('/dist/upgrade.css?v=' . time());
$this->managelayout->add_js('/dist/upgrade.js?v='. time());
?>
<script charset="euc-kr" src="https://tx.allatpay.com/common/NonAllatPayRE.js"></script>
<script language=Javascript>
    window.allat_shop_receive_url = '<?= site_url('pg/allat/proc') ?>';
    // 결과값 반환( receive 페이지에서 호출 )
    function result_submit(result_cd, result_msg, enc_data) {
        var index = vm.$children[0].$children.findIndex(x => x.$vnode.tag.includes('PurchaseMembership'));
        vm.$children[0].$children[index].procCompletePay(result_cd, result_msg, enc_data);
    }
</script>
