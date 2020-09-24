<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<style type="text/css">
    /* 외부서비스 사이트코드 */
    .pg_setting .sitecode {
        display: inline-block;
        font: bold 15px 'Verdana';
        vertical-align: middle
    }

    .form-group .pg_info .form-inline {
        background-color: #FFF;
        padding-bottom: 10px
    }

    .pg_setting .pg_kcp {
        background-color: #F6FCFF
    }

    .pg_setting .pg_lg {
        background-color: #FFF4FA
    }

    .pg_setting .pg_inicis {
        background-color: #F6F1FF
    }

    .pg_setting .pg_paypal {
        background-color: #0079C1;
    }

    .pg_setting .pg_paypal .control-label {
        color: white;
    }

    .pg_setting .pg_allat {
        background-color: #44217a;
    }

    .pg_setting .pg_allat .control-label {
        color: white;
    }

    .pg_setting .kcp_btn {
        display: inline-block;
        margin: 5px 0 0;
        padding: 5px 10px;
        background: #226C8B;
        color: #fff;
        font-weight: normal;
        text-decoration: none
    }

    .kcp_btn:hover, .kcp_btn:active {
        color: #fff
    }

    .pg_setting .lg_btn {
        display: inline-block;
        margin: 5px 0 0;
        padding: 5px 10px;
        background: #ED008C;
        color: #fff;
        font-weight: normal;
        text-decoration: none
    }

    .pg_setting .lg_btn:hover, .lg_btn:active {
        color: #fff
    }

    .pg_setting .kg_btn {
        display: inline-block;
        margin: 5px 0 0;
        padding: 5px 10px;
        background: #4A2C7C;
        color: #fff;
        font-weight: normal;
        text-decoration: none
    }

    .pg_setting .kg_btn:hover, .kg_btn:active {
        color: #fff
    }

    .pg_setting .pg_input {
        font: bold 15px Consolas
    }
