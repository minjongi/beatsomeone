<?php
$this->managelayout->add_css('/dist/upgrade.css?v=' . time());
$this->managelayout->add_js('/dist/upgrade.js?v='. time());
?>
<script language=Javascript>
    // 결과값 반환( receive 페이지에서 호출 )
    function result_submit(result_cd, result_msg, enc_data) {
        vm.$children[0].$children[1].procCompletePay(result_cd, result_msg, enc_data);
    }
</script>
