<div class="row">
	<div class="col-lg-6 col-lg-offset-3">
<?php echo validation_errors(); ?>
<?php echo form_open('/signup/settings'); ?>
<?php echo form_input($signup_email); ?><br />
<?php echo form_checkbox($signup_opt1) . $this->lang->line('signup_opt1'); ?><br />
<?php echo form_checkbox($signup_opt2) . $this->lang->line('signup_opt2'); ?><br />
<?php echo form_checkbox($signup_unsub) . $this->lang->line('signup_unsub'); ?><br />
<?php echo form_submit('', $this->lang->line('common_form_elements_go'), 'class="btn btn-default"'); ?><br />
<?php echo form_close(); ?>
	</div>
</div>