<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('dailly_reports_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($dailly_reports->id) ? $dailly_reports->id : '';

?>
<div class='admin-box'>
    <h3>Dailly Reports</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('project_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('dailly_reports_field_project_name') . lang('bf_form_label_required'), 'project_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='project_name' type='text' required='required' name='project_name' maxlength='150' value="<?php echo set_value('project_name', isset($dailly_reports->project_name) ? $dailly_reports->project_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('project_name'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('pms_task_id') ? ' error' : ''; ?>">
                <?php echo form_label(lang('dailly_reports_field_pms_task_id') . lang('bf_form_label_required'), 'pms_task_id', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='pms_task_id' type='text' required='required' name='pms_task_id' maxlength='50' value="<?php echo set_value('pms_task_id', isset($dailly_reports->pms_task_id) ? $dailly_reports->pms_task_id : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('pms_task_id'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('task_title') ? ' error' : ''; ?>">
                <?php echo form_label(lang('dailly_reports_field_task_title') . lang('bf_form_label_required'), 'task_title', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='task_title' type='text' required='required' name='task_title' maxlength='50' value="<?php echo set_value('task_title', isset($dailly_reports->task_title) ? $dailly_reports->task_title : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('task_title'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('task_description') ? ' error' : ''; ?>">
                <?php echo form_label(lang('dailly_reports_field_task_description') . lang('bf_form_label_required'), 'task_description', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='task_description' type='text' required='required' name='task_description' maxlength='255' value="<?php echo set_value('task_description', isset($dailly_reports->task_description) ? $dailly_reports->task_description : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('task_description'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('start_time') ? ' error' : ''; ?>">
                <?php echo form_label(lang('dailly_reports_field_start_time') . lang('bf_form_label_required'), 'start_time', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='start_time' type='text' required='required' name='start_time' maxlength='30' value="<?php echo set_value('start_time', isset($dailly_reports->start_time) ? $dailly_reports->start_time : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('start_time'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('end_time') ? ' error' : ''; ?>">
                <?php echo form_label(lang('dailly_reports_field_end_time'), 'end_time', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='end_time' type='text' name='end_time' maxlength='30' value="<?php echo set_value('end_time', isset($dailly_reports->end_time) ? $dailly_reports->end_time : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('end_time'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('status') ? ' error' : ''; ?> hidden_class">
                <?php echo form_label(lang('dailly_reports_field_status'), 'status', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='status' type='hidden' name='status' maxlength='30' value="Updated/Changed" />
                    <span class='help-inline'><?php echo form_error('status'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('dailly_reports_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/reports/dailly_reports', lang('dailly_reports_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Dailly_Reports.Reports.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('dailly_reports_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('dailly_reports_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>

<style>
.hidden_class{display:none}
</style>