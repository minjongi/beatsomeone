<div class="box">
    <div class="box-table">
        <?php
        echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
        $attributes = array('class' => 'form-inline', 'name' => 'flist', 'id' => 'flist');
        echo form_open(current_full_url(), $attributes);
        ?>
        <div class="box-table-header">
            <?php
            ob_start();
            ?>
            <div class="btn-group pull-right" role="group" aria-label="...">
                <button type="button" class="btn btn-outline btn-primary btn-sm" data-url="/admin/cmall/settlement/settle" onclick="doSettlement(event)">정산하기</button>
            </div>
            <?php
            $buttons = ob_get_contents();
            ob_end_flush();
            ?>
        </div>
        <div class="row">전체 : <?php echo element('total_rows', element('data', $view), 0); ?>건</div>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <thead>
                <tr>
                    <th>번호</th>
                    <th>구매일시</th>
                    <th>판매자 닉네임</th>
                    <th>판매자 그룹</th>
                    <th>이미지</th>
                    <th>주문 상품 정보</th>
                    <th>구매자 닉네임</th>
                    <th>PG</th>
                    <th>총 구매 금액</th>
                    <th>주문 상태</th>
                    <th>수수료</th>
                    <th>정산 금액</th>
                    <th>정산 상태</th>
                    <th>정산 일시</th>
                    <th><input type="checkbox" name="chkall" id="chkall"/></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (element('list', element('data', $view))) {
                    foreach (element('list', element('data', $view)) as $result) {
                        ?>
                        <tr>
                            <td><?php echo number_format(element('num', $result)); ?></td>
                            <td><?php echo element('cor_datetime', $result); ?></td>
                            <td><?php echo element('seller_nickname', $result); ?></td>
                            <td><?php echo element('mgr_description', $result); ?></td>
                            <td>
                                <?php if (element('cit_file_1', $result)) { ?>
                                    <img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $result), 80); ?>"
                                         alt="<?php echo element('item_name', $result); ?>" class="thumbnail mg0" style="width:80px;"/>
                                <?php } ?>
                            </td>
                            <td>
                                <?php echo element('item_name', $result); ?>
                            </td>
                            <td><?php echo element('buyer_nickname', $result); ?></td>
                            <td>
                                <?php echo element('cor_pg', $result); ?>
                            </td>
                            <td>
                                <?php
                                if (strcasecmp(element('cor_pg', $result), 'allat') == 0) {
                                    echo '₩ ' . number_format(element('total_money', $result));
                                } else {
                                    echo '$ ' . number_format(element('total_money', $result), 2);
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (strcasecmp(element('cod_status', $result), 'order') == 0) {
                                    echo '결제완료';
                                } elseif (strcasecmp(element('cod_status', $result), 'deposit') == 0) {
                                    echo '입금대기';
                                } elseif (strcasecmp(element('cod_status', $result), 'cancel') == 0) {
                                    echo '결제취소';
                                }
                                ?>
                            </td>
                            <td>
                                <?php echo element('mgr_commission', $result); ?> %
                            </td>
                            <td>
                                <?php
                                if (strcasecmp(element('cor_pg', $result), 'allat') == 0) {
                                    echo '₩ ' . number_format(element('csh_settle_money', $result));
                                } else {
                                    echo '$ ' . number_format(element('csh_settle_money', $result), 2);
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (element('csh_status', $result) == null) {
                                    echo '정산대기';
                                } else {
                                    echo '정산완료';
                                }
                                ?>
                            </td>
                            <td>
                                <?php echo element('csh_datetime', $result); ?>
                            </td>
                            <td><input type="checkbox" name="chk[]" class="list-chkbox"
                                       value="<?php echo element('cod_id', $result); ?>"/></td>
                        </tr>
                        <?php
                    }
                }
                if (!element('list', element('data', $view))) {
                    ?>
                    <tr>
                        <td colspan="8" class="nopost">자료가 없습니다</td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="box-info">
            <?php echo element('paging', $view); ?>
            <div class="pull-left ml20"><?php echo admin_listnum_selectbox(); ?></div>
            <?php echo $buttons; ?>
        </div>
        <?php echo form_close(); ?>
    </div>
<!--    <form name="fsearch" id="fsearch" action="--><?php //echo current_full_url(); ?><!--" method="get">-->
<!--        <div class="box-search">-->
<!--            <div class="row">-->
<!--                <div class="col-md-6 col-md-offset-3">-->
<!--                    <select class="form-control" name="sfield">-->
<!--                        --><?php //echo element('search_option', $view); ?>
<!--                    </select>-->
<!--                    <div class="input-group">-->
<!--                        <input type="text" class="form-control" name="skeyword"-->
<!--                               value="--><?php //echo html_escape(element('skeyword', $view)); ?><!--"-->
<!--                               placeholder="Search for..."/>-->
<!--                        <span class="input-group-btn">-->
<!--							<button class="btn btn-default btn-sm" name="search_submit" type="submit">검색!</button>-->
<!--						</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </form>-->
</div>
<script>
    function doSettlement(event) {
        if ($("input[name='chk[]']:checked", $('#flist')).length < 1) {
            alert('자료를 하나 이상 선택하세요.');
            return;
        }
        $('#flist').attr('action', event.target.dataset.url);
        $('#flist').submit();
    }
</script>