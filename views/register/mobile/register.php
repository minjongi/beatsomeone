<?php
$this->managelayout->add_css('/dist/m_register.css');
$this->managelayout->add_js('/dist/m_register.js');

$this->managelayout->add_script('window.vm.$children[0].$data.isLogin = '.($this->member->is_member() ? 'true' : 'false'));

if ($this->member->is_member()) {
    $this->managelayout->add_script('window.vm.$children[0].$data.info = ' . json_encode($getData));
    $this->managelayout->add_script('window.vm.$children[0].goPurchase()');
}
?>
<script charset="euc-kr" src="https://tx.allatpay.com/common/NonAllatPayRE.js"></script>
<script language=Javascript>
    // 결과값 반환( receive 페이지에서 호출 )
    function result_submit(result_cd, result_msg, enc_data) {
        var index = vm.$children[0].$children.findIndex(x => x.$vnode.tag.includes('PurchaseMembership'));
        vm.$children[0].$children[index].procCompletePay(result_cd, result_msg, enc_data);
    }
</script>