</style>
<div class="box pg_setting">
    <div class="box-header">
        <ul class="nav nav-tabs">
            <li role="presentation"><a href="<?php echo admin_url($this->pagedir); ?>"
                                       onclick="return check_form_changed();">기본설정</a></li>
            <li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/layout'); ?>"
                                       onclick="return check_form_changed();">레이아웃/메타태그</a></li>
            <li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/access'); ?>"
                                       onclick="return check_form_changed();">권한관리</a></li>
            <li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/editor'); ?>"
                                       onclick="return check_form_changed();">에디터기능</a></li>
            <li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/smsconfig'); ?>"
                                       onclick="return check_form_changed();">SMS 설정</a></li>
            <li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/paymentconfig'); ?>"
                                                      onclick="return check_form_changed();">결제기능</a></li>
            <li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/alarm'); ?>"
                                       onclick="return check_form_changed();">알림설정</a></li>
        </ul>
    </div>
    <div class="box-table">
        <?php
        echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
        echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');

        $use_payment_pg = element('use_payment_pg', element('data', $view));

        $attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
        echo form_open(current_full_url(), $attributes);
        ?>
        <input type="hidden" name="is_submit" value="1"/>
        <div class="form-group">
            <label class="col-sm-2 control-label">현금/카드 결제시 결제 가능 방법</label>
            <div class="col-sm-10 form-inline">
                <label for="use_payment_card" class="checkbox-inline">
                    <input type="checkbox" name="use_payment_card" id="use_payment_card"
                           value="1" <?php echo set_checkbox('use_payment_card', '1', (element('use_payment_card', element('data', $view)) ? true : false)); ?> />
                    카드결제
                </label>
                <label for="use_payment_realtime" class="checkbox-inline">
                    <input type="checkbox" name="use_payment_realtime" id="use_payment_realtime"
                           value="1" <?php echo set_checkbox('use_payment_realtime', '1', (element('use_payment_realtime', element('data', $view)) ? true : false)); ?> />
                    실시간계좌이체
                </label>
                <?php
                echo '<input type="hidden" name="use_payment_easy" value="0" >';
                /*	 //나중에 업데이트 해야 함
                <label for="use_payment_easy" class="checkbox-inline">
                    <input type="checkbox" name="use_payment_easy" id="use_payment_easy" value="1" <?php echo set_checkbox('use_payment_easy', '1', (element('use_payment_easy', element('data', $view)) ? true : false)); ?> /> 간편결제
                </label>
                */
                ?>
            </div>
        </div>
        <div class="form-group" id="paypal_info">
            <div class="pg_info pg_paypal clearfix">
                <div class="col-sm-2 control-label">
                    <label for="pg_paypal_live_id">PAYPAL LIVE Client ID</label>
                </div>
                <div class="col-sm-10 form-inline">
                    <input type="text" class="form-control" style="width: 300px;" name="pg_paypal_live_id" id="pg_paypal_live_id"
                           value="<?php echo set_value('pg_paypal_live_id', element('pg_paypal_live_id', element('data', $view))); ?>"
                    />
                    <div class="help-block">

                    </div>
                </div>
            </div>
            <div class="pg_info pg_paypal clearfix">
                <div class="col-sm-2 control-label">
                    <label for="pg_paypal_sandbox_id">PAYPAL Sandbox Client ID</label>
                </div>
                <div class="col-sm-10 form-inline">
                    <input type="text" class="form-control" style="width: 300px;" name="pg_paypal_sandbox_id" id="pg_paypal_sandbox_id"
                           value="<?php echo set_value('pg_paypal_sandbox_id', element('pg_paypal_sandbox_id', element('data', $view))); ?>"
                    />
                    <div class="help-block">

                    </div>
                </div>
            </div>
        </div>

        <div class="form-group" id="allat_info">
            <div class="pg_info pg_allat clearfix">
                <div class="col-sm-2 control-label">
                    <label for="pg_paypal_live_id">Allat Cross key</label>
                </div>
                <div class="col-sm-10 form-inline">
                    <input type="text" class="form-control" style="width: 300px;" name="pg_allat_crosskey" id="pg_allat_crosskey"
                           value="<?php echo set_value('pg_allat_crosskey', element('pg_allat_crosskey', element('data', $view))); ?>"
                    />
                    <div class="help-block">

                    </div>
                </div>
            </div>
            <div class="pg_info pg_allat clearfix">
                <div class="col-sm-2 control-label">
                    <label for="pg_paypal_sandbox_id">Allat Shop ID</label>
                </div>
                <div class="col-sm-10 form-inline">
                    <input type="text" class="form-control" style="width: 300px;" name="pg_allat_shop_id" id="pg_allat_shop_id"
                           value="<?php echo set_value('pg_allat_shop_id', element('pg_allat_shop_id', element('data', $view))); ?>"
                    />
                    <div class="help-block">

                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">무이자할부 기능 사용</label>
            <div class="col-sm-10">
                <label for="use_pg_no_interest" class="checkbox-inline">
                    <input type="checkbox" name="use_pg_no_interest" id="use_pg_no_interest"
                           value="1" <?php echo set_checkbox('use_pg_no_interest', '1', (element('use_pg_no_interest', element('data', $view)) ? true : false)); ?> />
                    사용합니다
                </label>
                <div class="help-block">이 기능을 사용하시면, PG사 가맹점 관리자 페이지에서 설정하신 무이자할부 설정이 적용됩니다.<br/>
                    사용안하시면 PG사 무이자 이벤트 카드를 제외한 모든 카드의 무이자 설정이 적용되지 않습니다.
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">실결제여부</label>
            <div class="col-sm-10">
                <label class="radio-inline" for="use_pg_test_2">
                    <input type="radio" name="use_pg_test" id="use_pg_test_2"
                           value="0" <?php echo set_checkbox('use_pg_test', '0', (!element('use_pg_test', element('data', $view)) ? true : false)); ?> />
                    실결제
                </label>
                <label class="radio-inline" for="use_pg_test_1">
                    <input type="radio" name="use_pg_test" id="use_pg_test_1"
                           value="1" <?php echo set_checkbox('use_pg_test', '1', (element('use_pg_test', element('data', $view)) ? true : false)); ?> />
                    테스트 결제
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">계좌안내(무통장입금시)</label>
            <div class="col-sm-10">
                <textarea class="form-control" rows="3"
                          name="payment_bank_info"><?php echo set_value('payment_bank_info', element('payment_bank_info', element('data', $view))); ?></textarea>
                <div class="help-block">예) 00은행 123-456-7890 예금주 : 홍길동</div>
            </div>
        </div>
        <div class="btn-group pull-right" role="group" aria-label="...">
            <button type="submit" class="btn btn-success btn-sm">저장하기</button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript">
    //<![CDATA[
    jQuery(function ($) {
        $('#fadminwrite').validate({
            rules: {
                use_payment_pg: {required: true}
            }
        });

        $("#use_payment_pg").hide();

        $(".de_pg_tab").on("click", "a", function (e) {

            var pg = $(this).attr("data-value"),
                class_name = "tab-current";

            $("#use_payment_pg").val(pg)
                .trigger("payment_change");

            $(this).parent("li").addClass(class_name).siblings().removeClass(class_name);

            /*
            $(".pg_vbank_url:visible").hide();
            $("#"+pg+"_vbank_url").show();
            $(".scf_cardtest").addClass("scf_cardtest_hide");
            $("."+pg+"_cardtest").removeClass("scf_cardtest_hide");
            $(".scf_cardtest_tip_adm").addClass("scf_cardtest_tip_adm_hide");
            $("#"+pg+"_cardtest_tip").removeClass("scf_cardtest_tip_adm_hide");
            */
        });

        $("#use_payment_vbank").on("click", function (e) {
            $("#use_payment_pg").trigger("payment_change");
        });

        $("#use_payment_pg").on("payment_change", function (e) {

            $(".pg_info_hide").hide();

            var $pg = $(this).val(),
                $info_anchor = $("#" + $pg + "_info_anchor");

            if ($("#use_payment_vbank").prop("checked") && $info_anchor.length) {
                $info_anchor.find(".pg_info_hide").show();
            }

        });

        $("#use_payment_pg").trigger("payment_change");
    });

    var form_original_data = jQuery('#fadminwrite').serialize();

    function check_form_changed() {
        if (jQuery('#fadminwrite').serialize() !== form_original_data) {
            if (confirm('저장하지 않은 정보가 있습니다. 저장하지 않은 상태로 이동하시겠습니까?')) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

    //]]>
</script>
