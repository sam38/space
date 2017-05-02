<?php
// title of the display page
$title = isset($title) ? $title : 'Space In Between | CSV Processor';

// all css include files
$load_css = [
	'bootstrap.min.css', 
	'font-awesome.min.css', 
	'dropzone.css',
	'style.css'
];

// all javascript include files
$load_js = [
	'jquery.js', 
	'bootstrap.min.js', 
	'dropzone.js',
	'app.js'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$title?></title>
	<link rel="shortcut icon" href="<?=base_url('assets/img/favicon.ico')?>">
	<?php foreach ($load_css as $item): ?>
		<link rel="stylesheet" href="<?=base_url("assets/css/{$item}")?>">
	<?php endforeach ?>
	<?php foreach ($load_js as $item): ?>
		<script src="<?=base_url("assets/js/{$item}")?>"></script>
	<?php endforeach ?>
	<script>function base_url(){return '<?=base_url()?>'}</script>
</head>
<body>