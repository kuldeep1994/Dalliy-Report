<?php

$num_columns	= 14;
$can_delete	= $this->auth->has_permission('Dailly_Reports.Reports.Delete');
$can_edit		= $this->auth->has_permission('Dailly_Reports.Reports.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>

	<h3>
		<?php echo lang('dailly_reports_area_title'); ?>
	</h3>
	
  <?php if($this->session->userdata('role_id')=='1') { ?>
	<?php echo form_open($this->uri->uri_string()); ?>
			<div class="search_form">
					<input type="text" name="task_id" placeholder="Please enter taskid or username or project name"></td>
					<input type="submit" name="action_search" value="search" class="btn btn-success"></td>
			</div>
	<?php echo form_close(); ?>
	<?php } ?>
	
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped'>
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('dailly_reports_field_project_name'); ?></th>
					<th><?php echo lang('dailly_reports_field_pms_task_id'); ?></th>
					<th><?php echo lang('dailly_reports_field_task_title'); ?></th>
					<th><?php echo lang('dailly_reports_field_task_description'); ?></th>
					<th><?php echo lang('dailly_reports_field_start_time'); ?></th>
					<th><?php echo lang('dailly_reports_field_end_time'); ?></th>
					<?php if($this->session->userdata('role_id')=='1'){ ?>
					<th><?php echo lang('dailly_reports_field_user_name'); ?></th>
					<?php } ?>
					<th><?php echo lang('dailly_reports_field_status'); ?></th>
					<div class="image_loader">
					<img src="<?php echo site_url();?>/assets/images/loading.gif" style=" width: 20%;z-index: 11111;position: absolute;margin-left: 40%;top: 0%;">
					</div>
					<th><?php echo lang('dailly_reports_column_deleted'); ?></th>
					<th><?php echo lang('dailly_reports_column_created'); ?></th>
					<th><?php echo lang('dailly_reports_column_modified'); ?></th>
					<th><?php echo lang('dailly_reports_column_action'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('dailly_reports_delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->id; ?>' /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/reports/dailly_reports/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->project_name); ?></td>
				<?php else : ?>
					<td><?php e($record->project_name); ?></td>
				<?php endif; ?>
					<td><?php e($record->pms_task_id); ?></td>
					<td><?php e($record->task_title); ?></td>
					<td><?php e($record->task_description); ?></td>
					<td><?php e($record->start_time); ?></td>
					<td><?php e($record->end_time); ?></td>
					<?php if($this->session->userdata('role_id')=='1'){ ?>
					<td><?php e($this->dailly_reports_model->getUserName($record->user_id)); ?></td>
					<?php } ?>
					<td>
					    <?php if($record->status=='Completed') { ?>
					        <span></span>Request Modification</span>
							<?php } if($record->status=='Change Requested') { ?>
								  <span>Modification Request Sent</span>
							<?php } if($record->status=='Updated/Changed') { ?>
								  <span>Modified</span>
							<?php } if(($record->status=='In Progress' and empty($record->end_time)) or ($record->end_time=='0000-00-00 00:00:00')) { ?>
					        <span><?php echo lang('dailly_reports_column_mark_complete'); ?></span>
							<?php } ?>
					</td>
					<td><?php echo $record->deleted > 0 ? lang('dailly_reports_true') : lang('dailly_reports_false'); ?></td>
					<td><?php e($record->created_on); ?></td>
					<td><?php e($record->modified_on); ?></td>
					<td>
					    <?php if($record->status=='Completed') { ?>
					        <span class="requested" data-task_id="<?php e($record->id); ?>">Request Modification</span>
							<?php } if($record->status=='Change Requested') { ?>
								  <span>Modification Request Sent</span>
							<?php } if($record->status=='Updated/Changed') { ?>
								  <span>Modified</span>
							<?php } if(($record->status=='In Progress' and empty($record->end_time)) or $record->end_time=='0000-00-00 00:00:00') { ?>
					        <button type="button" class="btn btn-success mark_complete" data-start_time="<?php e($record->start_time); ?>" data-task_id="<?php e($record->id); ?>"><?php echo lang('dailly_reports_column_mark_complete'); ?></button>
							<?php } ?>
					</td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('dailly_reports_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    echo $this->pagination->create_links();
    ?>
</div>
<style>
.error_msg{   
	color: red;
  font-size: 15px;
}
.modal.fade {
    top:15% !important;
}
button.btn.btn-success.mark_complete {
    font-size: 12px;
    padding: 0px 0px 0px 0px;
}
.requested{
	cursor: pointer;
}
.image_loader{display:none}
.search_form{
    display: flex;
    justify-content: flex-end;
    align-items: baseline;
		-webkit-justify-content: flex-end;
    -webkit-align-items: baseline;
		-moz-justify-content: flex-end;
    -moz-align-items: baseline;
}
.search_form .btn-success{
   border-radius:0px;
}
.search_form input{border-radius:0px;}
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>

$(document).ready(function() {

	var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';

    $('.mark_complete').click(function(){

		$('.error_msg').html('');
		$('#task_id').val($(this).data('task_id'));
		$('#start_time').val($(this).data('start_time'));
		$('#myModal').modal('show');

		$('.save').click(function(){

			var task_id = $('#task_id').val();
			var end_time = $('#end_time').val();
			$('.error_msg').html('');
			if(end_time==''){
				$('.error_msg').html('Please enter end date');
			}
			else{
				$.ajax({
						type:'POST',
						dataType:'json',
						url: '<?php echo site_url(SITE_AREA) ?>/reports/dailly_reports/markCompleted',
						data: {'ci_csrf_token':csrf_token,'task_id':task_id,'end_time':end_time},
						success:function(response)
						{
							csrf_token = response.token;
							if(response.error!=''){
								$('.error_msg').html(response.error);
							}
							else{
								$('.success_msg').html('<div class="alert alert-success"><strong>Success!</strong> End Time Updated Successfully</div>');
								setTimeout(function(){ 
									location.reload(); 
								}, 1500);
							}
						}
				});
			}
	    });
	});

	$('.requested').click(function(){

  	var task_id = $(this).data('task_id');
    $.ajax({
						type:'POST',
						dataType:'json',
						url: '<?php echo site_url(SITE_AREA) ?>/reports/dailly_reports/changeRequested',
						data: {'ci_csrf_token':csrf_token,'task_id':task_id},
						beforeSend: function(response){
							$(".image_loader").show();
						},
						success:function(response){
							csrf_token = response.token;
							if(response.msg=='done'){
								setTimeout(function(){ 
									$(".image_loader").hide();
									location.reload(); 
								}, 1500);
							}
						}
				});
	});

});
</script>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update mark completed</h4>
        </div>
        <div class="modal-body">
		    <div class="success_msg"></div>
		    <input type="hidden" name="task_id" id="task_id">
            <p> 
		      <?php echo form_label(lang('dailly_reports_field_start_time'), 'status', array('class' => 'control-label')); ?>
		      <input type="text" readonly name="start_time" id="start_time">
		    </p>
		    <p> 
		      <?php echo form_label(lang('dailly_reports_field_end_time'), 'status', array('class' => 'control-label')); ?>
		      <input type="text" name="end_time" id="end_time">
			  <div class="error_msg"></div>
		    </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary save">Save</button>
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
