<div class="box">
	<div class="box-table">

		<?php
		echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
		echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
		$attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
		echo form_open(current_full_url(), $attributes);
		?>
			<div class="table-responsive">
				<table class="table table-hover table-striped">
					<colgroup>
						<col class="col-md-2">
						<col class="col-md-2">
                        <col class="col-md-2">
                        <col class="col-md-2">
					</colgroup>
                    <thead>
                        <tr>
                            <th>KRW</th>
                            <th>USD</th>
                            <th>JPY</th>
                            <th>CNY</th>
                        </tr>
                    </thead>
					<tbody>
						<tr>
                            <td>
                                <input type="number" name="krw" class="form-control" value="<?php echo set_value('krw', element('krw', element('data', $view))); ?>"/>
                            </td>
                            <td>
                                <input type="number" name="usd" class="form-control" value="<?php echo set_value('usd', element('usd', element('data', $view))); ?>"/>
                            </td>
                            <td>
                                <input type="number" name="jpy" class="form-control" value="<?php echo set_value('jpy', element('jpy', element('data', $view))); ?>"/>
                            </td>
                            <td>
                                <input type="number" name="cny" class="form-control" value="<?php echo set_value('cny', element('cny', element('data', $view))); ?>"/>
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
            krw: {required:true},
            usd: {required:true},
            jpy: {required:true},
            cny: {required:true},
		}
	});
});
//]]>
</script>
