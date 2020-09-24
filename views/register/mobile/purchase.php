<?php
$this->managelayout->add_css('/dist/m_purchase.css');
$this->managelayout->add_js('/dist/m_purchase.js');
?>

<script charset="euc-kr" type="text/javascript" src="https://tx.allatpay.com/common/AllatPayM.js"></script>
<script>
window.allat_shop_receive_url = '<?= site_url('pg/allat/proc') ?>';
window.selectedGroup = <?php echo json_encode(element('selectedGroup', $view)); ?>;
</script>
<script language=Javascript>
    // 결과값 반환( receive 페이지에서 호출 )
    function result_submit(result_cd, result_msg, enc_data) {
        var index = vm.$children[0].$children.findIndex(x => x.$vnode.tag.includes('PurchaseMembership'));
        vm.$children[0].$children[index].procCompletePay(result_cd, result_msg, enc_data);
    }
</script>