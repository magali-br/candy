<!DOCTYPE html>

<html>
<head>
<title><?php echo $title; ?></title>
 <link rel="stylesheet" href="<?= base_url(); ?>css/template.css"></link> 

<meta charset="utf-8">
</head>

<body>
	<div id="header">
	<?php $this->load->view('utils/header.php'); ?>
	</div>

	<div id="main">
	<?php $this->load->view($main); ?>
	</div>



</body>
</html>  
