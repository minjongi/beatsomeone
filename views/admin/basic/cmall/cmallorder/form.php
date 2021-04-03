<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="box">
    <div class="box-table">
        <ul class="prd-list">

            <?php
            $result = element('data', $view);
            if (element('cor_pg', $result) == 'paypal') {
                $currency_symbol = '$';
            } else {
                $currency_symbol = '₩';
            }
            if (element('orderdetail', $view)) {
            ?>
            <li>
                <h4 class="h2_frm">주문컨텐츠 목록</h4>

                <?php
                $attributes = array('class' => 'frmorderform', 'id' => 'frmorderform');
                echo form_open(current_full_url(), $attributes);
                ?>

                <div>
                    <table class="table table-bordered mt20">
                        <thead>
                        <tr class="success">
                            <!--                            <th>-->
                            <!--                                <input type="checkbox" name="chkall" id="chkall">-->
                            <!--                            </th>-->
                            <th>이미지</th>
                            <th>상품명</th>
                            <th class="text-right">다운로드</th>
                            <th class="text-center">상태</th>
                            <th class="text-center">총수량</th>
                            <th>소계</th>
                            <th>포인트</th>
                            <th>다운로드기간</th>
                            <th>판매자등급</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total_price_sum = 0;
                        $i = 0;
                        foreach (element('orderdetail', $view) as $row) {
                            ?>
                            <tr>
                                <!--                                <td>-->
                                <!--                                    <input type="checkbox" id="ct_chk_-->
                                <!--                                -->
                                <?php //echo $i; ?><!--" class="product_chk" name="chk[]" value="-->
                                <!--                                --><?php //echo $i; ?><!--">-->
                                <!--                                    <input type="hidden" name="cit_id[]" value="-->
                                <!--                                -->
                                <?php //echo element('cit_id', element('item', $row)); ?><!--">-->
                                <!--                                </td>-->
                                <td><a href="<?php echo cmall_item_url(element('cit_key', element('item', $row))); ?>"
                                       target="_blank"><img
                                            src="<?php echo thumb_url('cmallitem', element('cit_file_1', element('item', $row)), 60, 60); ?>"
                                            class="thumbnail" style="margin:0;width:60px;height:60px;"
                                            alt="<?php echo html_escape(element('cit_name', element('item', $row))); ?>"
                                            title="<?php echo html_escape(element('cit_name', element('item', $row))); ?>"/></a>
                                </td>
                                <td colspan="2"><a
                                        href="<?php echo cmall_item_url(element('cit_key', element('item', $row))); ?>"
                                        target="_blank"><?php echo html_escape(element('cit_name', element('item', $row))); ?></a>
                                    <ul class="cmall-options">
                                        <?php
                                        $total_num = 0;
                                        $total_price = 0;
                                        foreach (element('itemdetail', $row) as $detail) {
                                            ?>
                                            <li class="clearfix mt5"><?php echo html_escape(element('cde_title', $detail)) . ' ' . element('cod_count', $detail); ?>
                                                개 (<?php
                                                if (element('cor_pg', $result) == 'paypal') {
                                                    echo $currency_symbol . number_format(element('cde_price_d', $detail), 2);
                                                } else {
                                                    echo $currency_symbol . number_format(element('cde_price', $detail));
                                                }
                                                ?>)
                                                <?php
                                                if (element('cod_status', $detail) === 'order') {
                                                    if (element('possible_download', element('item', $row))) {
                                                        ?>
                                                        <button type="button" class="btn btn-xs btn-success pull-right">
                                                            다운로드가능
                                                        </button>
                                                    <?php } else { ?>
                                                        <button type="button" class="btn btn-xs btn-danger pull-right">
                                                            다운로드 기간 완료
                                                        </button>
                                                    <?php }
                                                } elseif (element('cod_status', $detail) === 'cancel') { ?>
                                                    <button type="button" class="btn btn-xs btn-danger pull-right">
                                                        주문취소
                                                    </button>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <button type="button" class="btn btn-xs btn-danger pull-right">
                                                        입금확인중
                                                    </button>
                                                    <?php
                                                }
                                                ?>
                                            </li>
                                            <?php
                                            $total_num += element('cod_count', $detail);
                                            if (element('cor_pg', $result) == 'paypal') {
                                                $total_price += (float)element('cde_price_d', $detail) * (int)element('cod_count', $detail);
                                            } else {
                                                $total_price += (int)element('cde_price', $detail) * (int)element('cod_count', $detail);
                                            }
                                        }
                                        $total_price_sum += $total_price;
                                        ?>
                                    </ul>
                                </td>
                                <td class="text-center">
                                    <?php
                                    if (element('cod_status', $detail) == 'order') {
                                        echo '결제완료';
                                    } elseif (element('cod_status', $detail) == 'cancel') {
                                        echo '결제취소';
                                    } elseif (element('cod_status', $detail) == 'deposit') {
                                        echo '입금대기';
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $total_num; ?>
                                </td>
                                <td>
                                    <?php
                                    if (element('cor_pg', $result) == 'paypal') {
                                        echo $currency_symbol . number_format($total_price, 2);
                                    } else {
                                        echo $currency_symbol . number_format($total_price);
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php echo element('cod_point', $detail); ?>
                                </td>
                                <td>
                                    <?php
                                    if (element('possible_download', element('item', $row))) {
                                        if (element('download_end_date', element('item', $row))) {
                                            echo '구매후 60일간 ( ~ ' . element('download_end_date', element('item', $row)) . ' 까지)';
                                        } else {
                                            echo '기간제한없음';
                                        }
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php echo element('mgr_description', $detail); ?>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        } //end foreach
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="btn_list02 btn_list">
                    <p>
                        <strong>상태변경</strong>
                        <input type="hidden" name="cor_status" id="cor_status" value="">
                        <input type="hidden" name="cor_pg" id="cor_pg" value="<?php echo element('cor_pg', $result); ?>" />
                        <input type="hidden" name="pcase" value="product">
                        <?php
                        if (element('status', $result) == 'order') {
                            ?>
                            <button type="button" class="btn btn-sm change-status" data-status="0">입금대기</button>
                            <button type="button" class="btn btn-sm change-status" data-status="1">결제완료</button>
                            <?php
                        }
                        ?>
                        <?php
//                        if (element('cor_status', $result) == '2') {
                            if (element('status', $result) == 'order') {
                                ?>
                                <button type="button" class="btn btn-sm change-status" data-status="2">주문취소</button>
                                <?php
                            } elseif (element('status', $result) == 'cancel') {
                                ?>
                                <button type="button" class="btn btn-sm">주문취소됨</button>
                                <?php
                            }
//                        }
                        ?>
                    </p>
                </div>
                <?php echo form_close(); ?>
                <?php
                } //end if
                ?>
        </ul>
        <hr>

        <?php if (element('is_test', element('data', $view))) { ?>
            <div class="bg-classes">
                <p class="bg-danger">주의) 이 주문은 테스트용으로 실제 결제가 이루어지지 않았습니다.</p>
            </div>
        <?php } ?>

        <?php if (element('cor_order_history', element('data', $view))) { ?>
            <section class="bs-callout bs-callout-warning">
                <h4>주문 수량변경 및 주문 전체취소 처리 내역</h4>
                <div>
                    <?php echo nl2br(element('cor_order_history', element('data', $view))); ?>
                </div>
            </section>
        <?php } ?>

        <div class="credit row">
            <?php
            $attributes = array('class' => 'frm_orderinfo', 'name' => 'frm_orderinfo');
            echo form_open(current_full_url(), $attributes);
            ?>
            <input type="hidden" name="cor_id" value="<?php echo element('cor_id', $result); ?>">
            <input type="hidden" name="mem_id" value="<?php echo element('mem_id', $result); ?>">
            <input type="hidden" name="pcase" value="info">

            <div class="clearfix">
                <div class="col-xs-12 col-md-6">
                    <div class="ord-info">
                        <h5 class="ord_info_title mb10">결제정보</h5>
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>주문번호</th>
                                <td><?php echo element('cor_id', element('data', $view)); ?></td>
                            </tr>
                            <tr>
                                <th>결제방식</th>
                                <td><?php echo $this->cmalllib->get_paymethodtype(element('cor_pay_type', element('data', $view))); ?></td>
                            </tr>
                            <tr>
                                <th>총 주문액</th>
                                <td>
                                    <?php
                                    if (element('cor_pg', $result) == 'paypal') {
                                        echo $currency_symbol . number_format(element('cor_total_money', element('data', $view)), 2);
                                    } else {
                                        echo $currency_symbol . number_format(element('cor_total_money', element('data', $view)));
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>결제요청금액</th>
                                <td>
                                    <?php
                                    if (element('cor_pg', $result) == 'paypal') {
                                        echo $currency_symbol . ((element('cor_cash_request', element('data', $view))) ? number_format(abs(element('cor_cash_request', element('data', $view))), 2) : '아직 입금되지 않았습니다');
                                    } else {
                                        echo $currency_symbol . ((element('cor_cash_request', element('data', $view))) ? number_format(abs(element('cor_cash_request', element('data', $view)))) : '아직 입금되지 않았습니다');
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>결제된 금액</th>
                                <td>
                                    <?php
                                    if (element('cor_pg', $result) == 'paypal') {
                                        echo $currency_symbol . number_format(element('cor_cash', element('data', $view)), 2);
                                    } else {
                                        echo $currency_symbol . number_format(element('cor_cash', element('data', $view)));
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>미결제액</th>
                                <td>
                                    <?php
                                    $notyet = abs(element('cor_cash_request', element('data', $view))) - abs(element('cor_cash', element('data', $view)));
                                    if (element('cor_pg', $result) == 'paypal') {
                                        echo $currency_symbol . number_format($notyet, 2);
                                    } else {
                                        echo $currency_symbol . number_format($notyet);
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php if (element('cor_approve_datetime', element('data', $view)) > '1000-01-01 00:00:00') { ?>
                                <tr>
                                    <th>결제일시</th>
                                    <td><?php echo element('cor_approve_datetime', element('data', $view)); ?></td>
                                </tr>
                            <?php } ?>
                            <!--              --><?php //if (strcasecmp(element('cor_pay_type', element('data', $view)), 'abank') == 0) { ?>
                            <!--                <tr>-->
                            <!--                  <th>입금자명</th>-->
                            <!--                  <td>-->
                            <?php //echo html_escape(element('mem_realname', element('data', $view))); ?><!--</td>-->
                            <!--                </tr>-->
                            <!--                <tr>-->
                            <!--                  <th>입금계좌</th>-->
                            <!--                  <td>-->
                            <?php //echo nl2br(html_escape($this->cbconfig->item('payment_bank_info'))); ?><!--</td>-->
                            <!--                </tr>-->
                            <!--              --><?php //} ?>
                            <?php if (strcasecmp(element('cor_pay_type', element('data', $view)), 'card') == 0 or strcasecmp(element('cor_pay_type', element('data', $view)), '3d') == 0) { ?>
                                <tr>
                                    <th>승인번호</th>
                                    <td><?php echo html_escape(element('cor_app_no', element('data', $view))); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 ">
                    <div class="pay-info">
                        <table class="table">
                            <caption>결제상세정보</caption>
                            <colgroup>
                                <col class="grid_3">
                                <col>
                            </colgroup>
                            <tbody>
                            <?php
                            $cor_pay_type = element('cor_pay_type', element('data', $view));
                            $cor_bank_info = element('cor_bank_info', element('data', $view));
                            ?>

                            <?php if (strcasecmp($cor_pay_type, 'card') == 0 or strcasecmp($cor_pay_type, '3d') == 0) { //신용카드 ?>
                                <tr>
                                    <th>신용카드</th>
                                    <td><?php echo $cor_bank_info; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="sodr_sppay"><label for="cor_cash">신용카드 결제금액</label></th>
                                    <td>
                                        <?php echo element('cor_cash', element('data', $view)); ?> 원
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="sodr_sppay"><label for="od_receipt_time">카드 승인일시</label></th>
                                    <td>
                                        <?php echo element('cor_approve_datetime', element('data', $view)); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="cor_admin_memo_box">
                <h4>관리자메모</h4>

                <div class="bg-classes">
                    <p class="bg-warning">
                        현재 열람 중인 주문에 대한 내용을 메모하는곳입니다.
                    </p>
                </div>

                <div class="tbl_wrap">
                    <label for="cor_admin_memo" class="sound_only">유저메모</label>
                    <textarea name="cor_memo" id="cor_memo" placeholder="유저 메모" rows="8"
                              class="form-control"><?php echo stripslashes(element('cor_memo', element('data', $view))); ?></textarea>
                </div>
            </div>

            <div class="tbl_wrap">
                <label for="cor_admin_memo" class="sound_only">관리자메모</label>
                <textarea name="cor_admin_memo" id="cor_admin_memo" rows="8" placeholder="관리자 메모"
                          class="form-control"><?php echo stripslashes(element('cor_admin_memo', element('data', $view))); ?></textarea>
            </div>
        </div>

        <div class="btn-group pull-right" role="group" aria-label="...">
            <button type="submit" class="btn btn-success btn-lg">저장하기</button>
        </div>

        <?php echo form_close(); ?>
    </div> <!-- end credit row class -->

</div> <!-- end class box-table -->
</div> <!-- end class box -->
<form name="fm" hidden>
    <input type="hidden" name="cor_status" id="cor_status" value="2">
    <input type="hidden" name="pcase" value="product">
    <input type=text name="test_cross_key" value="<?php echo $this->cbconfig->item('pg_allat_crosskey') ?>" size="19"
           maxlength=200>
    <input type=text name="allat_shop_id" value="<?php echo $this->cbconfig->item('pg_allat_shop_id') ?>" size="19"
           maxlength=20>
    <input type=text name="allat_order_no" value="<?php echo element('cor_id', $result); ?>" size="19" maxlength=80>
    <input type=text name="allat_amt"
           value="<?php
           if (element('cor_status', $result) == '1' || element('cor_status', $result) == '0') {
               echo ((int)element('cor_total_money', $result) - (int)element('cor_point', $result));
           } else {
               echo (int)element('cor_refund_price', $result);
           }
           ?>"
           size="19"
           maxlength=10>
    <input type=text name="allat_pay_type" value="<?php echo element('cor_pay_type', $result); ?>" size="19"
           maxlength=6>
    <input type=text name="shop_receive_url" value="<?php echo base_url('pg/allat/proc'); ?>" size="19">
    <input type=hidden name=allat_enc_data value=''>
    <input type="hidden" name="allat_opt_pin" value="NOUSE" size="19">
    <input type="hidden" name="allat_opt_mod" value="APP" size="19">
    <input type=text name="allat_seq_no" value="" size="19" maxlength="10">
    <input type=text name="allat_test_yn"
           value="<?php if (element('is_test', $result) == '1') echo 'Y'; else echo 'N'; ?>" size="19" maxlength="1">
</form>
<div id='ALLAT_PLUS_PAY'
     style='left:0px; top:0px; width:0px; height:0px; position:absolute; z-index:1000; display:block; background-color:white;'>
    <iframe id='ALLAT_PLUS_FRAME' name='ALLAT_PLUS_FRAME' src='https://tx.allatpay.com/common/iframe_blank.jsp'
            frameborder=0 width=0px height=0px scrolling=no></iframe>
</div>
<script language=JavaScript charset='euc-kr' src="https://tx.allatpay.com/common/NonAllatPayREPlus.js"></script>
<script language=Javascript>
    // 결과값 반환( receive 페이지에서 호출 )
    function result_submit(result_cd, result_msg, enc_data) {
        if (result_cd != '0000' && result_cd != '0001') {
            window.setTimeout(function () {
                alert(result_cd + " : " + result_msg);
            }, 1000);
        } else {
            document.fm.allat_enc_data.value = enc_data;

            document.fm.action = "<?php echo current_full_url(); ?>";
            document.fm.method = "post";
            document.fm.target = "_self";
            document.fm.submit();
        }
    }
</script>
<script>
    $('.change-status').on('click', function () {
        var status = $(this).data('status');
        var pg = $('#cor_pg').val();
        $('#cor_status').val(status);
        if (status == 2) {
            if (confirm("결제를 취소하시겠습니까?\n\n한번 취소한 결제는 다시 복구할 수 없습니다.")) {
                // console.log(pg);
                if ("<?php echo element('cor_pay_type', $result) ?>" == "FREE") {
                    $('#frmorderform').submit();
                    // let formData1 = new FormData();
                    // formData1.append('free', 'cancel');
                    // formData1.append('cor_id', '<?php echo element('cor_id', $result); ?>');
                    // formData1.append('cor_id', '<?php echo current_full_url(); ?>');
                    // formData1.append('mem_id', '<?php echo element('mem_id', $result); ?>');
                    // fetch('/admin/cmall/cmallorder/ajax_cancelorder', {
                    //     method: 'POST',
                    //     body: formData1
                    // }).then(res => {
                    //     console.log(res);
                    // });
  
                } else {
                    if (pg == 'paypal') {
                        $('#frmorderform').submit();
                    } else if (pg == 'allat') {
                        Allat_Plus_Api(document.fm);
                    }
                }
            }
        } else {
            $('#frmorderform').submit();
        }
    });

    // 결제금액 수동 설정
    function chk_receipt_price() {
        var chk = document.getElementById("od_receipt_chk");
        var price = document.getElementById("cor_cash");

        price.value = chk.checked ? (parseInt(chk.value) + parseInt(price.defaultValue)) : price.defaultValue;
    }

</script>