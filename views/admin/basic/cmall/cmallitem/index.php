<div class="box">
    <div class="box-table">
        <div>
            <script>
                function proc_search() {
                    $('#fsearch1').submit();
                }
            </script>
            <form name="fsearch1" id="fsearch1" action="<?php echo current_full_url(); ?>" method="get">
                <div style="padding: 10px;">

                </div>
                <div class="box-search">
                    <div class="row">
                        <div class="col-md-6">
                            <span style="border:1px solid #dcdcdc;padding: 10px;margin-right:10px;">
                                <label>
                                    <input type="radio" name="stype" value="" checked onclick="proc_search();"> 전체
                                </label>
                                <label>
                                    <input type="radio" name="stype" value="free" <?= (element('stype', $view) == 'free') ? 'checked' : '' ?> onclick="proc_search();"> 무료비트
                                </label>
                                <label>
                                    <input type="radio" name="stype" value="org" <?= (element('stype', $view) == 'org') ? 'checked' : '' ?> onclick="proc_search();"> 오리지널콘텐츠
                                </label>
                                <label>
                                    <input type="radio" name="stype" value="subscribe" <?= (element('stype', $view) == 'subscribe') ? 'checked' : '' ?> onclick="proc_search();"> 정기구독
                                </label>
                            </span>
                            <span style="border:1px solid #dcdcdc;padding: 10px;margin-right:10px;">
                                <label>
                                    <input type="checkbox" name="type1" value="1" <?= (element('type1', $view) == '1') ? 'checked' : '' ?> onclick="proc_search();"> 추천
                                </label>
                                <label>
                                    <input type="checkbox" name="type2" value="1" <?= (element('type2', $view) == '1') ? 'checked' : '' ?> onclick="proc_search();"> 인기
                                </label>
                                <label>
                                    <input type="checkbox" name="type3" value="1" <?= (element('type3', $view) == '1') ? 'checked' : '' ?> onclick="proc_search();"> 신상품
                                </label>
                                <label>
                                    <input type="checkbox" name="type5" value="1" <?= (element('type5', $view) == '1') ? 'checked' : '' ?> onclick="proc_search();"> 구독
                                </label>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" name="sfield">
                                <?php echo element('search_option', $view); ?>
                            </select>
                            <div class="input-group">
                                <input type="text" class="form-control" name="skeyword" value="<?php echo html_escape(element('skeyword', $view)); ?>" placeholder="Search for..."/>
                                <span class="input-group-btn">
                                    <button class="btn btn-default btn-sm" name="search_submit" type="submit">검색!</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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
						<button type="button" class="btn btn-outline btn-default btn-sm btn-list-update btn-list-selected disabled" data-list-update-url = "<?php echo element('list_update_url', $view); ?>" >선택수정</button>
						<button type="button" class="btn btn-outline btn-default btn-sm btn-list-delete btn-list-selected disabled" data-list-delete-url = "<?php echo element('list_delete_url', $view); ?>" >선택삭제</button>
						<a href="<?php echo element('write_url', $view); ?>" class="btn btn-outline btn-danger btn-sm">상품추가</a>
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
							<th><a href="<?php echo element('cit_key', element('sort', $view)); ?>">상품코드</a></th>
                            <th>카테고리</th>
							<th>이미지</th>
							<th><a href="<?php echo element('cit_name', element('sort', $view)); ?>">트랙명</a></th>
                            <th><a href="<?php echo element('seller_mem_userid', element('sort', $view)); ?>">판매자</a></th>
                            <th>음원파일</th>
                            <th>옵션/가격/재고(판매량)</th>
							<th>장르</th>
                            <th>무드</th>
                            <th>상태</th>
							<th>수정</th>
							<th><input type="checkbox" name="chkall" id="chkall" /></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (element('list', element('data', $view))) {
						foreach (element('list', element('data', $view)) as $result) {
					?>
						<tr>
							<td><a href="<?php echo goto_url(cmall_item_url(html_escape(element('cit_key', $result)))); ?>" target="_blank"><?php echo html_escape(element('cit_key', $result)); ?></a></td>
                            <td style="width:130px;">
                                <?php foreach (element('category', $result) as $cv) { echo '<label class="label label-info">' . html_escape(element('cca_value', $cv)) . '</label> ';} ?>
                                <?php if (element('cit_type1', $result)) { ?><label class="label label-danger">추천</label> <?php } ?>
                                <?php if (element('cit_type2', $result)) { ?><label class="label label-warning">인기</label> <?php } ?>
                                <?php if (element('cit_type3', $result)) { ?><label class="label label-default">신상품</label> <?php } ?>
                                <?php if (element('cit_type4', $result)) { ?><label class="label label-primary">할인</label> <?php } ?>
								<?php if (element('cit_type5', $result)) { ?><label class="label label-success">구독</label> <?php } ?>
                            </td>
							<td>
								<?php if (element('cit_file_1', $result)) {?>
									<a href="<?php echo goto_url(cmall_item_url(html_escape(element('cit_key', $result)))); ?>" target="_blank">
										<img src="<?php echo thumb_url('cmallitem', element('cit_file_1', $result), 80); ?>" alt="<?php echo html_escape(element('cit_name', $result)); ?>" title="<?php echo html_escape(element('cit_name', $result)); ?>" class="thumbnail mg0" style="width:80px;" />
									</a>
								<?php } ?>
							</td>
							<td><?php echo html_escape(element('cit_name', $result)); ?></td>
                            <td><?php echo html_escape(element('seller_mem_nickname', $result)); ?></td>
                            <td><?php echo implode(', ', (element('detail_file', $result))); ?></td>
                            <td><?php echo implode('<br>', (element('detail_info', $result))); ?></td>
                            <td><?php echo element('info_content_1', element('meta', $result)) .' / ' . element('info_content_4', element('meta', $result)) ?></td>
                            <td><?php echo element('info_content_5', element('meta', $result)) ?></td>
							<td>
                                <?= (element('cit_status', $result)) ? '노출중' : '대기' ?><br/>
                                <?= element('cit_start_datetime', $result) ?>
                            </td>
							<td><a href="<?php echo admin_url($this->pagedir); ?>/write/<?php echo element(element('primary_key', $view), $result); ?>?<?php echo $this->input->server('QUERY_STRING', null, ''); ?>" class="btn btn-outline btn-default btn-xs">수정</a></td>
							<td><input type="checkbox" name="chk[]" class="list-chkbox" value="<?php echo element(element('primary_key', $view), $result); ?>" /></td>
						</tr>
					<?php
						}
					}
					if ( ! element('list', element('data', $view))) {
					?>
						<tr>
							<td colspan="14" class="nopost">자료가 없습니다</td>
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
        <div style="margin: 20px 0;">
            <form action="/admin/cmall/cmallitem/bulk_registration" name="bulk-reg" id="bulk-reg" method="post" enctype="multipart/form-data">
                <div style="display: inline-block">대량등록 :</div>
                <div style="display: inline-block;border: 1px solid #DCDCDC;"><input type="file" name="bulk"></div>
                <div style="display: inline-block"><input type="submit" value="등록하기"></div>
            </form>
        </div>
	</div>
</div>
