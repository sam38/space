<div class="container">
	<div class="row">
		<div class="col-sm-12 text-center">
			<img class="logo" src="<?=base_url('assets/img/logo.png')?>" alt="Space in between logo">
			<div class="text-muted section-default home-options-help">
				Select one of the two options.
			</div>
		</div>

		<div class="col-sm-6 text-right section-default">
			<button type="button" class="btn btn-lg btn-success btn-xl btn_show_form">
				<i class="fa fa-upload"></i> Upload CSV
			</button>
		</div>
		<div class="col-sm-6 section-default">
			<a href="<?=base_url('uploads')?>" class="btn btn-lg btn-warning btn-xl btn_link_history" data-history-count="<?=$total_uploads?>">
				<i class="fa fa-history"></i> View History
			</a>
		</div>

		<div class="col-sm-8 col-sm-offset-2 section-form hidden">
			<?php include('application/views/include/upload_csv.php') ?>
		</div>
	</div>
</div>
<script>$(app.initHome)</script>