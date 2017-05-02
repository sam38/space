<div class="detail-filter">
	<ul class="text-center">
		<li <?=($filter == 'all') ? 'class="active"' : ''?>>
			<a href="<?=$url?>/all">
				All <span class="badge pull-right"><?=$total_data?></span>
			</a>
		</li>
		<?php foreach ($upload_meta->result() as $record): ?>
			<li <?=($filter == $record->meta_key) ? 'class="active"' : ''?>>
				<a href="<?=$url . '/' . $record->meta_key?>">
					<?=$record->meta_key?> <span class="badge"><?=$record->meta_value?></span>
				</a>
			</li>
		<?php endforeach ?>
	</ul>	
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1 text-center">
			<?=anchor(base_url(), '<img class="logo" src="' . base_url('assets/img/logo.png') . '" alt="Space in between logo">')?>
		</div>
		<div class="col-sm-10 col-sm-offset-1">
			<ol class="breadcrumb">
				<li><?=anchor(base_url(), 'Home')?></li>
				<li><?=anchor(base_url('uploads'), 'List')?></li>
				<li class="active">Detail</li>
			</ol>

			<div class="panel panel-info upload-detail">
				<div class="panel-heading">
					<?=form_open($url . '/' . $filter, ['method'=>'get'])?>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Search by name or address</span>
						<input type="text" class="form-control" placeholder="Type client's Name or address and Press Enter" aria-describedby="basic-addon1" name="search" value="<?=$keyword?>" required>
						<span class="input-group-addon" id="basic-addon1">
							<?=anchor($url . '/' . $filter, '<i class="fa fa-search"></i> Clear')?>
						</span>
					</div>
					<?=form_close()?>
					<small class="text-muted pull-right">
						<i class="fa fa-list "></i> Total <strong class="text-primary"><?=$total_filter_data?></strong> records.	
					</small>
					<?=$pagination?>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<ul class="list-group">
					<?php foreach ($upload_data->result() as $row): ?>
						<li class="list-group-item">
							<div class="row">
								<div class="col-xs-3">
									<img class="company-logo pull-right" src="<?=$row->logo?>" alt="logo">
								</div>
								<div class="col-xs-9">
									<h4 class="text-primary">
										<i><?=++$sn?>.</i> <?=$row->name?>
									</h4>
									<div class="text-muted">
										<?php 
										echo $row->street;
										echo $row->city != '' ? ', ' . $row->city : '';
										echo $row->suburb != '' ? ', ' . $row->suburb : '';
										echo $row->postcode != '' ? ', ' . $row->postcode : '';
										echo $row->country != '' ? ', ' . $row->country : '';
										?>
									</div>
								</div>
							</div>
						</li>
					<?php endforeach ?>
					</ul>
				</div>
				<div class="panel-footer">
					<?=$pagination?>
				</div>
			</div>
		</div>
	</div>
</div>