<?php
$this->managelayout->add_css('/dist/register.css');
$this->managelayout->add_js('/dist/register.js');
$this->managelayout->add_js('https://dnh523js9661q.cloudfront.net/apis/apTracker.v3.js?v=0413');
$this->managelayout->add_script('window.vm.$children[0].$data.isLogin = ' . ($this->member->is_member() ? 'true' : 'false'));

//if ($this->member->is_member()) {
//    $this->managelayout->add_script('window.vm.$children[0].$data.info = ' . json_encode($getData));
//    $this->managelayout->add_script('window.vm.$children[0].goPurchase()');
//}

?>

<script charset="euc-kr" src="https://tx.allatpay.com/common/NonAllatPayRE.js"></script>
<script language=JavaScript charset='euc-kr' src="https://tx.allatpay.com/common/NonAllatPayREPlus.js"></script>
<script>
    window.allat_shop_receive_url = '<?= site_url('pg/allat/proc') ?>';
</script>
<script language=Javascript>
    // 결과값 반환( receive 페이지에서 호출 )
    function result_submit(result_cd, result_msg, enc_data) {
        var index = vm.$children[0].$children.findIndex(x => x.$vnode.tag.includes('PurchaseMembership'));
        vm.$children[0].$children[index].procCompletePay(result_cd, result_msg, enc_data);
    }
</script>
