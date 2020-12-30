<?php
$this->managelayout->add_css('/dist/m_purchase.css');
$this->managelayout->add_js('/dist/m_purchase.js');
$a = $_SERVER['QUERY_STRING'];
$b = explode('&', $a)[0];
$c = explode('=', $b)[1];
if (intval($c) > 4) {
    $this->managelayout->add_script("
        function result_submit(result_cd,result_msg,enc_data) {
            Allat_Mobile_Close();
            if(result_cd != '0000') {
                alert(result_cd + ' +: ' + result_msg);
            } else {
                fm1.allat_enc_data.value = enc_data;
                fm1.action = 'https://qa.beatsomeone.com/pg/allat/subscribeM';
                fm1.method = 'post';
                fm1.target = '_self';
                fm1.submit();
            }
        }
    
    ");
} else {
    $this->managelayout->add_script("
        function result_submit(result_cd, result_msg, enc_data) {
            vm."."$"."children[0].procCompletePay(result_cd, result_msg, enc_data);
        }
    ");
}

?>
<script charset="euc-kr" type="text/javascript" src="https://tx.allatpay.com/common/AllatPayM.js"></script>
<script>
window.allat_shop_receive_url = '<?= site_url('pg/allat/proc') ?>';
window.selectedGroup = <?php echo json_encode(element('selectedGroup', $view)); ?>;
</script>
