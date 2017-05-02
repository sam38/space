<div class="container">
	<div class="row">
		<div class="col-sm-12 text-center">
			<img class="logo" src="<?=base_url('assets/img/logo.png')?>" alt="Space in between logo">
		</div>

		<div class="col-sm-8 col-sm-offset-2 section-form">
			<?php if (isset($errors)): ?>
			<div class="alert alert-danger" role="alert">
				<?php 
				$br = '';				
				foreach (@$errors as $error): 
					echo $br . $error;
					$br = '<br />';
				endforeach;				
				?>
			</div>
			<?php endif; ?>
			<?php include('application/views/include/upload_csv.php') ?>
		</div>
	</div>
</div>