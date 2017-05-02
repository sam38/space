<div class="container">
	<div class="row">
		<div class="col-sm-12 text-center">
			<?=anchor(base_url(), '<img class="logo" src="' . base_url('assets/img/logo.png') . '" alt="Space in between logo">')?>
		</div>
		<div class="col-sm-12">
			<ol class="breadcrumb">
				<li><?=anchor(base_url(), 'Home')?></li>
				<li class="active">List</li>
			</ol>

			<ul class="history-list">
				<?php foreach ($records->result() as $record): ?>
				<li class="col-sm-3 col-md-2">
					<?=anchor('csv/view/' . $record->id . '/' . url_title(strtolower($record->title)).'/all', $record->title)?>
				</li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
</div>