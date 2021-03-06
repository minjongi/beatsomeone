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
                <a href="<?php echo element('listall_url', $view); ?>" class="btn btn-outline btn-default btn-sm">전체목록</a>
                <button type="button" class="btn btn-outline btn-default btn-sm btn-list-delete btn-list-selected disabled" data-list-delete-url = "<?php echo element('list_delete_url', $view); ?>" >선택삭제</button>
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
                    <th>회원아이디</th>
                    <th>회원명</th>
                    <th>기간</th>
                    <th>그룹</th>
                    <th>그룹명</th>
                    <th>시작일자</th>
                    <th>마감일자</th>
                    <th>지불방식</th>
                    <th>지불량</th>
                    <th>날짜</th>
                    <th><input type="checkbox" name="chkall" id="chkall" /></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (element('list', element('data', $view))) {
                    foreach (element('list', element('data', $view)) as $result) {
                        ?>
                        <tr>
                            <td><?php echo number_format(element('num', $result)); ?></td>
                            <td><a href="?sfield=member_login_log.mem_id&amp;skeyword=<?php echo element('mem_id', $result); ?>"><?php echo html_escape(element('mem_userid', $result)); ?></a></td>
                            <td><?php echo element('display_name', $result); ?></td>
                            <td><?php echo element('bill_term', $result); ?></td>
                            <td><?php echo element('plan', $result); ?></td>
                            <td><?php echo element('plan_name', $result); ?></td>
                            <td><?php echo cdate(element('start_date', $result)); ?></td>
                            <td><?php echo element('end_date', $result); ?></td>
                            <td><?php echo element('pay_method', $result); ?></td>
                            <td><?php echo element('amount', $result); ?></td>
                            <td><?php echo display_datetime(element('mmpl_datetime', $result), 'full'); ?></td>
                            <td><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element(element('primary_key', $view), $result); ?>" /></td>
                        </tr>
                        <?php
                    }
                }
                if ( ! element('list', element('data', $view))) {
                    ?>
                    <tr>
                        <td colspan="12" class="nopost">자료가 없습니다</td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="box-info">
            <?php echo element('paging', $view); ?>
            <div class="pull-left ml20"><?php echo admin_listnum_selectbox();?></div>
            <?php echo $buttons; ?>
        </div>
        <?php echo form_close(); ?>
    </div>
    <form name="fsearch" id="fsearch" action="<?php echo current_full_url(); ?>" method="get">
        <div class="box-search">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <select class="form-control" name="sfield" >
                        <?php echo element('search_option', $view); ?>
                    </select>
                    <div class="input-group">
                        <input type="text" class="form-control" name="skeyword" value="<?php echo html_escape(element('skeyword', $view)); ?>" placeholder="Search for..." />
                        <span class="input-group-btn">
							<button class="btn btn-default btn-sm" name="search_submit" type="submit">검색!</button>
						</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
