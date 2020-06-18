<?php $this->managelayout->add_css('/dist/billing.css'); ?>
<?php $this->managelayout->add_js('/dist/billing.js'); ?>

<?php
$this->managelayout->add_script('window.vm.$children[0].$data.isLogin = ("' . $this->member->is_member() . '" != "");');
/*
if (!empty(element('cit_id', $view))) {
    $this->managelayout->add_script('window.vm.$children[0].$data.cit_id = "' . element('cit_id', $view) . '";');
}*/
?>
<script charset="euc-kr" src="https://tx.allatpay.com/common/NonAllatPayRE.js"></script>
<script>
    //window.allat_shop_receive_url = '<?//= site_url('pg/allat/proc') ?>//';
    window.allat_shop_receive_url = 'http://mvp.beatsomeone.com';
</script>
<script language=Javascript>
    // 결제페이지 호출
    function ftn_approval(dfm) {
        AllatPay_Approval(dfm);
        // 결제창 자동종료 체크 시작
        AllatPay_Closechk_Start();
    }

    // 결과값 반환( receive 페이지에서 호출 )
    function result_submit(result_cd,result_msg,enc_data) {

        // 결제창 자동종료 체크 종료
        AllatPay_Closechk_End();

        if( result_cd != '0000' ){
            window.setTimeout(function(){alert(result_cd + " : " + result_msg);},1000);
        } else {
            fm.allat_enc_data.value = enc_data;

            fm.action = "allat_approval.php";
            fm.method = "post";
            fm.target = "_self";
            fm.submit();
        }
    }
</script>

