<?php
	$titre = "";
	if ($_SERVER['PHP_SELF'] != "/kanban/" && $_SERVER['PHP_SELF'] != "/kanban/index.php")
	{
		switch ($page)
		{
			case "user":
				$ariane = '<a href="javascript:void(0)">Users</a> &rsaquo; <a href="javascript:void(0)">Liste</a>';
				$titre = "Users";
				break;
			case "project":
				$ariane = '<a href="javascript:void(0)">Projects</a> &rsaquo; <a href="javascript:void(0)">Liste</a>';
				$titre = "Projects";
				break;
			case "category":
				$ariane = '<a href="javascript:void(0)">Categories</a> &rsaquo; <a href="javascript:void(0)">Liste</a>';
				$titre = "Categories";
				break;
			case "state":
				$ariane = '<a href="javascript:void(0)">States</a> &rsaquo; <a href="javascript:void(0)">Liste</a>';
				$titre = "States";
				break;	
			case "step":
				$ariane = '<a href="javascript:void(0)">Steps</a> &rsaquo; <a href="javascript:void(0)">Liste</a>';
				$titre = "Steps";
				break;				
		}
	}
?>
<html>
	<head>
        <meta charset="utf-8">
        <title></title>
        <meta name="description" content="">
        
		<link rel="stylesheet" href="css/main.css">

        <link rel="stylesheet" href="http://code.jquery.com/ui/1.8.1/themes/base/jquery-ui.css" />
        <link type="text/css" href="http://code.jquery.com/ui/1.8.1/themes/base/jquery.ui.datepicker.css" />

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/i18n/jquery.ui.datepicker-fr.min.js"></script>

        <style type="text/css">
            .ui-datepicker
            {
                z-index: 100002;
            }
        </style>
		
		<script language="javascript" src="js/main_control.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
		<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
		<link rel="stylesheet" type="text/css" media="screen" href="css/tablesorter.css" />
				
	</head>
	
	<body>
		<div id="wrapper" class="<?php echo $class; ?>">
			<div id="header">
				<div id="head_left">
					<p id="titre"><img src="images/kanban.gif" alt="logo" style="margin-top:5px;" /></p>
					<div id="menu">
						<a href="javascript:void(0)" id="menu_launcher">Liste des menus</a>
						<?php include('include/menu.php'); ?>
					</div>
				</div>
				<div id="head_right">
					<a href="deconnexion.php" id="deconnect">Se d&eacute;connecter</a>
					
					<?php
						if ($ariane != "")
						{
					?>
					<p id="fil_ariane">&bull; <?php echo $ariane; ?></p>
					<?php
						}
					?>
				</div>
			</div>
			<div id="content">
				<p id="le_titre"><?php echo $titre; ?></p>