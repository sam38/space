<div class="panel panel-default panel-home-form">
	<div class="panel-heading">
		<i class="fa fa-upload"></i> Upload CSV
		<span class="pull-right btn-cancel-form">
			<i class="fa fa-remove"></i>
		</span>
	</div>
	<div class="panel-body">
		<div id="csv_upload_dropzone-x" class="hidden">Drop or Click here to Upload CSV file!</div>
		<?php echo @$error;?>
		<?php echo form_open_multipart('csv/upload');?>
		<input type="file" name="file" required />
		<br /><br />
		<button class="btn btn-info btn-sm">
			<i class="fa fa-floppy"></i> Upload
		</button>
	</div>
	<div class="panel-footer">
		<strong>
			The file must be .csv format and less than 5MB.
		</strong><br>
		<div class="text-muted text-center">
			*The format of the file must be CSV, which follows the following column sequence:
		</div>
		<ol class="column-template text-muted">
			<li>Name</li>
			<li>URL</li>
			<li>Logo</li>
			<li>Street</li>
			<li>City</li>
			<li>Suburb</li>
			<li>Postcode</li>
			<li>Country</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>