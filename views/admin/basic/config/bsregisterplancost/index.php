<div class="box">
	<div class="box-table">

		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open(current_full_url(), $attributes);
		?>
			<div class="alert alert-info">
				회원 가입 금액 플랜 정책
			</div>

			<div class="table-responsive">
				<table class="table table-hover table-striped">
					<colgroup>
						<col class="col-md-2">
						<col class="col-md-2">
                        <col class="col-md-2">
                        <col class="col-md-2">
                        <col class="col-md-2">
					</colgroup>
                    <thead>
                        <tr>
                            <th>플랜</th>
                            <th>월금액</th>
                            <th>연금액</th>
                            <th>연할인율</th>
                            <th>연할인금액</th>
                        </tr>
                    </thead>
					<tbody>
						<tr>
							<td >
                                <div class="pull-right">MARKETPLACE</div>
                                <input type="hidden" name="m_plan" value="MARKETPLACE">
                            </td>
                            <td>
                                <div>
                                    <input type="number" name="m_monthly" class="form-control" value="<?php echo set_value('m_monthly', element('monthly', element('data', $view)[0])); ?>" />원
                                </div>
                                <div>
                                    <input type="number" name="m_monthly_d" class="form-control" value="<?php echo set_value('m_monthly_d', element('monthly_d', element('data', $view)[0])); ?>" />$
                                </div>
                            </td>
                            <td>
                                <div>
                                    <input type="number" name="m_yearly" class="form-control" value="<?php echo set_value('m_yearly', element('yearly', element('data', $view)[0])); ?>" />원
                                </div>
                                <div>
                                    <input type="number" name="m_yearly_d" class="form-control" value="<?php echo set_value('m_yearly_d', element('yearly_d', element('data', $view)[0])); ?>" />$
                                </div>
                            </td>
                            <td>
                                <div>
                                    <input type="number" name="m_yearly_discount_pc" class="form-control" value="<?php echo set_value('m_yearly_discount_pc', element('yearly_discount_pc', element('data', $view)[0])); ?>" />%
                                </div>
                            </td>
                            <td>
                                <div>
                                    <input type="number" name="m_yearly_discount_amt" class="form-control" value="<?php echo set_value('m_yearly_discount_amt', element('yearly_discount_amt', element('data', $view)[0])); ?>" />원
                                </div>
                                <div>
                                    <input type="number" name="m_yearly_discount_amt_d" class="form-control" value="<?php echo set_value('m_yearly_discount_amt_d', element('yearly_discount_amt_d', element('data', $view)[0])); ?>" />$
                                </div>
                            </td>
						</tr>
                        <tr>
                            <td>
                                <div class="pull-right">PRO PAGE</div>
                                <input type="hidden" name="p_plan" value="PRO PAGE">
                            </td>
                            <td>
                                <div>
                                    <input type="number" name="p_monthly" class="form-control" value="<?php echo set_value('p_monthly', element('monthly', element('data', $view)[1])); ?>" />원
                                </div>
                                <div>
                                    <input type="number" name="p_monthly_d" class="form-control" value="<?php echo set_value('p_monthly_d', element('monthly_d', element('data', $view)[1])); ?>" />$
                                </div>
                            </td>
                            <td>
                                <div>
                                    <input type="number" name="p_yearly" class="form-control" value="<?php echo set_value('p_yearly', element('yearly', element('data', $view)[1])); ?>" />원
                                </div>
                                <div>
                                    <input type="number" name="p_yearly_d" class="form-control" value="<?php echo set_value('p_yearly_d', element('yearly_d', element('data', $view)[1])); ?>" />$
                                </div>
                            </td>
                            <td>
                                <div>
                                    <input type="number" name="p_yearly_discount_pc" class="form-control" value="<?php echo set_value('p_yearly_discount_pc', element('yearly_discount_pc', element('data', $view)[1])); ?>" />%
                                </div>
                            </td>
                            <td>
                                <div>
                                    <input type="number" name="p_yearly_discount_amt" class="form-control" value="<?php echo set_value('p_yearly_discount_amt', element('yearly_discount_amt', element('data', $view)[1])); ?>" />원
                                </div>
                                <div>
                                    <input type="number" name="p_yearly_discount_amt_d" class="form-control" value="<?php echo set_value('p_yearly_discount_amt_d', element('yearly_discount_amt_d', element('data', $view)[1])); ?>" />$
                                </div>
                            </td>
                        </tr>

					</tbody>
				</table>
			</div>
			<div class="btn-group pull-right" role="group" aria-label="...">
				<button type="submit" class="btn btn-success btn-sm">저장</button>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
$(function() {
	$('#fadminwrite').validate({
		rules: {
            monthly: {required:true},
            monthly_d: {required:true},
		}
	});
});
//]]>
</script>
