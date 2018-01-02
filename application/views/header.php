<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php echo $title ?></title>
	<link rel="stylesheet" href="<?php baseUrl('css'); ?>/styles.css" />
</head>
<body>
	<div id="contents">		
		<div id="navigation">
		<?php if(count($linkBuilder->getTrail()) > 1) { 
		    linkbuilder($linkBuilder->getTrail()); } ?>
		</div>